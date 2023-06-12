<?php

namespace App\Http\Controllers;

use App\Models\DocumentArea;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::get();
        $services_types = ServiceType::get()->pluck("runame", "id");

        return view("pages-admin.services.index", ["services" => $services, "services_types" => $services_types]);
    }

    public function create()
    {
        $services_types = ServiceType::get()->pluck("runame", "id");

        return view("pages-admin.services.create", ["services_types" => $services_types]);
    }

    public function edit(Service $service)
    {
        $documentAreas = DocumentArea::where('service_id', '=', $service->id)->get();
        $servicesTypes = ServiceType::get()->pluck("runame", "id");
        $folder = storage_path() . "/app/services/$service->id/";
        $files = scandir($folder);
        $templates = [];

        foreach ($files as $file) {
            if (mime_content_type($folder . $file) == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                $templates[] = $file;
            }
        }

        $handler = $folder . "handler.php";
        $handlerCode = "";

        if (file_exists($handler)) {
            $handlerCode = file_get_contents($handler);
        }

        return view("pages-admin.services.edit", [
            "services_types" => $servicesTypes,
            "service" => $service,
            "templates" => $templates,
            "handler" => $handlerCode,
            "documentAreas" => $documentAreas,
        ]);
    }

    public function document(Request $request, Service $service, $document)
    {

        $folder = storage_path() . "/app/services/$service->id/";
        $document = $folder . $document;

        return response()->file($document);
    }

    public function uploadDocument(Request $request, Service $service)
    {
        $folder = storage_path() . "/app/services/$service->id/";

        if ($request->template) {
            $ff = storage_path("app/public/");
            $path = $request->template->store("/", "public");
            $from = $ff . $path;
            copy($from, $folder . $path);
            rename($folder . $path, $folder . $request->template->getClientOriginalName());
            return response()->json(['file' => $request->template->getClientOriginalName()]);
        }
    }

    public function deleteDocument(Request $request, Service $service, $document)
    {
        $folder = storage_path() . "/app/services/$service->id/";
        unlink($folder . $document);

        return response()->json([]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['service_category_id'] = 1;
        $data['client_json_file'] = "";
        $data['php_handler_file'] = "";
        $service = Service::create($data);

        $folder = storage_path() . "/app/services/$service->id/";
        mkdir($folder);

        $handler = $folder . "handler.php";
        $handlerTemplate = storage_path() . "/app/services/handler.php";

        $php = file_get_contents($handlerTemplate);
        file_put_contents($handler, $php);

        return redirect()->to(route("admin.services.edit", ['service' => $service->id]));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->all();
        $data['service_category_id'] = 1;
        $data['client_json_file'] = "";
        $data['php_handler_file'] = "";
        $data['videos'] = $data['videos'] ? $data['videos'] : ',';

        $service->update($data);

        return redirect()->to(route("admin.services.edit", ['service' => $service->id]));
    }

    public function delete(Service $service)
    {
        $service->delete();

        return redirect()->to(route("admin.services.index"));
    }

    public function putHandler(Request $request, Service $service)
    {
        $folder = storage_path() . "/app/services/$service->id/";
        $handler = $folder . "handler.php";

        if (file_exists($handler)) {
            file_put_contents($handler, $request->input("handler"));
        }

        return response()->json([]);
    }
}
