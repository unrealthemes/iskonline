<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\FormsData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormsDataController extends Controller
{

    public static function saveFields(Request $request, Application $application)
    {

        $data = $request->all();

        foreach ($data as $key => $value) {
            if (is_object($value)) {

                $name = md5(strtotime('now') . $key);
                $ext = $value->extension();
                $newName = $name . "." . $ext;
                $path = $value->storeAs('public', $newName);

                $data[$key] = asset('storage/' . $newName);
            }
        }

        unset($data['_token']);

        $formData = [
            'data' => json_encode($data),
            'application_id' => $application->id,
            'form_ui_form_id' => 0
        ];

        $formsData = FormsData::create($formData);
    }

    public static function getData(Application $application)
    {
        $data = FormsData::where('application_id', '=', $application->id)->get()->last();

        if ($data) {
            $formData = collect(json_decode($data->data, true));

            return $formData;
        } else {
            return [];
        }
    }
}
