<?php

namespace App\Parsers\ReestrDover;

class ParserDoveer
{

    const HOST = 'http://localhost:3000';

    public static function getCaptcha(array $param)
    {
        $path = self::HOST . '/captcha';
        return self::sendJson($path, $param);
    }

    public static function getResult(array $param)
    {
        $path = self::HOST . '/result';
        return self::sendJson($path, $param);
    }

    public static function searchNot(string $name)
    {   
        $param = [
            'name' => $name,
        ];
        $path = self::HOST . '/searchNot';
        $responce = self::sendJson($path, $param);
        $result = json_decode($responce->result);
        return $result;
    }
    public static function getCountry()
    {   
        $path = self::HOST . '/country';
        $responce = self::sendJson($path,[]);
        $result = json_decode($responce->result);
        return $result;
    }
    public static function getDistrict()
    {   
        $path = self::HOST . '/district';
        $responce = self::sendJson($path,[]);
        $result = json_decode($responce->result);
        return $result;
    }
    private static function sendJson(string $url, array $param)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        return $res;
    }
}

