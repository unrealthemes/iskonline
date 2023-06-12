<?php

namespace App\Http\Controllers;

use App\Models\DocumentArea;
use App\Models\FormUiForm;
use App\Models\Service;
use Illuminate\Http\Request;

class DocumentAreaController extends Controller
{
    public function index(Request $request, Service $service)
    {
        $areas = DocumentArea::where('service_id', '=', $service->id)->get();
        return view('pages-admin.areas.index', ['service' => $service, "areas" => $areas]);
    }

    public function create(Request $request, Service $service)
    {
        return view('pages-admin.areas.create', ['service' => $service]);
    }

    public function store(Request $request, Service $service)
    {
        $data = $request->all();
        $data['service_id'] = $service->id;
        $documentArea = DocumentArea::create($data);

        return redirect()->to(route('admin.areas.index', ['service' => $service->id]));
    }

    public function delete(Request $request, DocumentArea $area)
    {
        $service = $area->service_id;
        $area->delete();

        return redirect()->to(route('admin.areas.index', ['service' => $service]));
    }

    public function edit(Request $request, DocumentArea $area)
    {
        $service = Service::find($area->service_id);
        $form = FormUiForm::where('service_id', '=', $service->id)->first();

        $names = [];
        $groups = [];
        if ($form) {
            $formsController = new FormsUIFormsController();
            $data = $formsController->getNames($form);

            $names = $data[0];
            $groups = $data[1];
        }

        return view('pages-admin.areas.edit', ['service' => $service, 'area' => $area, 'names' => $names, 'groups' => $groups]);
    }

    public function update(Request $request, DocumentArea $area)
    {
        $data = $request->all();
        $area->update($data);

        return redirect()->to(route('admin.areas.edit', ['area' => $area->id]));
    }
}
