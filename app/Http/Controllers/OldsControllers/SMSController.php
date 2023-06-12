<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SMSController extends Controller
{
    static public function sendTo($number, $text)
    {
        $login = 'a.a.kurianov@gmail.com';
        $key   = '9RIda4J08RplftdGjgEuRDn1jtny';
        $sign  = 'SMS Aero';
        $phone = $number;
        $text  = "Код подтверждения: $text";

        $phone = preg_replace('/[^0-9]/', '', $phone);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $login . ':' . $key);
        curl_setopt($ch, CURLOPT_URL, 'https://gate.smsaero.ru/v2/sms/send?number=' . $phone . '&text=' . urlencode($text) . '&sign=' . $sign);
        $res = curl_exec($ch);
        curl_close($ch);

        $array = json_decode($res, true);
        return $array;
    }

    static public function flashcall($number, $code)
    {
        $login = 'a.a.kurianov@gmail.com';
        $key   = '9RIda4J08RplftdGjgEuRDn1jtny';
        $phone = $number;
        $code  = $code;

        $phone = preg_replace('/[^0-9]/', '', $phone);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $login . ':' . $key);
        $url = 'https://gate.smsaero.ru/v2/flashcall/send?phone=' . $phone . '&code=' . $code;
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        curl_close($ch);

        $array = json_decode($res, true);
        return $array;
    }
}
