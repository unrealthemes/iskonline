<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ServiceController;
use App\Models\DocumentArea;
use App\Models\FormUiInput;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\PhpWord;
use Staticall\Petrovich\Petrovich;
use Staticall\Petrovich\Petrovich\Loader;
use Staticall\Petrovich\Petrovich\Ruleset;
use Spatie\PdfToImage\Pdf;

class DocumentHandler
{
    function __construct($data, $service)
    {
        $this->data = $data;
        $this->images = [];
        $this->complex = [];
        $this->service = Service::find($service);
    }

    // Дату в вид «чч» месяц год
    public function dateToDocumentFormat($date)
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

    // Обработка даты
    public function handleDate($input, $name, $value)
    {
        $this->data[$name] = $this->dateToDocumentFormat($value);
    }

    // Склонение ФИО по падежам
    public function morphTo($fio, $case)
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

    // Краткое ФИО
    public function shortFio($fio)
    {
        $fioComponents = explode(" ", $fio);
        $firstname = mb_substr($fioComponents[1], 0, 1);
        $middlename = mb_substr($fioComponents[2], 0, 1);
        $lastname = $fioComponents[0];

        return "$firstname.$middlename. $lastname";
    }

    // Обработка ФИО
    public function handleFio($input, $name, $value)
    {
        $cases = ["im", "rod", "dat", "vin", "tvor", "pred"];
        foreach ($cases as $case) {
            try {
                $this->data[$name . ":" . $case] = $this->morphTo($value, $case);
            } catch (Exception $e) {
                $this->data[$name . ":" . $case] = $value;
            }
        }

        try {
            $this->data[$name . ":short"] = $this->shortFio($value);
        } catch (Exception $e) {
            $this->data[$name . ":short"] = $value;
        }
    }

    function pdfToImg($filename)
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

    // Обработка файла
    public function handleFile($input, $name, $value)
    {
        try {
            $path = $this->pdfToImg($value);
            $this->images[$name] = ['path' => $path, 'width' => 500, 'height' => 500];
            unset($this->data[$name]);
        } catch (Exception $e) {
        }
    }

    // Обработка подписи
    public function handleSign($input, $name, $value)
    {
        try {
            $path = $this->pdfToImg($value);
            $this->images[$name] = ['path' => $path, 'width' => 80, 'height' => 60];
            unset($this->data[$name]);
        } catch (Exception $e) {
        }
    }

    // Обработка числа
    public function handleNumber($input, $name, $value)
    {
        // Вывод в формате денег
        $this->data[$name . ":money"] = $this->numToStr($value);
    }

    // Обработка чекбокса
    public function handleCheckbox($input, $name, $value)
    {
        // Перевод в числа
        $this->data[$name] = $value;
    }

    // Morph для суммы
    function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) return $f5;
        $n = $n % 10;
        if ($n > 1 && $n < 5) return $f2;
        if ($n == 1) return $f1;
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
                if ($uk > -1) {
                    $gender = $unit[$uk][3];
                    list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                    // mega-logic
                    $out[] = $hundred[$i1]; # 1xx-9xx
                    if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; # 20-99
                    else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
                    // units without rub & kop
                    if ($uk > 1) $out[] = $this->morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
                } else {
                    break;
                }
            } //foreach
        } else $out[] = $nul;
        return number_format($num, 2, ',', ' ') . " (" . trim(preg_replace('/ {2,}/', ' ', join(' ', $out))) . ") руб. " . "$kop коп.";
    }

    public function useAreas()
    {
        $areas = DocumentArea::where('service_id', '=', $this->service->id)->get();

        $this->complex = [];
        foreach ($areas as $area) {
            $areas = json_decode($area->areas, true);

            $block = new TextRun([]);
            $this->parseArea($block, $areas);

            $this->complex[$area->name] = $block;
        }

        // dd($this->complex);
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

        // var_dump($newText);
        return $newText;
    }

    public function checkGroupCloningLength($group)
    {
        $values = $this->data->toArray();

        $isset = true;
        $i = 0;

        while ($isset) {
            $isset = false;
            $finding = $i > 0 ? $group . "__" . $i : $group;
            foreach ($values as $key => $value) {
                if (str_contains($key, $finding)) {
                    $isset = true;
                }
            }

            if ($isset) {
                $i += 1;
            }
        }

        return $i;
    }

    public function parseArea($block, $areas, $replacements = [])
    {

        foreach ($areas as $area) {
            switch ($area['type']) {
                case "text":
                    $block->addText($this->prepareAreaText($area['area'], $replacements), ['name' => "Times New Roman", "size" => 12]);
                    break;

                case "paragraph":

                    $block->addTextBreak(1, [], []);
                    $block->addText($this->prepareAreaText($area['area'], $replacements), ['name' => "Times New Roman", "size" => 12]);
                    break;

                case "if":
                    if ($this->data[$area['options']['input']] == $area['options']['value']) {
                        $this->parseArea($block, $area['area'], $replacements);
                    }
                    break;

                case "foreach":
                    $count = $this->checkGroupCloningLength($area['options']['group']);

                    for ($i = 0; $i < $count; $i++) {
                        if ($i > 0) {
                            $block->addText(", ", ['name' => "Times New Roman", "size" => 12]);
                        }
                        $newReplacements = $replacements;
                        $newReplacements[$area['options']['group']] = $area['options']['group'] . "__" . $i;

                        $this->parseArea(
                            $block,
                            $area['area'],
                            $i > 0 ? $newReplacements : $replacements
                        );
                    }
                    break;
            }
        }
    }

    // Преобработка полей по их типу
    public function preHandleFieldsByType()
    {
        $aliases = json_decode($this->data['aliases'], true);

        $this->handleDate(null, "today", date('Y-m-d', strtotime("now")));

        foreach ($aliases as $key => $val) {
            $input = FormUiInput::find($val);

            if (isset($this->data[$key])) {
                $value = $this->data[$key];
                if ($input) {
                    switch ($input->type) {
                        case "date":
                            $this->handleDate($input, $key, $value);
                            break;

                        case "number":
                            $this->handleNumber($input, $key, $value);
                            break;

                        case "fio":
                            $this->handleFio($input, $key, $value);
                            break;

                        case "file":
                            $this->handleFile($input, $key, $value);
                            break;

                        case "sign":
                            $this->handleSign($input, $key, $value);
                            break;

                        case "checkbox":
                            $this->handleCheckbox($input, $key, $value);
                            break;
                    }
                }
            }
        } 
    }

    // Подготовить ответ в виде html
    public function makeHtmlAnswer($html)
    {
        $url = ServiceController::makeAnswer($html, $this->service->id);

        $price = $this->service->price;

        $html = <<<EOF
            <a href="$url" class="btn btn-success">Оплатить $price <small><i class='fa-solid fa-ruble-sign'></i></small></a><br>
        EOF;

        return ["msg" => $html];
    }

    // Выдать ошибку
    public function makeFailAnswer($failMsg)
    {
        return ["msg" => $failMsg];
    }

    // Использовать шаблон
    public function useTemplate($folder, $application, $template)
    {
        $documentData = DocumentController::documentByTemplate($folder . "/$template", $this->data->all(), $application, $this->images, $this->complex);
        return $documentData;
    }
}
