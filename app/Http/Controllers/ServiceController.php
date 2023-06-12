<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationAnswers;
use App\Models\ApplicationDataField;
use App\Models\FormsData;
use App\Models\Payment;
use App\Models\Service;
use App\Models\ServiceForm;
use App\Models\ServiceFormStep;
use App\Models\ServiceFormStepInput;
use App\Models\ServiceServiceForm;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use simplehtmldom\HtmlDocument;
use simplehtmldom\HtmlWeb;
use DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function services()
    {
        return view('pages.services');
    }

    public function createApplication(Request $request, Service $service)
    {
        // [$account, $user_id] = [false, 0];
        // if ($request->has('applicant-email') and !Auth::check()) {
        //     [$account, $user_id] = UserController::createAccountByApplication($request);
        // }

        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }

        $application = Application::create([
            'service_id' => $service->id,
            'user_id' => $user_id,
            'application_status_id' => 1
        ]);

        ApplicationDataFieldController::createFields($request, $application);

        return $application;
    }
	
		public function createApplicationNew(Request $request, Service $service)
    {
		
        // [$account, $user_id] = [false, 0];
        // if ($request->has('applicant-email') and !Auth::check()) {
        //     [$account, $user_id] = UserController::createAccountByApplication($request);
        // }
		$user_id=99999;//выставляем id тестовго пользователя
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }
		//логиним его
		
        $application = Application::create([
            'service_id' => $service->id,
            'user_id' => $user_id,
            'application_status_id' => 1
        ]);

        ApplicationDataFieldController::createFields($request, $application);
		return $this->paymentApplicationNew($application->id);
		//echo $application->id;
        //return $application;
    }

    public function handleForm(Request $request, Service $service, $order)
    {
        $after = 0;
        $confirmed = true;
        if ($service->service_type_id == 0) {
            if (Auth::check()) {
                $user_id = Auth::user()->id;
            } else {
                $user = User::where('tel', '=', $request->input('applicant-tel'))
                    ->first();

                $confirmed = false;
                if ($user) {
                    $user_id = $user->id;
                    $after = 1;
                } else {
                    $user_id = UserController::createAccountByApplication($request);
                    $after = 2;
                }
            }

            if ($request->get('application')) {
                $application = Application::find($request->get('application'));

                if (!$application or $application->user_id != Auth::user()->id) {
                    return redirect()->to(route('home'));
                }

                if ($application->edited) {
                    return response()->json(['to' => route('account.applications')]);
                }
            } else {
                if ($order == 1) {
                    $application = Application::create([
                        'service_id' => $service->id,
                        'user_id' => $user_id,
                        'application_status_id' => 1,
                        'confirmed' => $confirmed,
                    ]);
                } else {
                    $application = Application::where('user_id', '=', $user_id)
                        ->where('service_id', '=', $service->id)
                        ->orderBy('id', 'desc')
                        ->first();
                }
            }
            if ($application) {

                if ($request->get('application')) {
                    ApplicationDataFieldController::updateFields($request, $application);
                    // $application->edited = true;
                    $application->save();
                } else {
                    ApplicationDataFieldController::createFields($request, $application);
                }
            }

            // try {
            ServiceController::generateDocument($request, $application);
            // } catch (Exception $e) {
            //     if (!$request->get('application')) {
            //         $application->delete();
            //     }
            //     return response()->json(['error' => $e->getMessage()]);
            // }

            if ($after == 0) {
                return response()->json(['to' => route('documents.get', ['application' => $application->id])]);
            } elseif ($after == 1) {
                return response()->json(['to' => route('application.confirmation', ['tel' => $request->input('applicant-tel'), 'application' => $application->id])]);
            } elseif ($after == 2) {
                return response()->json(['to' => route('application.confirmation', ['tel' => $request->input('applicant-tel'), 'application' => $application->id])]);
            }
        } elseif ($service->service_type_id == 1) {
            $res = ServiceController::getAnswer($request, $service);
            return response()->json(['msg' => $res['msg']]);
        }
    }

    public static function generateDocument(Request $request, Application $application)
    {
        if ($application) {
            $service = Service::find($application->service_id);
            $data = FormsDataController::getData($application);
            if (!$data) {
                $data = ApplicationDataField::where('application_id', '=', $application->id)->get()->pluck('value', 'name');
            }

            include(storage_path() . "/app/services/$service->id/handler.php");
            return handle($data, storage_path() . "/app/services/$service->id/", $application);
        }
    }
	
		public static function generateDocument_4(Request $request, Application $application)
    {
        if ($application) {
            $service = Service::find($application->service_id);
            $data = FormsDataController::getData($application);
			//print_r($data);
            if (!$data) {
                $data = ApplicationDataField::where('application_id', '=', $application->id)->get()->pluck('value', 'name');
            }
			
			//print_r($data);
			$court = ApiController::getCourtDebex($data['address-address']);
			//print_r($court);
			if (!isset($court['MAGISTRATE'])) {
				
				return view('pages-personal.court_fail');

    } else {
        $mirsud = $court["MAGISTRATE"];
        $raysud = $court["COURT"];

        $html = <<<EOF
            <span class='text-muted'>Участок мирового судьи</span>
            <h3>$mirsud[title]</h3>
            <p><b>Адрес:</b> $mirsud[address]</p>
            <p><b>Телефон:</b> $mirsud[phone]</p>
            <p><b>Email:</b> $mirsud[email]</p><br>
            <small class='text-muted'>Реквизиты для оплаты госпошлины мировому суду</small>
            <p><b>Получатель платежа:</b> $mirsud[receiver]</p>
            <p><b>КПП:</b> $mirsud[kpp]</p>
            <p><b>ИНН:</b> $mirsud[inn]</p>
            <p><b>ОКТМО:</b> $mirsud[oktmo]</p>
            <p><b>Корреспондентский счёт:</b> $mirsud[correspond]</p>
            <p><b>Рассчётный счёт:</b> $mirsud[calculated]</p>
            <p><b>Банк получателя:</b> $mirsud[bank]</p>
            <p><b>БИК:</b> $mirsud[bik]</p>
            <p><b>КБК:</b> $mirsud[kbk]</p>
            <p><b>Наименования платежа:</b> Государственная пошлина в суд общей юрисдикции</p><br>
            <span class='text-muted'>Районный суд</span>
            <h3>$raysud[title]</h3>
            <p><b>Адрес:</b> $raysud[address]</p>
            <p><b>Телефон:</b> $raysud[phone]</p>
            <p><b>Email:</b> $raysud[email]</p><br>
            <small class='text-muted'>Реквизиты для оплаты госпошлины районному суду</small>
            <p><b>Получатель платежа:</b> $raysud[receiver]</p>
            <p><b>КПП:</b> $raysud[kpp]</p>
            <p><b>ИНН:</b> $raysud[inn]</p>
            <p><b>ОКТМО:</b> $raysud[oktmo]</p>
            <p><b>Корреспондентский счёт:</b> $raysud[correspond]</p>
            <p><b>Рассчётный счёт:</b> $raysud[calculated]</p>
            <p><b>Банк получателя:</b> $raysud[bank]</p>
            <p><b>БИК:</b> $raysud[bik]</p>
            <p><b>КБК:</b> $raysud[kbk]</p>
            <p><b>Наименования платежа:</b> Государственная пошлина в суд общей юрисдикции</p>
        EOF;

        return view('pages-personal.court', ['html' => $html]);
    }
            //include(storage_path() . "/app/services/$service->id/handler.php");
            //return handle($data, storage_path() . "/app/services/$service->id/", $application);
        }
    }

    public static function getAnswer(Request $request, Service $service)
    {
        include(storage_path() . "/app/services/$service->id/handler.php");
        return handle($request->all(), storage_path() . "/app/services/$service->id/");
    }

    public function applicationConfirmation(Request $request)
    {
        $tel = $request->get('tel');
        $application = $request->get('application');
        $status = ConfirmationController::applicationSMS($tel, $application);
        if (!$status['ok']) {
            return redirect()->to(route('login'))->withErrors(["Повторите попытку через $status[time] сек."]);
        }
        return view('pages.confirmation.application', ['tel' => $tel, 'action' => route('confirm.sms')]);
    }

    // public function getJson(Request $request, Service $service)
    // {
    //     $filename = storage_path() . "/app/services/$service->id/client.json";

    //     header('Content-Type: application/json; charset=utf-8');
    //     $json = json_decode(file_get_contents($filename), true);

    //     if (Auth::check()) {
    //         $user = Auth::user();
    //         $steps = $json['steps'];
    //         foreach ($steps as $key => $step) {
    //             if ($step['fieldPrefix'] == 'applicant') {
    //                 foreach ($step['inputs'] as $id => $input) {
    //                     if ($input['name'] == 'fio') {
    //                         $json['steps'][$key]['inputs'][$id]['value'] = $user->name;
    //                     }

    //                     if ($input['name'] == 'email') {
    //                         $json['steps'][$key]['inputs'][$id]['value'] = $user->email;
    //                         $json['steps'][$key]['inputs'][$id]['disabled'] = true;
    //                     }
    //                 }
    //             }
    //         }
    //     }


    //     return response()->json($json);
    // }

    public function paymentCheck(Request $request, Application $application)
    {
        $payment = Payment::where('application_id', '=', $application->id)->get()->last();

        if (PaymentController::check($payment->order_id)) {
            $application->payed = true;
            $application->nextStatus();
            $payment->status = 1;
            $payment->save();
            return redirect()->to(route("services.thanks", ['application' => $application->id]));
        }

        //
    }
	
	public function paymentCheck4(Request $request, Application $application)
    {
        $payment = Payment::where('application_id', '=', $application->id)->get()->last();
	

        if (PaymentController::check($payment->order_id)) {
            $application->payed = true;
            $application->nextStatus();
            $payment->status = 1;
            $payment->save();
			
			if($application->service_id==4) {
				return redirect()->to(ENV('APP_URL').'generate4/'.$application->id);
				//return redirect()->to(route("services.thanks4", ['application' => $application->id]));
			}
            return redirect()->to(route("services.thanks", ['application' => $application->id]));
        }

        //
    }

    public function paymentApplication(Request $request, Service $service)
    {
        $application = Application::find($request->get('application'));

        // $application->payed = true;
        // $application->save();

        $urlBase = "https://xn--h1aeu.xn--80asehdb/";
        $url = $urlBase . urlencode("заявления") . "/$application->id/" . urlencode("проверка-оплаты");

        $payment = Payment::create([
            'user_id' => $application->user_id,
            'service_type' => 'service',
            'service_id' => $application->service_id,
            'application_id' => $application->id,
            'amount' => $service->price * 100,
            'form_url' => "",
        ]);

        $payment->order_number = $payment->id + 4;
        $payment->save();

        // Определение, администратор ли пользователь. Если админ, то оплату не производим, сразу кидаем на нужную страницу
        $user = User::find($application->user_id);
        if ($user and $user->status == 0) {
            $application->payed = true;
            $application->nextStatus();
            $payment->status = 1;
            $payment->save();

            return redirect()->to(route("services.thanks", ['application' => $application->id]));
        } else {
            $res = PaymentController::register([
                'orderNumber' => $payment->order_number,
                'amount' => $service->price * 100,
                'returnUrl' => $url
            ]);

            $payment->form_url = $res['formUrl'];
            $payment->order_id = $res['orderId'];

            $payment->save();

            return redirect($payment->form_url);
        }




        // dd($payment);

        // $application->nextStatus();

        // return redirect()->to(route("services.thanks"));
        // return redirect()->to(route('account.applications'));
    }
	
	
	public function get4(Request $request) {
	 //echo $request->get('application');
    return view('pages-personal.thankyoufour', ['application' => $request->get('application')]);
}
	
	
	    public function paymentApplicationNew($application)
    {
        $application = Application::find($application);
		$service=Service::find($application->service_id);

        // $application->payed = true;
        // $application->save();

        //$urlBase = "https://7.иск.онлайн/";
		$urlBase = ENV('APP_URL');
		
        $url = $urlBase . urlencode("подсудность") . "/$application->id/" . urlencode("проверка-оплаты");

        $payment = Payment::create([
            'user_id' => $application->user_id,
            'service_type' => 'service',
            'service_id' => $application->service_id,
            'application_id' => $application->id,
            'amount' => $service->price * 100,
            'form_url' => "",
        ]);

        $payment->order_number = $payment->id + 4;
        $payment->save();

        // Определение, администратор ли пользователь. Если админ, то оплату не производим, сразу кидаем на нужную страницу
        $user = User::find($application->user_id);
        if ($user and $user->status == 0) {
            $application->payed = true;
            $application->nextStatus();
            $payment->status = 1;
            $payment->save();
			
			return redirect()->to(ENV('APP_URL').'generate4/'.$application->id);
            //return redirect()->to(route("services.thanks4", ['application' => $application->id]));
        } else {
            $res = PaymentController::register([
                'orderNumber' => $payment->order_number,
                'amount' => $service->price * 100,
                'returnUrl' => $url
            ]);
			
			if(isset($res['formUrl'])) {
				$payment->form_url = $res['formUrl'];
				$payment->order_id = $res['orderId'];

				$payment->save();

				return redirect($payment->form_url);
			}
			else {
				sleep(2);
				$res = PaymentController::register([
                'orderNumber' => $payment->order_number,
                'amount' => $service->price * 100,
                'returnUrl' => $url
				]);
				$payment->form_url = $res['formUrl'];
				$payment->order_id = $res['orderId'];

				$payment->save();

			}
        }

    }

    public function editApplication(Application $application)
    {
        if (Auth::user()->id != $application->user_id) {
            return redirect()->to(route('account.applications'));
        }

        if ($application->edited) {
            return redirect()->to(route('account.applications'));
        }

        $service = Service::find($application->service_id);
        return view('pages-personal.edit-application', ['application' => $application, 'service' => $service]);
    }

    public function prepareFormJson(Service $service, $order)
    {

        $serviceServiceForm = ServiceServiceForm::where('service_id', '=', $service->id)->where('order', '=', $order)->first();
        $serviceForm = ServiceForm::find($serviceServiceForm->service_form_id);
        $serviceSteps = ServiceFormStep::where('service_form_id', '=', $serviceForm->id)->get();
        $allJson = [
            'title' => $serviceForm->title,
            'steps_number' => $serviceForm->steps_number,
            'steps' => []
        ];

        $stepsForKeys = [];

        foreach ($serviceSteps as $j => $serviceStep) {
            $stepInputs = ServiceFormStepInput::where('service_form_step_id', '=', $serviceStep->id)->orderBy('id')->get();

            $json = [];

            $json['title'] = $serviceStep->title;
            $json['step_number'] = $serviceStep->step_number;
            $json['fields_prefix'] = $serviceStep->fields_prefix;
            $json['next'] = $serviceStep->next_step_id;
            $json['description'] = $serviceStep->description;
            $json['id'] = $j + 1;

            $inputs = [];
            foreach ($stepInputs as $i => $input) {
                $inp = [
                    'name' => $input['name'],
                    'label' => $input['label'],
                    'type' => $input['type'],
                    'suggestions' => $input['suggestions'],
                    'required' => $input['required'],
                    'visible' => $input['visible'],
                    'validation' => json_decode($input['validation'], true),
                    'events' => json_decode($input['events_json'], true),
                    'group' => $input['group'],
                    'helper_image' => $input['helper_image'],
                    'helper_caption' => $input['helper_caption'],
                ];

                $attrs = json_decode($input['attributes'], true);

                if ($attrs) {
                    foreach ($attrs as $attr => $data) {
                        $inp[$attr] = $data;
                    }
                }


                $inputs[$i + 1] = $inp;
            }

            $json['inputs'] = $inputs;

            $stepsForKeys[$serviceStep->id] = $json;
        }

        foreach ($stepsForKeys as $i => $step) {
            $stepJson = $step;
            $stepJson['next'] = $stepJson['next'] ? $stepsForKeys[$stepJson['next']]['id'] : null;
            $allJson['steps'][$stepJson['id']] = $stepJson;
        }

        return $allJson;
    }

    public static function makeAnswer($html, $service_id)
    {
        $code = md5(uniqid() . strtotime('now'));

        $user_id = Auth::check() ? Auth::user()->id : 0;

        $application = Application::create([
            'service_id' => $service_id,
            'user_id' => $user_id,
            'application_status_id' => 4
        ]);

        ApplicationAnswers::create([
            'application_id' => $application->id,
            'code' => $code,
            'answer' => $html
        ]);

        $urlBase = "https://xn--h1aeu.xn--80asehdb/";
        $url = $urlBase . urlencode("ответ") . "/$code";

        $service = Service::find($service_id);

        $payment = Payment::create([
            'user_id' => $application->user_id,
            'service_type' => 'service',
            'service_id' => $application->service_id,
            'application_id' => $application->id,
            'amount' => $service->price * 100,
            'form_url' => "",
        ]);

        $payment->order_number = $payment->id + 4;
        $payment->save();

        if (Auth::check() and Auth::user()->status == 0) {
            $payment->status = 1;
            $payment->save();

            // $application->nextStatus();
            // $application->save();

            $payment->form_url = $url;
        } else {
            $res = PaymentController::register([
                'orderNumber' => $payment->order_number,
                'amount' => $service->price * 100,
                'returnUrl' => $url
            ]);

            // dd($res);

            $payment->form_url = $res['formUrl'];
            $payment->order_id = $res['orderId'];

            $payment->save();
        }

        return $payment->form_url;
    }

    public function getValues(Request $request, $json)
    {
        $fields = [];
        if (Auth::check()) {
            $user = Auth::user();
            $fields['applicant-fio'] = $user->name;
            $fields['applicant-email'] = $user->email;
            $fields['applicant-address'] = $user->address;
            $fields['applicant-tel'] = $user->tel;
            $fields['applicant-date'] = $user->birthdate;
        }

        $application = $request->get('application');
        if ($application) {
            foreach (ApplicationDataField::where('application_id', '=', $application)->get()->pluck('value', 'name')->toArray() as $key => $value) {
                $fields[$key] = $value;
            }
        }


        foreach ($json['steps'] as $i => $step) {
            foreach ($step['inputs'] as $j => $input) {
                $name = $step['fields_prefix'] . "-" . $input['name'];
                if (array_key_exists($name, $fields)) {
                    $json['steps'][$i]['inputs'][$j]['value'] = $fields[$name];
                }
            }
        }

        return $json;
    }

    public function getFormJson(Request $request, Service $service, $order)
    {
        $json = $this->prepareFormJson($service, $order);
        $json = $this->getValues($request, $json);
        return response()->json($json);
    }

    public function getCalculatorJson(Request $request, Service $service)
    {
        $json = $this->getFormJson($request, $service, 1);

        return response()->json($json);
    }

    public function show(Request $request)
    {
		$city_array=array("Москва","Санкт-Петербург","Новосибирск","Екатеринбург","Нижний-Новгород","Казань","Челябинск","Омск","Самара","Ростов-на-Дону","Уфа","Красноярск","Пермь","Воронеж","Волгоград","Краснодар","Саратов","Тюмень","Тольятти","Ижевск","Барнаул","Ульяновск","Иркутск","Хабаровск","Ярославль","Владивосток","Махачкала","Томск","Оренбург","Кемерово","Новокузнецк","Рязань","Астрахань","Набережные-Челны","Пенза","Липецк","Киров","Чебоксары","Тула","Калининград","Балашиха","Курск","Ставрополь","Улан-Удэ","Тверь","Магнитогорск","Сочи","Иваново","Брянск","Белгород");
		
        $routeName = $request->route()->getName();
        $id = explode('.', $routeName)[2];
        $service = Service::find($id);
		if($service->id==4) {
			return view('pages.service4', ['service' => $service,'cities'=>$city_array]);
		} else {
			return view('pages.service', ['service' => $service,'cities'=>$city_array]);
		}
    }
	
	public function show4(Request $request)
    {
		$city_array=array("Москва","Санкт-Петербург","Новосибирск","Екатеринбург","Нижний Новгород","Казань","Челябинск","Омск","Самара","Ростов-на-Дону","Уфа","Красноярск","Пермь","Воронеж","Волгоград","Краснодар","Саратов","Тюмень","Тольятти","Ижевск","Барнаул","Ульяновск","Иркутск","Хабаровск","Ярославль","Владивосток","Махачкала","Томск","Оренбург","Кемерово","Новокузнецк","Рязань","Астрахань","Набережные Челны","Пенза","Липецк","Киров","Чебоксары","Тула","Калининград","Балашиха","Курск","Ставрополь","Улан-Удэ","Тверь","Магнитогорск","Сочи","Иваново","Брянск","Белгород");
        //$routeName = $request->route()->getName();
        //$id = explode('.', $routeName)[2];
        $service = Service::find(4);
        return view('pages.service4', ['service' => $service,'cities'=>$city_array]);
    }
	
	public function show4city(Request $request,$city)
    {
		//echo 'show for city ';
		//echo $city;
        //$routeName = $request->route()->getName();
        //$id = explode('.', $routeName)[2];
		$city_array=array("Москва","Санкт-Петербург","Новосибирск","Екатеринбург","Нижний Новгород","Казань","Челябинск","Омск","Самара","Ростов-на-Дону","Уфа","Красноярск","Пермь","Воронеж","Волгоград","Краснодар","Саратов","Тюмень","Тольятти","Ижевск","Барнаул","Ульяновск","Иркутск","Хабаровск","Ярославль","Владивосток","Махачкала","Томск","Оренбург","Кемерово","Новокузнецк","Рязань","Астрахань","Набережные Челны","Пенза","Липецк","Киров","Чебоксары","Тула","Калининград","Балашиха","Курск","Ставрополь","Улан-Удэ","Тверь","Магнитогорск","Сочи","Иваново","Брянск","Белгород");
		
		if($city==mb_strtolower("Москва")) {
			return redirect(env('APP_URL').'определение-подсудности-суда',301);
		}
		if($city!='суда') {
		
		return redirect(env('APP_URL').'определение-подсудности-суда',301);
		
		$city_array2=array();
				foreach($city_array as $city2) {
					$city_array2[]=mb_strtolower($city2);
				}
		
		if(in_array(mb_strtolower($city), $city_array2)) {
		switch(mb_strtolower($city)) {
			case mb_strtolower("Москва"):$city_gde='Москве';break;
			case mb_strtolower("Сочи"):$city_gde='Сочи';break;
			case mb_strtolower("Нижний Новгород"):$city_gde="Нижнем Новгороде";break;
			case mb_strtolower("Казань"):$city_gde="Казани";break;
			case mb_strtolower("Самара"):$city_gde="Самаре";break;
			case mb_strtolower("Ростов-на-Дону"):$city_gde="Ростове-на-Дону";break;
			case mb_strtolower("Уфа"):$city_gde="Уфе";break;
			case mb_strtolower("Пермь"):$city_gde="Перми";break;
			case mb_strtolower("Тюмень"):$city_gde="Тюмени";break;
			case mb_strtolower("Тольятти"):$city_gde="Тольятти";break;
			case mb_strtolower("Ярославль"):$city_gde="Ярославле";break;
			case mb_strtolower("Махачкала"):$city_gde="Махачкале";break;
			case mb_strtolower("Кемерово"):$city_gde="Кемерове";break;
			case mb_strtolower("Рязань"):$city_gde="Рязани";break;
			case mb_strtolower("Астрахань"):$city_gde="Астрахани";break;
			case mb_strtolower("Набережные Челны"):$city_gde="Набережных Челнах";break;
			case mb_strtolower("Пенза"):$city_gde="Пензе";break;
			case mb_strtolower("Чебоксары"):$city_gde="Чебоксарах";break;
			case mb_strtolower("Тула"):$city_gde="Туле";break;
			case mb_strtolower("Балашиха"):$city_gde="Балашихе";break;
			case mb_strtolower("Ставрополь"):$city_gde="Ставрополе";break;
			case mb_strtolower("Улан-Удэ"):$city_gde="Улан-Удэ";break;
			case mb_strtolower("Тверь"):$city_gde="Твери";break;
			case mb_strtolower("Иваново"):$city_gde="Иванове";break;
			case mb_strtolower("Санкт-Петербург"):$city_gde="Санкт-Петербурге";break;
			default:$city_gde=$this->mb_ucfirst($city.'е');
		}
			
		
		
		$slug='определение-подсудности-'.$city;
		$title='Территориальная подсудность в '.$city_gde.' - узнать подсудность по адресу';
		$description='Узнайте территориальную подсудность районных по адресу в '.$city_gde.'! С помощью сервиса Вы сможете самостоятельно определить территориальную подсудность мировых судей.';
		$h1='Территориальная подсудность мировых и районных судов в '.$city_gde;
		$city_text=DB::table('service4city_text')->where('name','LIKE','%'.$city.'%')->first();
		if(!isset($text)) {
			$text='';
		}
		else {
			$text=$city_text->text;
		}
		
		$text=$city_text->text;
		
		$seo=array('title'=>$title,'description'=>$description,'h1'=>$h1,'text'=>$text);
		
		
        $service = Service::find(4);
        return view('pages.service4city', ['service' => $service,'seo'=>$seo,'cities'=>$city_array]);
		}
		else {
			return redirect(ENV('APP_URL').'определение-подсудности-суда');
		}
		}
		else {
			$service = Service::find(4);
			return view('pages.service4', ['service' => $service,'cities'=>$city_array]);
		}
    }
	
	public static function mb_ucfirst($text) {
		return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
	}

    public function makeFromJson(Request $request, Service $service)
    {

        $filename = storage_path() . "/app/services/$service->id/client.json";
        $json = json_decode(file_get_contents($filename), true);

        $serviceForm = ServiceForm::create([
            'title' => $json['title'],
            'steps_number' => $json['stepsCount']
        ]);

        $steps = [];

        foreach ($json['steps'] as $i => $step) {
            $serviceStep = ServiceFormStep::create([
                'title' => $step['title'],
                'fields_prefix' => $step['fieldPrefix'],
                'step_number' => $step['stepNumber'],
                'service_form_id' => $serviceForm->id,
                'next_step_id' => $step['next'],
            ]);
            foreach ($step['inputs'] as $j => $input) {
                $serviceInput = ServiceFormStepInput::create([
                    'name' => $input['name'],
                    'label' => $input['label'],
                    'visible' => $input['visible'],
                    'type' => $input['type'],
                    'required' => isset($input['required']) ? $input['required'] : true,
                    'suggestions' => isset($input['suggestion']) ? $input['suggestion'] : '',
                    'validation' => isset($input['validation']) ? json_encode($input['validation']) : '',
                    'service_form_step_id' => $serviceStep->id,
                    'events_json' => isset($input['events']) ? json_encode($input['events']) : '',
                ]);
            }
            $steps[$i] = $serviceStep;
        }

        foreach ($steps as $i => $step) {
            if ($step->next_step_id) {
                $step->next_step_id = $steps[$step->next_step_id]->id;
                $step->save();
            }
        }

        ServiceServiceForm::create([
            'order' => 1,
            'service_id' => $service->id,
            'service_form_id' => $serviceForm->id
        ]);
    }

    public function getCourtAddr($court)
    {
        $filename = storage_path() . "/app/data/courts.txt";
        $filename2 = storage_path() . "/app/data/moscourts.json";

        $handle = fopen($filename, "r");

        $court = str_replace("№ ", "№", $court);

        if (mb_strpos($court, "Москв") !== false) {
            $number = str_replace("№", "", explode(" ", $court)[2]);
            $content = file_get_contents($filename2);
            $lst = json_decode($content, true);

            return $lst[(int)$number];
        } else {
            $court_first = explode(" ", $court);
            $court_first = "$court_first[0] $court_first[1] $court_first[2]";

            if ($handle) {
                $max = ["-", 100000000];
                while (($line = fgets($handle)) !== false) {

                    $name = explode(";", $line)[0];
                    $link = explode(";", $line)[1];
                    $lev = \levenshtein($name, $court, 1, 3, 2);

                    $cur_court_first = explode(" ", $name);
                    $cur_court_first = "$cur_court_first[0] $cur_court_first[1] $cur_court_first[2]";

                    if ($lev < $max[1] and $cur_court_first == $court_first) {
                        $max = [$link, $lev];
                    }
                    // echo \levenshtein($name, $court)."<br>";

                }

                $link = $max[0];
                $link = str_replace("https", "http", $link);
                // echo $link;
                fclose($handle);

                $homepage = file_get_contents("$link"); //Запрос
                $addrStarts = mb_strpos($homepage, "<p><b>Адрес:");

                $addr = $addrStarts;

                // $client = new HtmlWeb();
                // $html = $client->load($link);
                // $addr = $html->find('.column_left p')[4]->plaintext;

                return $addr;
            }
        }
    }

    public function test(Request $request)
    {
        return view('pages.test');
    }

    public function getCourt(Request $request)
    {
        $addr = $request->get('addr');

        $court = DocumentController::getCourtDebex($addr);

        if ($court) {
            return response()->json([
                "title" => $court['MAGISTRATE']['title'],
                "address" => $court['MAGISTRATE']['address'],
            ]);
        }

        return response()->json([]);
    }

    public function getImg(Request $request, $img)
    {
        return response()->file(storage_path() . "/public/images/" . $img);
    }
}
