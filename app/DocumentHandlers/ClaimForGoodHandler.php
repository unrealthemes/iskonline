<?php

namespace App\DocumentHandlers;

use App\DocumentHandlers\BaseDocumentHandler;
use App\Http\Controllers\ServiceController;
class ClaimForGoodHandler extends BaseDocumentHandler
{




    
    // Подготовить ответ в виде html
    public function makeHtmlAnswer($html)
    {
        $url = ServiceController::makeAnswer($html, $this->service->id);

        $price = $this->service->price;

        $html = <<<EOF
            <a href="$url" class="btn btn-success">Оплатить $price <small><i class='fa-solid fa-ruble-sign'></i></small></a><br>
        EOF;

        return ["msg" => $html];
    }

    // Выдать ошибку
    public function makeFailAnswer($failMsg)
    {
        return ["msg" => $failMsg];
    }

}
