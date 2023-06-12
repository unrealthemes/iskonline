<?php

namespace App\Http\Controllers;

use App\Models\FormUiElement;
use App\Models\FormUiForm;
use App\Models\FormUiGroup;
use App\Models\FormUiInput;
use Illuminate\Http\Request;

class FormsUIInputsController extends Controller
{
    public function index()
    {
        return view('pages-admin.forms.inputs.index');
    }

    public function store(Request $request)
    {
        [$data, $options, $elementData] = FormsUIGroupsController::parseDifferentData($request);

        // dd([$data, $elementData, $options]);

        $data['options'] = json_encode($options);
        $data['title'] = $data['name'];

        if ($request->helper) {
            $filename = md5($request->helper->getClientOriginalName()) . "." . $request->helper->extension();
            $request->helper->storeAs('public/helpers', $filename);
            $data['helper'] = json_encode(["img" => asset('storage/helpers/' . $filename)]);
        }

        // Создание поля ввода
        $input = FormUiInput::create($data);

        $elementData = FormsUIGroupsController::preparingCreatingElementData($elementData, $input, 'form_ui_inputs');

        // Добавление привязки
        $element = FormUiElement::create($elementData);

        return response()->json([]);
    }

    public function update(Request $request, FormUiForm $form)
    {
        [$data, $options, $elementData] = FormsUIGroupsController::parseDifferentData($request);

        // Получение изменяемой группы
        $element = FormUiElement::find($data['elementId']);

        $input = FormUiInput::find($element->element_id);

        unset($data['elementId']);

        if ($request->helper) {
            $filename = md5($request->helper->getClientOriginalName()) . "." . $request->helper->extension();
            $request->helper->storeAs('public/helpers', $filename);
            $data['helper'] = json_encode(["img" => asset('storage/helpers/' . $filename)]);
        }

        if ($data['remove_helper']) {
            unset($data['remove_helper']);
            $data['helper'] = null;
        }

        // dd([$data, $elementData, $options]);

        $data['options'] = json_encode($options);

        // Обновление поля ввода
        $input->update($data);

        // Обновление привязки
        $element->update($elementData);

        return response()->json([]);
    }

    public function get(Request $request)
    {
        $inputs = [];

        foreach (FormUiInput::where('show_in_saved', '=', 1)->get() as $input) {
            $inputs[] = [
                "id" => $input->id,
                "label" => $input->name
            ];
        }

        return response()->json($inputs);
    }

    public function link(Request $request, FormUiInput $input)
    {
        [$data, $options, $elementData] = FormsUIGroupsController::parseDifferentData($request);

        $elementData = FormsUIGroupsController::preparingCreatingElementData($elementData, $input, 'form_ui_inputs');

        $element = FormUiElement::create($elementData);

        // Возвращаем данные созданного шага
        return response()->json([]);
    }

    public function clone(Request $request, FormUiInput $input)
    {
        [$data, $options, $elementData] = FormsUIGroupsController::parseDifferentData($request);

        $input = $input->replicate();
        $input->show_in_saved = false;
        $input->save();

        $elementData = FormsUIGroupsController::preparingCreatingElementData($elementData, $input, 'form_ui_inputs');

        $element = FormUiElement::create($elementData);

        // Возвращаем данные созданного шага
        return response()->json([]);
    }

    public function delete(Request $request, FormUiElement $element)
    {
        // Удаление привязки
        $element->delete();

        // Ничего не возвращаем
        return response()->json([]);
    }

    public function logic(Request $request)
    {
        $input = FormUiInput::find($request->input('input'));

        $input->events = $request->input('events');
        $input->save();

        return response()->json([]);
    }
}
