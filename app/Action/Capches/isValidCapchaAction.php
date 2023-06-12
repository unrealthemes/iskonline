<?php
namespace App\Action\Capches;

class isValidCapchaAction
{

    public static function execute(string $code): bool
    {
        $secret = "6Leuc3oiAAAAAGXqIHv3gcq6dFiMx4YybXGJNQme";
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=" . $code . "&remoteip=" . $_SERVER['REMOTE_ADDR'];
        $request = file_get_contents($url, true);
        $response = json_decode($request);
        if ($response['success'] == false) {
            return false;
        } else {
            return true;
        }
    }

}
