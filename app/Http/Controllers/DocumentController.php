<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Documents;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MsWordToImageConvert;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;
use Staticall\Petrovich\Petrovich;
use Staticall\Petrovich\Petrovich\Loader;
use Staticall\Petrovich\Petrovich\Ruleset;
use Spatie\PdfToImage\Pdf;

class DocumentController extends Controller
{
    public static function numToStr($num)
    {

        function morph($n, $f1, $f2, $f5)
        {
            $n = abs(intval($n)) % 100;
            if ($n > 10 && $n < 20) return $f5;
            $n = $n % 10;
            if ($n > 1 && $n < 5) return $f2;
            if ($n == 1) return $f1;
            return $f5;
        }

        $nul = 'ноль';
        $ten = array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
        );
        $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
        $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
        $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
        $unit = array( // Units
            array('копейка', 'копейки', 'копеек',     1),
            array('рубль', 'рубля', 'рублей', 0),
            array('тысяча', 'тысячи', 'тысяч', 1),
            array('миллион', 'миллиона', 'миллионов', 0),
            array('миллиард', 'милиарда', 'миллиардов', 0),
        );
        //
        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v)) continue;
                $uk = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
                else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1) $out[] = morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
            } //foreach
        } else $out[] = $nul;
        return number_format($num, 2, ',', ' ') . " (" . trim(preg_replace('/ {2,}/', ' ', join(' ', $out))) . ") руб. " . "$kop коп.";
    }


    static public function daysText($days)
    {
        $days = (int)$days;
        if (($days <= 20 and $days >= 5) or $days % 10 > 4 or $days % 10 == 0) {
            return "$days дней";
        } elseif ($days % 10 == 1) {
            return "$days день";
        } else {
            return "$days дня";
        }
    }

    static public function dateToDocumentFormat($date)
    {
        $arr = [
            'января',
            'февраля',
            'марта',
            'апреля',
            'мая',
            'июня',
            'июля',
            'августа',
            'сентября',
            'октября',
            'ноября',
            'декабря'
        ];

        $month = $arr[date('n', strtotime($date)) - 1];
        $newDate = date("«d» $month Y года", strtotime($date));

        return $newDate;
    }

    static public function morphTo($fio, $case)
    {
        $cases = [
            "im" => Ruleset::CASE_NOMENATIVE,
            "rod" => Ruleset::CASE_GENITIVE,
            "dat" => Ruleset::CASE_DATIVE,
            "vin" => Ruleset::CASE_ACCUSATIVE,
            "tvor" => Ruleset::CASE_INSTRUMENTAL,
            "pred" => Ruleset::CASE_PREPOSITIONAL,
        ];

        $fioComponents = explode(" ", $fio);

        $firstname = $fioComponents[1];
        $middlename = $fioComponents[2];
        $lastname = $fioComponents[0];

        $gender = Petrovich::detectGender($middlename);

        $petrovich = new Petrovich(Loader::load(base_path() . "/vendor/cloudloyalty/petrovich-rules/rules.json"));

        $firstname = $petrovich->inflectFirstName($firstname, $cases[$case], $gender);
        $middlename = $petrovich->inflectMiddleName($middlename, $cases[$case], $gender);
        $lastname = $petrovich->inflectLastName($lastname, $cases[$case], $gender);

        return "$lastname $firstname $middlename";
    }

    static public function shortFio($fio)
    {
        $fioComponents = explode(" ", $fio);
        $firstname = mb_substr($fioComponents[1], 0, 1);
        $middlename = mb_substr($fioComponents[2], 0, 1);
        $lastname = $fioComponents[0];

        return "$firstname.$middlename. $lastname";
    }

    static public function documentByTemplate($template, $data, $application, $images = [], $complex = [])
    {
        $phpWord = new PhpWord();
        $doc = new TemplateProcessor($template);

        foreach ($data as $key => $value) {
            $doc->setValue($key, $value);
        }

        foreach ($images as $key => $value) {
            $doc->setImageValue($key, $value);
        }

        foreach ($complex as $key => $value) {
            $doc->setComplexValue($key, $value);
        }

        $outFilenameBase = storage_path() . "/app/documents/" . md5(uniqid() . strtotime("now"));
        $outFilename = $outFilenameBase . ".docx";
        $outDirectory = storage_path() . "/app/documents/";
        $doc->saveAs($outFilename);

        // shell_exec("libreoffice --headless --convert-to pdf $outFilename --outdir $outDirectory");
        // $outFilename = $outFilenameBase . ".pdf";
        // $path = base_path() . '/vendor/mpdf';
        // Settings::setPdfRendererPath($path);
        // Settings::setPdfRendererName(Settings::PDF_RENDERER_MPDF);
        // $reader = IOFactory::createReader('Word2007');
        // $phpWord = $reader->load($outFilename);
        // $xmlWriter = IOFactory::createWriter($phpWord, 'PDF');

        // $outFilename2 = $outFilenameBase . "gggpython.pdf";
        // // $xmlWriter->save($outFilename);


        $code = md5(strtotime("now") . uniqid());

        $document = Documents::create([
            'document_path' => $outFilename,
            'application_id' => $application->id,
            'code' => Hash::make($code),
            'available' => true
        ]);

        return [
            'code' => $code,
            'document_id' => $document->id
        ];
    }

    public function get(Application $application)
    {
        $user = Auth::user();
        $document = Documents::where('application_id', '=', $application->id)->orderBy('id', 'desc')->first();

        $service = Service::find($application->service_id);
        $date = date('Y-m-d H:i:s', strtotime('now'));
        // dd($document, $document->available, $application->user_id == $user->id, $application->confirmed);

        if ($document and $document->available and $application->user_id == $user->id and $application->confirmed and $application->payed) {

            $headers = ['Content-Type: application/msword'];

            return response()->download($document->document_path, "$service->name $user->name $date.docx", $headers);
            // $convert = new MsWordToImageConvert($apiUser, $apiKey);
            // $convert->fromURL('http://mswordtoimage.com/docs/demo.doc');
            // $base64String = $convert->toBase46EncodedString();
            // echo "<img src='data:image/jpeg;base64,$base64String' />";
        } else {
            $outFilename = $document->document_path;
            $outFilenameBase = str_replace(".docx", "", $outFilename);

            $outDirectory = storage_path() . "/app/documents/";
            shell_exec("libreoffice --headless --convert-to pdf $outFilename --outdir $outDirectory");
            $outFilename = $outFilenameBase . ".pdf";

            // dd($outFilename);
            $pdf = new Pdf($outFilename);
            $img = storage_path() . "/app/documents/1.jpg";
            $pdf->saveImage($img);

            // echo mime_content_type($img);
            // $img = $document->document_path . ".pdf.png";

            $im = imagecreatefromjpeg($img);

            $w = imagesx($im);
            $h = (int)(imagesy($im) / 3);

            $im2 = imagecrop($im, ['x' => 0, 'y' => $h, 'width' => $w, 'height' => $h * 2]);

            imagefilter($im2, IMG_FILTER_PIXELATE, 10);

            imagecopy($im, $im2, 0, $h, 0, 0, $w, $h * 2);

            imagepng($im, $img);
            imagedestroy($im);

            // $headers = array(
            //     'Content-Type: image/jpg',
            // );
            // return response()->download($img, "f.png", $headers);

            $path = $img;
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            return view('pages.interactive', ['img' => $base64, 'application' => $application, 'service' => $service]);
        }
    }

    public function setAvailable(Documents $document)
    {
        $user = Auth::user();
        $application = Application::find($document->application_id);

        if ($document and $application->user_id == $user->id and $application->confirmed) {
            $document->available = true;
            $document->save();
            $application->nextStatus();

            return redirect()->to(route('account.applications'));
        } else {
            echo 'error';
        }
    }

    static public function getAddressRegion($addr)
    {
        return ApiController::getAddressRegion($addr);
    }

    static public function standartAddress($addr)
    {
        return ApiController::standartAddress($addr);
    }

    static public function getCourtMoscow($addr)
    {
        return ApiController::getCourtMoscow($addr);
    }

    static public function getCourtDebex($addr)
    {
        return ApiController::getCourtDebex($addr);
    }

    static public function getCourtRussia($addr)
    {
        return ApiController::getCourtRussia($addr);
    }

    static public function getCourt($addr)
    {
        return ApiController::getCourt($addr);
    }

    static public function getRate(Request $request)
    {
        return ApiController::getRate($request);
    }
}
