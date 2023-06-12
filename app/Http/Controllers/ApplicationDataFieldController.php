<?php

namespace App\Http\Controllers;

use App\Models\ApplicationDataField;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\FormsDataController;

class ApplicationDataFieldController extends Controller
{
    static public function createFields($request, $application)
    {
        FormsDataController::saveFields($request, $application);
        // dd($request->all());
        $date = date('Y-m-d H:i:s', strtotime('now'));
        $data = [];
        foreach ($request->all() as $key => $value) {
            if (gettype($value) != "object") {
                $data[] = [
                    'name' => $key,
                    'value' => $value ? $value : "",
                    'application_id' => $application->id,
                    'created_at' => $date
                ];
            }
        }

        foreach ($request->files as $key => $file) {
            $destinationPath = storage_path() . "/public/images";
            $name = md5(strtotime("now") . uniqid()) . "." . $request->file($key)->extension();
            $file->move($destinationPath, $name);

            $field_name = $key;
            $data[] = [
                'name' => $field_name,
                'value' => URL::to('/') . "/изображение/$name",
                'application_id' => $application->id,
                'created_at' => $date
            ];
        }

        ApplicationDataField::insert($data);
    }

    static public function updateFields($request, $application)
    {
        FormsDataController::saveFields($request, $application);

        $date = date('Y-m-d H:i:s', strtotime('now'));
        $data = [];
        foreach ($request->all() as $key => $value) {
            if ($key != 'application' and gettype($value) != "object") {
                $data[] = [
                    'name' => $key,
                    'value' => $value ? $value : "",
                    'application_id' => $application->id,
                    'created_at' => $date
                ];

                ApplicationDataField::where('application_id', '=', $application->id)->where('name', '=', $key)->delete();
            }
        }

        foreach ($request->files as $key => $file) {
            $destinationPath = storage_path() . "/public/images";
            $name = md5(strtotime("now") . uniqid()) . "." . $request->file($key)->extension();
            $file->move($destinationPath, $name);

            $field_name = $key;
            $data[] = [
                'name' => $field_name,
                'value' => URL::to('/') . "/изображение/$name",
                'application_id' => $application->id,
                'created_at' => $date
            ];
        }

        ApplicationDataField::insert($data);
    }
}
