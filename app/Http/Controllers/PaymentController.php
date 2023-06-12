<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    
    static public function register($data)
    {
        $data['currency'] = 643;
        // $data['returnUrl'] = "https://xn--80aeec0cfsgl1g.xn--80asehdb/%D0%BE%D0%BF%D0%BB%D0%B0%D1%82%D0%B0-%D0%BF%D1%80%D0%BE%D0%B8%D0%B7%D0%B2%D0%B5%D0%B4%D0%B5%D0%BD%D0%B0";

        $data['userName'] = "r-isk-api";
        $data['password'] = "Fanisharm20";
        $curl = curl_init(); // Инициализируем запрос
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://payment.alfabank.ru/payment/rest/register.do", // Полный адрес метода
            CURLOPT_RETURNTRANSFER => true, // Возвращать ответ
            CURLOPT_POST => true, // Метод POST
            CURLOPT_POSTFIELDS => http_build_query($data) // Данные в запросе
        ));
        $response = curl_exec($curl); // Выполненяем запрос

        $response = json_decode($response, true); // Декодируем из JSON в массив
        curl_close($curl); // Закрываем соединение
        return $response; // Возвращаем ответ
    }

    static public function check($orderId)
    {
        // $data['token'] = "gvlfbddrc4skvcvlpr3vbepnaq";
        $data['userName'] = "r-isk-api";
        $data['password'] = "Fanisharm20";
        $data['orderId'] = $orderId;
        $curl = curl_init(); // Инициализируем запрос
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://payment.alfabank.ru/payment/rest/getOrderStatus.do", // Полный адрес метода
            CURLOPT_RETURNTRANSFER => true, // Возвращать ответ
            CURLOPT_POST => true, // Метод POST
            CURLOPT_POSTFIELDS => http_build_query($data) // Данные в запросе
        ));
        $response = curl_exec($curl); // Выполненяем запрос

        $response = json_decode($response, true); // Декодируем из JSON в массив
        curl_close($curl); // Закрываем соединение
        // dd($response);
        if (array_key_exists("OrderStatus", $response)) {
            return $response['OrderStatus'] == 2;
        } else {
            return false;
        }
    }
}
