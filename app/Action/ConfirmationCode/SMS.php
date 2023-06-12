<?php
namespace App\Action\ConfirmationCode;

class SMS
{
    private static $login = 'a.a.kurianov@gmail.com';
    private static $key = '9RIda4J08RplftdGjgEuRDn1jtny';
    private static $sign = 'SMS Aero';

    public static function send(string $phone, string $text): array
    {

        $text = "Код подтверждения: $text";
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $url = 'https://gate.smsaero.ru/v2/sms/send?number=' . $phone . '&text=' . urlencode($text) . '&sign=' . self::$sign;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, self::$login . ':' . self::$key);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        curl_close($ch);
        $array = json_decode($res, true);
        return $array;
    }

}
