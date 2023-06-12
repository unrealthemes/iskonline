<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationAnswers;
use App\Models\Payment;

class ApplicationAnswersController extends Controller
{
    public static function getAnswer($code)
    {
        $answer = ApplicationAnswers::where('code', '=', $code)->first();
        if (!$answer) {
            return self::redirectToAccountApplication();
        }
        $application = Application::find($answer->application_id);
        if (!$application) {
            return self::redirectToAccountApplication();
        }
        $payment = Payment::where("application_id", "=", $application->id)->get()->last();
        if ($payment) {
            $payed = false;
            if ($payment->status == 1) {
                $payed = true;
            } else {
                $payed = PaymentController::check($payment->order_id);
                if ($payed) {
                    $payment->status = 1;
                    $payment->save();
                    $application->nextStatus();
                }
            }
        }
        if ($payed) {
            $answ = $answer->answer;
            $application->nextStatus();
            $application->payed = 1;
            $application->save();
            return view("pages.answer", ['answer' => $answ]);
        }
    }

    public static function redirectToAccountApplication()
    {
        return redirect()->to(route("account.applications"));
    }
}
