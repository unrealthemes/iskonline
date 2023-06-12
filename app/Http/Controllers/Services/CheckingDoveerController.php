<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Parsers\ReestrDover\ParserDoveer;
use App\Querys\Services\GetService;
use Illuminate\Http\Request;

class CheckingDoveerController extends Controller
{

    public function index()
    {
        $service = GetService::find(26);
        // return "Сервис скоро будет доступен, мы работаем над этим";
        return view('pages-services.checkingdoveer', [
            'service' => $service,
            'bg' => "blue"
        ]);
    }

    public function searchNot(string $name)
    {
        $result = ParserDoveer::searchNot($name);
        return response()->json($result);
    }

    public function captcha(Request $request)
    {
        $request = $request->all();
        $date = explode('-', $request['date']);
        $request['date'] = $date[2] . $date[1] . $date[0];

        return ParserDoveer::getCaptcha($request);
    }

    public function result(Request $request)
    {
        return ParserDoveer::getResult($request->all());
    }

    public function getCountry()
    {
        $countrys = ParserDoveer::getCountry();
        return response()->json($countrys);
    }

    public function getDistrict()
    {
        $districts = ParserDoveer::getDistrict();
        return response()->json($districts);
    }
}
