<?php
namespace App\Http\Controllers\Form;

use App\Models\FormUiElement;
use App\Models\FormUiForm;
use App\Models\FormUiFormStep;
use App\Models\FormUiStep;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormsUIStepsController extends Controller
{
    public function index()
    {
        return view('pages-admin.forms.steps.index');
    }

    public function store(Request $request, FormUiForm $form)
    {
        $data = $request->all();
        $data["options"] = "{}";

        // Создание шага
        $step = FormUiStep::create($data);

        // Получение последнего шага формы, привязка нового шага
        $lastFormStep = FormUiFormStep::where('form_ui_form_id', '=', $form->id)->orderBy('order', 'DESC')->first();
        $lastId = $lastFormStep ? $lastFormStep->id : 0;

        $formStep = FormUiFormStep::create([
            'form_ui_form_id' => $form->id,
            'form_ui_step_id' => $step->id,
            'order' => $lastId + 1
        ]);

        // Возвращаем данные созданного шага
        return response()->json([
            'id' => $step->id,
            'title' => $step->title,
            'prefix' => $step->prefix,
            "form_step_id" => $formStep->id,
            "show_in_saved" => $step->show_in_saved
        ]);
    }

    public function update(Request $request, FormUiForm $form)
    {
        // Получение всех данных
        $data = $request->all();

        // Получение id шага
        $stepId = $data['stepId'];
        unset($data['stepId']);

        // Сохранение шага
        $step = FormUiStep::find($stepId);
        $step->update($data);

        // Возвращаем данные созданного шага
        return response()->json([
            'id' => $step->id,
            'title' => $step->title,
            'prefix' => $step->prefix,
            'show_in_saved' => $step->show_in_saved
        ]);
    }

    public function delete(Request $request, FormUiFormStep $step)
    {
        // Удаление привязки
        $step->delete();

        // Ничего не возвращаем
        return response()->json([]);
    }

    public function move(Request $request, FormUiForm $form)
    {
        // Изменение порядка привязки
        // $cur = $step->order;
        // $step->order = $lastStep->order;
        // $lastStep->order = $cur;

        // $step->save();
        // $lastStep->save();
        $order = json_decode($request->input('order'), true);
        foreach ($order as $n => $formStepId) {
            $formStep = FormUiFormStep::find($formStepId);
            $formStep->order = $n;

            $formStep->save();
        }


        // Ничего не возвращаем
        return response()->json([]);
    }

    public function get(Request $request)
    {
        $steps = [];

        foreach (FormUiStep::where('show_in_saved', '=', 1)->get() as $step) {
            $steps[] = [
                "id" => $step->id,
                "title" => $step->title
            ];
        }

        return response()->json($steps);
    }

    public function link(Request $request, FormUiForm $form, FormUiStep $step)
    {
        // Получение последнего шага формы, привязка переданного шага
        $lastFormStep = FormUiFormStep::where('form_ui_form_id', '=', $form->id)->orderBy('order', 'DESC')->first();
        $lastId = $lastFormStep ? $lastFormStep->id : 0;

        $formStep = FormUiFormStep::create([
            'form_ui_form_id' => $form->id,
            'form_ui_step_id' => $step->id,
            'order' => $lastId + 1
        ]);

        // Возвращаем данные созданного шага
        return response()->json([
            'id' => $step->id,
            'title' => $step->title,
            'prefix' => $step->prefix,
            "form_step_id" => $formStep->id,
        ]);
    }

    public function clone(Request $request, FormUiForm $form, FormUiStep $step)
    {
        $originalId = $step->id;

        // Создание шага
        $step = $step->replicate();
        $step->show_in_saved = false;
        $step->save();

        // Получение последнего шага формы, привязка нового шага
        $lastFormStep = FormUiFormStep::where('form_ui_form_id', '=', $form->id)->orderBy('order', 'DESC')->first();
        $lastId = $lastFormStep ? $lastFormStep->id : 0;

        $formStep = FormUiFormStep::create([
            'form_ui_form_id' => $form->id,
            'form_ui_step_id' => $step->id,
            'order' => $lastId + 1,
        ]);

        // Дублируем все внутренности шага
        $children = FormUiElement::where('parent_table', '=', 'form_ui_steps')->where('parent_id', '=', $originalId)->get();
        foreach ($children as $child) {
            $childNew = $child->replicate();
            $childNew->parent_id = $step->id;
            $childNew->save();
        }

        // Возвращаем данные созданного шага
        return response()->json([
            'id' => $step->id,
            'title' => $step->title,
            'prefix' => $step->prefix,
            "form_step_id" => $formStep->id,
        ]);
    }
}
