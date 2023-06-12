<?php

namespace App\DocumentHandlers;

use Spatie\PdfToImage\Pdf;
use Staticall\Petrovich\Petrovich;
use Staticall\Petrovich\Petrovich\Loader;
use Staticall\Petrovich\Petrovich\Ruleset;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;

abstract class BaseDocumentHandler
{

    private $months = [
        'января', 'февраля', 'марта', 'апреля',
        'мая', 'июня', 'июля', 'августа',
        'сентября', 'октября', 'ноября', 'декабря',
    ];

    private function convertDateToDocFormat(string $date): string
    {

        $month = $this->months[date('n', strtotime($date)) - 1];
        $newDate = date("«d» $month Y года", strtotime($date));
        return $newDate;
    }

    // Склонение ФИО по падежам
    private function morphTo(string $fio, string $case)
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
    //Сокращение ФИО до Фамилия.И.О
    private function shortFio(string $fio): string
    {
        $fioComponents = explode(" ", $fio);
        $firstname = mb_substr($fioComponents[1], 0, 1);
        $middlename = mb_substr($fioComponents[2], 0, 1);
        $lastname = $fioComponents[0];

        return "$firstname.$middlename. $lastname";
    }
    //Делаем превью для докмента , дял вывода его пользователю
    private function pdfToImg(string $filename): string
    {
        $filename = str_replace("https://xn--h1aeu.xn--80asehdb/storage/", storage_path() . "/app/public/", $filename);

        $outfilename = $filename;

        if (mime_content_type($filename) == 'application/pdf') {
            $outfilename = storage_path() . "/app/public/" . md5($filename) . ".jpg";
            $pdf = new Pdf($filename);
            $pdf->saveImage($outfilename);
        }

        return $outfilename;
    }
    // Morph для суммы
    private function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) {
            return $f5;
        }

        $n = $n % 10;
        if ($n > 1 && $n < 5) {
            return $f2;
        }

        if ($n == 1) {
            return $f1;
        }

        return $f5;
    }

    // Сумма в строку
    public function numToStr($num)
    {
        $nul = 'ноль';
        $ten = array(
            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
        );
        $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
        $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
        $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
        $unit = array( // Units
            array('копейка', 'копейки', 'копеек', 1),
            array('рубль', 'рубля', 'рублей', 0),
            array('тысяча', 'тысячи', 'тысяч', 1),
            array('миллион', 'миллиона', 'миллионов', 0),
            array('миллиард', 'милиарда', 'миллиардов', 0),
        );
        //
        list($rub, $kop) = explode('.', sprintf("%015.2f", $num));
        $out = array();
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v)) {
                    continue;
                }
                $uk = count($unit) - $uk - 1; // unit key
                if ($uk > -1) {
                    $gender = $unit[$uk][3];
                    $splitV = str_split($v);
                    if (!array_key_exists(0, $splitV)) {
                        break;
                    }
                    if (!array_key_exists(1, $splitV)) {
                        break;
                    }
                    if (!array_key_exists(2, $splitV)) {
                        break;
                    }
                    $i1 = $splitV[0];
                    $i2 = $splitV[1];
                    $i3 = $splitV[2];
                    // mega-logic
                    $out[] = $hundred[$i1]; # 1xx-9xx
                    if ($i2 > 1) {
                        $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
                    } else {
                        $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3];
                    }
                    if ($uk > 1) {
                        $out[] = $this->morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
                    }

                } else {
                    break;
                }
            } //foreach
        } else {
            $out[] = $nul;
        }

        return number_format($num, 2, ',', ' ') . " (" . trim(preg_replace('/ {2,}/', ' ', join(' ', $out))) . ") руб. " . "$kop коп.";
    }

    public function prepareAreaText($text, $replacements = [])
    {

        // Замена смертельно опасных пробелов)
        $newText = htmlentities($text);
        $newText = str_replace("&amp;nbsp;", " ", $newText);

        // Замены для дублируемых групп
        foreach ($replacements as $repl => $res) {
            $newText = str_replace("($repl", "($res", $newText);
        }

        // Замена переменных по именам
        $values = $this->data->toArray();
        foreach ($values as $key => $value) {
            if ($key != "aliases") {
                $newText = str_replace("($key)", $value, $newText);
            }
        }

        return $newText;
    }

    // Использовать шаблон
    public function useTemplate($folder, $application, $template)
    {
        $documentData = $this->documentByTemplate($folder . "/$template", $this->data->all(), $application, $this->images, $this->complex);
        return $documentData;
    }

    public function documentByTemplate($template, $data, $application, $images = [], $complex = [])
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

        $code = md5(strtotime("now") . uniqid());

        ;
    }

}
