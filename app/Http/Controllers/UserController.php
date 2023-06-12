<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterPhoneRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Mail\Mailer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Action\Capches\isValidCapchaAction;
use App\Action\Mail\newMessageContactFormNotificationAction;
class UserController extends Controller
{
    public function login()
    {
        return view('pages.login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {
            return redirect()->to(route('account.index'));
        } else {
            return redirect()
            ->to(route('login'))
            ->withErrors(['Неверный логин или пароль']);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->to(route('login'));
    }

    public function register()
    {
        return view('pages.register');
    }

    public function registerConfirmation(RegisterPhoneRequest $request)
    {
        $tel = $request->get('tel');
        $status = ConfirmationController::registerFlashcall($tel);
        if (!$status['ok']) {
            return redirect()
            ->to(route('register'))
            ->withErrors(["Повторите попытку через $status[time] сек."]);
        }
        return view('pages.confirmation.register', ['tel' => $tel, 'action' => route('confirm.sms')]);
    }

    public function loginConfirmation(Request $request)
    {
        $tel = $request->get('tel');
        $user = User::where('tel', '=', $tel)->exists();
        if (!$user) {
            return redirect()
            ->to(route('login'))
            ->withErrors(['Неверный номер телефона. Вы можете зарегистрировать его.']);
        }
        $status = ConfirmationController::loginSMS($tel);
        if (!$status['ok']) {
            return redirect()
            ->to(route('login'))
            ->withErrors(["Повторите попытку через $status[time] сек."]);
        }
        return view('pages.confirmation.login', ['tel' => $tel, 'action' => route('confirm.sms')]);
    }

    public function createAccount(UserRegisterRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 1;
        $code = md5(uniqid() . (strtotime("now") + 500));
        $data['confirmation_code'] = $code;
        $user = User::create($data);
        Mailer::send($request->input('email'), 'Подтверждение почты', Mailer::confirmEmail($user->id, $code));
        Auth::login($user);
        return redirect()->to(route('account.index'));
    }

    private static function genetatePassword(int $length = 6): string
    {
        $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP';
        $size = strlen($chars) - 1;
        $password = '';
        while ($length--) {
            $password .= $chars[random_int(0, $size)];
        }
        return $password;
    }

    public static function createAccountByApplication($request)
    {
        $requestData = $request->all();
        $code = md5(uniqid() . (strtotime("now") + 500));
        $data = [
            'name' => $requestData['applicant-fio'],
            'email' => $requestData['applicant-email'],
            'address' => $requestData['applicant-address'],
            'tel' => $requestData['applicant-tel'],
            'password' => self::genetatePassword(),
            'status' => 1,
            'confirmed' => 0,
            'confirmation_code' => $code,
        ];
        $user = User::create($data);
        return $user->id;
    }

    public function verifyEmail($id, $code)
    {
        $user = User::find($id)->exists();
        if (!$user) {
            return redirect()->to(route('login'));
        }
        if ($user->hasVerifiedEmail()) {
            return redirect()->to(route('login'));
        }
        if (Hash::check($code, $user->confirmation_code)) {
            $user->email_verified_at = date('Y-m-d H:i:s', strtotime('now'));
            $user->save();
            return redirect()->to(route('account.index'));
        }
        return redirect()->to(route('home'));
    }

    public function handleContactForm(Request $request)
    {
        $requestData = $request->all();
        if (isValidCapchaAction::execute($requestData['captcha_token'])) {
            newMessageContactFormNotificationAction::execute($requestData['fio'],$requestData['email'],$requestData['msg']);
        }
        return redirect()->to(route("contacts-thanks"));
    }

    
}
