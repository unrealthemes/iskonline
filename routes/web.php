<?php
use App\Http\Controllers\ApplicationAnswersController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FormsUIFormsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Services\CheckingDoveerController;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//##################Страницы
Route::get('/', function () {
    $services = Service::get();
    return view('pages.index', ['services' => $services]);
})->name('home');

Route::get('/контакты', function () {
    return view('pages.contacts');
})->name('contacts');
Route::post('/контакты', [UserController::class, 'handleContactForm'])->name('contacts-post');
Route::get('/спасибо-за-обращение', function () {
    return view('pages.contacts-thanks');
})->name('contacts-thanks');

Route::get('/о-нас', function () {
    return view('pages.about');
})->name('about');

Route::get('/правовая-информация', function () {
    return view('pages.docs');
})->name('license-agreement');

//##################Страницы
//##################Сервисы

//Route::get('/подсудность-суда',[ServiceController::class, 'show4']);
Route::get('/определение-подсудности-{city}', [ServiceController::class, 'show4city']);

$services = Service::get();
foreach ($services as $service) {
    if ($service->service_type_id != 2 OR $service->service_type_id != 4) { // Подготавливаем урлы под сервисы, работающие по стандартной теме
        Route::get("/$service->link", [ServiceController::class, 'show'])->name("services.show.$service->id");
    }
}



//##################Сервисы
//##################Кастомные сервисы
//У кастомных сервисов маршруты имеют в имени id это сервиса см Service
//Калькулятор ДУУ
Route::get("/калькулятор-дду", function () {
    return view('pages-services.ddu');
})->name('services.show.5');
//Проверка доверенности
Route::get('/проверка-доверенности',[CheckingDoveerController::class,'index'])->name('services.show.26');
// Получение ставки рефинансирования
Route::post("/ставка-рефинансирования", [DocumentController::class, 'getRate']);

//##################Кастомные сервисы
//##################Оплата
Route::get("/оплата-произведена", function (Request $request) {
    return view('pages-personal.thankyou', ['application' => $request->get('application')]);
})->name("services.thanks");

Route::get("/оплата-произведена-4", [ServiceController::class, 'get4'])->name("services.thanks4");

Route::post("/обработка-сервиса/{service}/{order}", [ServiceController::class, 'handleForm'])->name('services.service');
Route::get('/{service}/{order}/get_form_json', [ServiceController::class, 'getFormJson'])->name('services.get_form_json');
Route::get('/{service}/make_from_json', [ServiceController::class, 'makeFromJson'])->name('services.make_from_json');
Route::get('/подтверждение-заявки', [ServiceController::class, 'applicationConfirmation'])->name('application.confirmation');
//##################Оплата
Route::get('/test', function () {
    return view("pages.test");
});

// Изображения
Route::get('/изображение/{img}', [ServiceController::class, 'getImg'])->name('services.sign');

// Помощники
Route::post('/мирсуд', [ServiceController::class, 'getCourt'])->name('services.special.mirsud');
// Route::get('/мирсуд', [ServiceController::class, 'getCourt'])->name('services.special.mirsud');

// Для Яндекса
Route::get("/yandex_66c23ab4871e4efb.html", function () {
    echo <<<EOF
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            </head>
            <body>Verification: 66c23ab4871e4efb</body>
        </html>
    EOF;
});
// Карта сайта
Route::get('/sitemap.xml', function () {
    // $routes = [];
    return response()->view('sitemap')->header('Content-Type', 'text/xml');
});

// Документы
Route::get('/generate4/{application}', [ServiceController::class, 'generateDocument_4'])->name('documents.get4');

Route::middleware(['auth'])->prefix('/документы')->group(function () {
    Route::get('/{application}', [DocumentController::class, 'get'])->name('documents.get');
    Route::get('/{application}/активация', [DocumentController::class, 'setAvailable'])->name('documents.activate');
});

Route::get('/{service}/pay', [ServiceController::class, 'createApplicationNew']);
Route::get('/подсудность/{application}/проверка-оплаты', [ServiceController::class, 'paymentCheck4'])->name('applications.payment-check4');

Route::middleware(['auth'])->prefix('/заявления')->group(function () {
    Route::get('/{application}/создание', [ServiceController::class, 'generateDocument'])->name('applications.generate');
    Route::get('/{application}/редактирование', [ServiceController::class, 'editApplication'])->name('applications.edit');
    Route::get('/{service}/оплата', [ServiceController::class, 'paymentApplication'])->name('applications.payment');
    Route::get('/{application}/проверка-оплаты', [ServiceController::class, 'paymentCheck'])->name('applications.payment-check');
});

Route::get('/ответ/{code}', [ApplicationAnswersController::class, 'getAnswer'])->name('applications.answer');
// Работа с формами
Route::prefix('/формы')->group(function () {
    Route::get('/получение/{form}', [FormsUIFormsController::class, 'json'])->name("forms.json");
    Route::post('/отправка/{form}', [FormsUIFormsController::class, 'post'])->name("forms.post");
});

//API
Route::get('/data_api/address','App\Http\Controllers\ApiController@dataAddress');

