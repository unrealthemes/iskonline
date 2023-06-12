<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationAnswers;
use App\Models\ApplicationStatus;
use App\Models\Documents;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        return view('pages-admin.index');
    }

    public function categories(Request $request)
    {

        return view('pages-admin.categories');
    }

    public function applications(Request $request)
    {
        $applicationQuery = Application::orderBy('created_at', 'desc');

        $applications = $applicationQuery->get();

        $services = Service::get()->pluck('name', 'id');

        $users = User::get()->pluck('name', 'id');
        $usersTel = User::get()->pluck('tel', 'id');
        $applicationStatusesRaw = ApplicationStatus::get();
        $applicationStatuses = [];

        foreach ($applicationStatusesRaw as $st) {
            $applicationStatuses[$st->id] = $st;
        }

        return view('pages-admin.applications.index', [
            'applications' => $applications,
            'services' => $services,
            'users' => $users,
            'usersTel' => $usersTel,
            'application_statuses' => $applicationStatuses,
        ]);
    }

    public function applicationUpdate(Request $request)
    {
        $application = Application::find($request->input("id"));
        $application->update($request->all());

        return redirect()->to(route("admin.applications.index"));
    }

    public function applicationGet(Request $request, Application $application)
    {

        $document = Documents::where('application_id', '=', $application->id)->orderBy('id', 'desc')->first();
        $service = Service::find($application->service_id);

        if ($service->service_type_id == 1) {
            return $this->getApplicationAnswer($application);
        }

        $date = date('Y-m-d H:i:s', strtotime('now'));
        $user = User::find($application->user_id);

        if ($document and $user) {
            $headers = ['Content-Type: application/msword'];
            return response()->download($document->document_path, "$service->name $user->name $date.docx", $headers);
        } else {
            echo 'error';
        }
    }

    public function getApplicationAnswer(Application $application)
    {
        $answer = ApplicationAnswers::where("application_id", "=", $application->id)->get()->last();

        if ($answer) {
            return view('pages.answer', ['answer' => $answer->answer]);
        }
    }

    public function changeApplicationPayment(Request $request, Application $application)
    {
        $application->payed = !$application->payed;

        return redirect()->to(route(
            'admin.applications.index',
            [
                'user' => $request->get('user'),
                'from' => $request->get('from'),
                'to' => $request->get('to'),
            ]
        ));
    }
}
