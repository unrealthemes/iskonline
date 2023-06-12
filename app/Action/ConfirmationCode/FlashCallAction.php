<?php
namespace App\Action\ConfirmationCode;

class FlashCallAction
{
    private static $login = 'a.a.kurianov@gmail.com';
    private static $key = '9RIda4J08RplftdGjgEuRDn1jtny';
    
    public static function execute(string $phone, string $code): array
    {

        $phone = preg_replace('/[^0-9]/', '', $phone);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, self::$login . ':' . self::$key);
        $url = 'https://gate.smsaero.ru/v2/flashcall/send?phone=' . $phone . '&code=' . $code;
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        curl_close($ch);

        $array = json_decode($res, true);
        return $array;
    }

}
