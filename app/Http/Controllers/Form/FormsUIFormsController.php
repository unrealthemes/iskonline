<?php
namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Models\FormsData;
use App\Models\FormUiElement;
use App\Models\FormUiForm;
use App\Models\FormUiFormStep;
use App\Models\FormUiStep;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormsUIFormsController extends Controller
{
    public function index()
    {
        $forms = FormUiForm::get();
        $services = Service::get()->pluck('name', 'id');

        return view('pages-admin.forms.forms.index', [
            'forms' => $forms,
            'services' => $services,
        ]);
    }

    public function create()
    {
        $services = Service::get()->pluck('name', 'id');

        return view('pages-admin.forms.forms.create', [
            'services' => $services,
        ]);
    }

    public function edit(FormUiForm $form)
    {
        // Получение json всех форм
        $json = $this->getFormJson($form);

        // Формирование списка имён
        $names = $this->addName($json['steps'], "");
        $groups = $this->addGroup($json['steps'], "");

        $services = Service::get()->pluck('name', 'id');

        return view('pages-admin.forms.forms.edit', [
            'services' => $services,
            'form' => $form,
            "names" => $names,
            "groups" => $groups,
        ]);
    }

    public function store(Request $request)
    {
        $newForm = [];

        $data = $request->all();

        $newForm['order'] = 1;
        $newForm['options'] = "{}";
        $newForm['name'] = $data['name'];
        $newForm['service_id'] = $data['service_id'];

        $form = FormUiForm::create($newForm);

        return redirect()->to(route('admin.forms.forms.edit', ['form' => $form->id]));
    }

    public function update(Request $request, FormUiForm $form)
    {
        $data = $request->all();

        $form->update($data);

        return redirect()->to(route("admin.forms.forms.edit", ['form' => $form->id]));
    }

    public function delete(Request $request, FormUiForm $form)
    {
        $form->delete();

        return redirect()->to(route("admin.forms.forms.index"));
    }

    public function getNames(FormUiForm $form)
    {
        // Получение json всех форм
        $json = $this->getFormJson($form);

        // Формирование списка имён
        $names = $this->addName($json['steps'], "");
        $groups = $this->addGroup($json['steps'], "");

        return [$names, $groups];
    }

    public function addName($elements, $prefix)
    {
        $names = [];
        foreach ($elements as $element) {
            if ($element['type'] == "input") {
                $name = $prefix ? $prefix . "-" . $element['name'] : $element['name'];
                $names[] = $name;
            } elseif ($element['type'] == 'group' or $element['type'] == 'step') {

                $childPrefix = $element['prefix'] ? ($prefix ? $prefix . "-" . $element['prefix'] : $element['prefix']) : $prefix;
                $childNames = $this->addName($element['elements'], $childPrefix);

                foreach ($childNames as $name) {
                    $names[] = $name;
                }
            }
        }

        return $names;
    }

    public function addGroup($elements, $prefix)
    {
        $groups = [];
        foreach ($elements as $element) {
            if ($element['type'] == 'group' or $element['type'] == 'step') {

                $childPrefix = $element['prefix'] ? ($prefix ? $prefix . "-" . $element['prefix'] : $element['prefix']) : $prefix;
                $childGroups = $this->addGroup($element['elements'], $childPrefix);

                $groups[] = $childPrefix;

                foreach ($childGroups as $name) {
                    $groups[] = $name;
                }
            }
        }

        return $groups;
    }

    public function getJson(Request $request, FormUiForm $form)
    {
        $values = [];

        if ($request->user()) {
            $values['applicant-fio'] = $request->user()->name;
            $values['applicant-address'] = $request->user()->address;
            $values['applicant-email'] = $request->user()->email;
            $values['applicant-tel'] = $request->user()->tel;
            $values['applicant-birthdate'] = $request->user()->birthdate;

            $values['applicant-passport'] = $request->user()->passport;
            $values['applicant-passport_when'] = $request->user()->passport_when;
            $values['applicant-passport_from'] = $request->user()->passport_from;

            $values['fio'] = $request->user()->name;
            $values['address'] = $request->user()->address;
            $values['email'] = $request->user()->email;
            $values['tel'] = $request->user()->tel;
            $values['birthdate'] = $request->user()->birthdate;

            $values['passport'] = $request->user()->passport;
            $values['passport_when'] = $request->user()->passport_when;
            $values['passport_from'] = $request->user()->passport_from;
        }

        $application = $request->get('application');
        if ($application) {
            $data = FormsData::where('application_id', '=', $application)->get()->last();
            $values = json_decode($data->data, true);
        }
        return response()->json([
            'form' => $this->getFormJson($form),
            'values' => $values,
        ]);
    }

    public function getFormJson(FormUiForm $form)
    {
        // Организация json
        $json = [

            "title" => $form->name,
            "service" => $form->service_id,
            "steps" => [],
        ];

        // Перебор привязок
        foreach (FormUiFormStep::where('form_ui_form_id', '=', $form->id)->get() as $formStep) {
            // Получение шага
            $step = FormUiStep::find($formStep->form_ui_step_id);
            $stepJson = [
                "id" => $step->id,
                'type' => 'step',
                "form_step_id" => $formStep->id,
                "title" => $step->title,
                "options" => json_decode($step->options, true),
                "prefix" => $step->prefix,
                "order" => $formStep->order,
                "show_in_saved" => $step->show_in_saved,
                "elements" => [],
            ];

            // Получение дочерних элементов
            $stepJson['elements'] = $this->getChildrenJson("form_ui_steps", $step->id);

            $json["steps"][] = $stepJson;
        }

        return $json;
    }

    public function getChildrenJson($parentTable, $parentId, $checked = [])
    {
        $elements = FormUiElement::where('parent_table', '=', $parentTable)
            ->where('parent_id', '=', $parentId)
            ->orderBy('order')
            ->get();

        $elementsList = [];
        foreach ($elements as $element) {
            // Выбор из соответствующего элемента
            if (!in_array($element->element_id, $checked)) {
                $el = DB::table($element->element_table)
                    ->find($element->element_id);

                // Получение json элемента
                $elementJson = $this->getElementJson($el, $element, $checked);
                $elementsList[] = $elementJson;
            }
        }

        return $elementsList;
    }

    public function getElementJson($el, $element, $checked = [])
    {
        $json = [];

        // Разный json от разных типов
        switch ($element->element_table) {
            case "form_ui_groups":
                $json = $this->getGroupJson($el, $element);
                break;

            case "form_ui_inputs":
                $json = $this->getInputJson($el, $element);
                break;
        }

        $checked[] = $el->id;
        $json['elements'] = $this->getChildrenJson($element->element_table, $el->id, $checked);

        return $json;
    }

    public function json(Request $request, FormUiForm $form)
    {
        return $this->getJson($request, $form);
    }

    public function getGroupJson($el, $element)
    {
        return [
            'type' => "group",

            'id' => $el->id,
            'element_id' => $element->id,

            'name' => $el->name,
            'prefix' => $el->prefix,
            'description' => $el->description,
            'show_in_saved' => $el->show_in_saved,
            'clonable' => $el->clonable,
            'options' => json_decode($el->options, true),

            'order' => $element->order,
            'column' => $element->column,
            'element_name' => $element->name,
        ];
    }

    public function getInputJson($el, $element)
    {
        return [
            'type' => "input",

            'id' => $el->id,
            'element_id' => $element->id,

            'name' => $el->name,
            'input_type' => $el->type,
            'label' => $el->label,
            'show_in_saved' => $el->show_in_saved,
            'options' => json_decode($el->options, true),
            'events' => json_decode($el->events, true),
            'validation' => json_decode($el->validation, true),
            'helper' => $el->helper ? json_decode($el->helper, true) : null,

            'order' => $element->order,
            'column' => $element->column,
            'element_name' => $element->name,
        ];
    }
}
