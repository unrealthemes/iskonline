<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function verifiing(Request $request)
    {
        if (!$request->user()->hasVerifiedEmail()) {
            return view('pages-personal.verifiing', ['user' => $request->user()]);
        } else {
            return redirect()->to(route('account.index'));
        }
    }

    public function applications()
    {
        return view('pages-personal.applications');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('pages-personal.profile', ['user' => $user]);
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $requestData = $request->all();
        $user->update([
            'email' => $requestData['email'],
            'address' => $requestData['address'],
            'name' => $requestData['name'],
            'birthdate' => date('Y-m-d', strtotime($requestData['birthdate'])),
            'passport' => $requestData['passport'],
            'passport_when' => $requestData['passport_when'] ? date('Y-m-d', strtotime($requestData['passport_when'])) : null,
            'passport_from' => $requestData['passport_from'],
        ]);

        return redirect()
        ->to(route('account.profile'))
        ->with('status', 'Ваши данные успешно сохранены');
    }
}
