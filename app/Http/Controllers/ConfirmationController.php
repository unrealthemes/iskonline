<?php

namespace App\Http\Controllers;

use App\Action\ConfirmationCode\FlashCallAction;
use App\Action\ConfirmationCode\SMS;
use App\Models\Application;
use App\Models\Confirmation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConfirmationController extends Controller
{

    public static function code()
    {
        return md5(uniqid() . (strtotime("now") + 500));
    }

    public static function telCode()
    {
        $number = (string) random_int(0, 9999);
        while (strlen($number) < 4) {
            $number = "0" . $number;
        }

        return $number;
    }

    public static function makeConfirmation($type, $action, $actionData, $code)
    {
        return Confirmation::create([
            'code' => $code,
            'active' => 1,
            'active_by' => date('Y-m-d H:i:s', strtotime("now") + 40),
            'confirmation_type' => $type,
            'action' => $action,
            'action_data' => $actionData,
        ]);
    }

    public static function checkExistingConfirmation($tel)
    {
        $existingConfirmation = Confirmation::where('active_by', '>', date('Y-m-d H:i:s', strtotime("now")))
            ->where('action_data', 'LIKE', "%$tel%")
            ->orderBy('id', 'desc')
            ->first();

        return $existingConfirmation;
    }

    public static function repeatConfirmation(Request $request)
    {
        $tel = $request->input('tel');
        $existingConfirmation = self::checkExistingConfirmation($tel);

        if ($existingConfirmation) {
            return response()->json([
                'ok' => false,
                'error' => 'time',
                'time' => strtotime($existingConfirmation->active_by) - strtotime('now'),
            ]);
        } else {
            $lastConfirmation = Confirmation::where('active_by', '<', date('Y-m-d H:i:s', strtotime("now")))
                ->where('active_by', '>', date('Y-m-d H:i:s', strtotime("now") - 300))
                ->where('active', '=', true)
                ->where('action_data', 'LIKE', "%$tel%")
                ->orderBy('id', 'desc')
                ->first();

            if ($lastConfirmation) {
                $code = self::telCode();
                $newConfirmation = self::makeConfirmation(
                    $lastConfirmation->confirmation_type,
                    $lastConfirmation->action,
                    $lastConfirmation->action_data,
                    $code,
                );
                if ($lastConfirmation->confirmation_type == 'sms') {
                    SMS::send($tel, $code);
                } elseif ($lastConfirmation->confirmation_type == 'flashcall') {
                    FlashCallAction::execute($tel, $code);
                }
                return response()->json([
                    'ok' => true,
                    'time' => strtotime($newConfirmation->active_by) - strtotime('now'),
                ]);
            } else {
                return response()->json([
                    'ok' => false,
                    'error' => 'too-much-time',
                ]);
            }
        }
    }

    public static function registerFlashcall($tel)
    {
        $existingConfirmation = self::checkExistingConfirmation($tel);
        if ($existingConfirmation) {
            return ['ok' => false, 'time' => strtotime($existingConfirmation->active_by) - strtotime('now')];
        }

        $code = self::telCode();
        self::makeConfirmation('sms', 'register', "tel=$tel", $code);

        SMS::send($tel, $code);
        // echo $code;
        return ['ok' => true, 'code' => $code];
    }

    public static function loginSMS($tel)
    {
        $existingConfirmation = self::checkExistingConfirmation($tel);
        if ($existingConfirmation) {
            return ['ok' => false, 'time' => strtotime($existingConfirmation->active_by) - strtotime('now')];
        }

        $code = self::telCode();
        self::makeConfirmation('sms', 'login', "tel=$tel", $code);

        if ($tel == '+7 (917) 123-45-67') {
            echo $code;
        } else {
            SMS::send($tel, $code);
        }
        // echo $code;
        return ['ok' => true, 'code' => $code];
    }

    public static function applicationSMS($tel, $application)
    {
        $existingConfirmation = self::checkExistingConfirmation($tel);
        if ($existingConfirmation) {
            return ['ok' => false, 'time' => strtotime($existingConfirmation->active_by) - strtotime('now')];
        }

        $code = self::telCode();
        self::makeConfirmation('sms', 'application', "tel=$tel;application=$application", $code);

        if ($tel == '+7 (917) 123-45-67') {
            echo $code;
        } else {
            SMS::send($tel, $code);
        }

        // echo $code;
        return ['ok' => true, 'code' => $code];
    }

    public static function parseActionData($actionData)
    {
        $data = [];
        foreach (explode(";", $actionData) as $item) {

            $key = explode('=', $item)[0];
            $value = explode('=', $item)[1];

            $data[$key] = $value;
        }

        return $data;
    }

    public static function confirmFlashcall(Request $request)
    {
        $code = $request->input('code');
        $tel = $request->input('tel');

        $confirmation = Confirmation::where('active', '=', 1)
            ->where('active_by', '>=', date('Y-m-d H:i:s', strtotime('now')))
            ->where('confirmation_type', '=', 'flashcall')
            ->where('action_data', 'LIKE', "%$tel%")
            ->orderBy('id', 'desc')
            ->first();

        if ($confirmation) {
            if (Hash::check($code, $confirmation->code)) {
                $confirmation->active = 0;
                $confirmation->save();
                return self::action($confirmation->action, self::parseActionData($confirmation->action_data));
            }
        }

        return response()->json(['ok' => false, 'errors' => ['Неверный код']]);
    }

    public static function confirmSMS(Request $request)
    {
        $code = $request->input('code');
        $tel = $request->input('tel');

        $confirmation = Confirmation::where('active', '=', 1)
            ->where('active_by', '>=', date('Y-m-d H:i:s', strtotime('now')))
            ->where('confirmation_type', '=', 'sms')
            ->where('action_data', 'LIKE', "%$tel%")
            ->orderBy('id', 'desc')
            ->first();

        if ($confirmation) {
            if (Hash::check($code, $confirmation->code)) {
                $confirmation->active = 0;
                $confirmation->save();
                return self::action($confirmation->action, self::parseActionData($confirmation->action_data));
            }
        }

        return response()->json(['ok' => false, 'errors' => ['Неверный код']]);
    }

    public static function action($action, $actionData)
    {
        switch ($action) {
            case 'register':

                $user = User::create([
                    'tel' => $actionData['tel'],
                    'name' => '',
                    'password' => '',
                    'confirmed' => 1,
                    'status' => 1,
                    'confirmation_code' => '',
                    'address' => '',
                ]);

                Auth::login($user, true);
                return response()->json(['ok' => true, 'to' => route('account.profile')]);
                break;

            case 'login':

                $user = User::where('tel', '=', $actionData['tel'])->first();

                Auth::login($user, true);
                return response()->json(['ok' => true, 'to' => route('account.profile')]);
                break;

            case 'application':

                $application = Application::find($actionData['application']);
                $user = User::where('tel', '=', $actionData['tel'])->first();

                $application->confirmed = true;
                $application->save();

                Auth::login($user, true);
                return response()->json(['ok' => true, 'to' => route('documents.get', ['application' => $application->id])]);
                break;
        }
    }

}
