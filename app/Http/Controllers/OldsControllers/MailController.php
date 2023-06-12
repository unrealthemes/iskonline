<?php

namespace App\Http\Controllers;

use PHPMailer\PHPMailer\PHPMailer;

class MailController extends Controller
{
    public static function createMailer()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();                   // Отправка через SMTP
        $mail->SMTPAuth = true;
        $mail->Username   = 'coderlair';       // ваше имя пользователя (без домена и @)
        $mail->Password   = 'umfx1113442006RIMERNICK';    // ваш пароль
        $mail->Host = 'smtp.yandex.ru';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        return $mail;
    }

    public static function send($to, $subject, $content)
    {
        $mail = MailController::createMailer();
        $mail->setFrom('coderlair@yandex.ru', 'DOCSGEN');    // от кого
        $mail->addAddress($to); // кому

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $content;

        $mail->send();
    }

    static public function confirmEmail($id, $code, $password = '')
    {
        $passwordCode = $password ? <<<EOF
            <div style="text-align:center">Ваш пароль: $password</div>
        EOF : "";

        $href = route('verify-email', ['code' => $code, 'id' => $id]);

        $letter = <<<EOF
            <html>
                <head>
                    <title>Подтверждение почты</title>
                </head>
                <body>
                    <div style="text-align:center; padding: 20px; font-family: sans-serif">
                        <h1>Подтверждение почты DOCSGEN</h1>
                        <a style="display: inline-block; background: #7b0404; color: #ffffff; padding: 10px 17px; border-radius: 7px; text-decoration: none;" href="$href">Подтвердить</a><br>
                        $passwordCode
                    </div>
                </body>
            </html>
        EOF;
        return $letter;
    }
}
