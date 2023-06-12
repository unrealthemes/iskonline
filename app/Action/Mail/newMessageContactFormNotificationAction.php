<?php
namespace App\Action\Mail;

use App\Mail\Mailer;

class newMessageContactFormNotificationAction
{

    public static function execute(string $fio, string $email, string $message): void
    {
        $content =
            <<<EOF
            <b>$fio написал в контактную форму:</b>
            <br>
            <br>
            $message
            <br>
            <br>
            <i>Для ответа указал почту: <a href="mailto:$email">$email</a></i>
        EOF;

        Mailer::send("podat-v-sud@yandex.ru", "Обращение", $content);
    }

}
