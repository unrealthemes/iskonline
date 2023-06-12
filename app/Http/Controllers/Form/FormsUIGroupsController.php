<?php
namespace App\Http\Controllers\Form;

use App\Models\FormUiElement;
use Illuminate\Http\Request;
use App\Models\FormUiForm;
use App\Models\FormUiFormStep;
use App\Models\FormUiGroup;
use App\Models\FormUiStep;
use App\Http\Controllers\Controller;

class FormsUIGroupsController extends Controller
{
    public function index()
    {
        return view('pages-admin.forms.steps.index');
    }

    public function store(Request $request, FormUiForm $form)
    {
        [$data, $options, $elementData] = FormsUIGroupsController::parseDifferentData($request);

        // dd([$data, $elementData, $options]);

        $data['options'] = json_encode($options);
        $data['title'] = $data['name'];

        // Создание группы
        $group = FormUiGroup::create($data);

        $elementData = FormsUIGroupsController::preparingCreatingElementData($elementData, $group, 'form_ui_groups');

        // Добавление привязки
        $element = FormUiElement::create($elementData);

        return response()->json([
            'id' => $group->id,
            'element_id' => $element->id,
            'name' => $group->name,
            'column' => $element->column,
            'clonable' => $group->clonable,
            'prefix' => $group->prefix,
            'show_in_saved' => $group->show_in_saved,
            'description' => $group->description,
            'options' => $options,
        ]);
    }

    public static function parseDifferentData(Request $request)
    {
        $data = $request->all();

        // Выделение параметров options и данных элемента
        $options = [];
        $elementData = [
            "options" => "{}"
        ];
        foreach ($data as $key => $value) {
            if (str_starts_with($key, "element-")) {
                $elementData[str_replace("element-", "", $key)] = $value;
                unset($data[$key]);
            }

            if (str_starts_with($key, "options-")) {
                $options[str_replace("options-", "", $key)] = $value;
                unset($data[$key]);
            }
        }

        return [$data, $options, $elementData];
    }

    public static function preparingCreatingElementData($elementData, $el, $table)
    {
        // Получение последнего шага формы, привязка переданного шага
        $last = FormUiElement::where('parent_table', '=', $elementData['parent_table'])
            ->where('parent_id', '=', $elementData['parent_id'])
            ->get()
            ->last();
        $lastOrder = $last ? $last->order : 0;
        $elementData['order'] = $lastOrder + 1;
        $elementData['element_table'] = $table;
        $elementData['element_id'] = $el->id;

        return $elementData;
    }

    public function update(Request $request, FormUiForm $form)
    {

        [$data, $options, $elementData] = FormsUIGroupsController::parseDifferentData($request);

        // Получение изменяемой группы
        $element = FormUiElement::find($data['elementId']);

        $group = FormUiGroup::find($element->element_id);

        unset($data['elementId']);


        // dd([$data, $elementData, $options]);

        $data['options'] = json_encode($options);
        $data['title'] = $data['name'];

        // Обновление группы
        $group->update($data);

        // Обновление привязки
        $element->update($elementData);

        return response()->json([
            'id' => $group->id,
            'element_id' => $element->id,
            'name' => $group->name,
            'column' => $element->column,
            'clonable' => $group->clonable,
            'prefix' => $group->prefix,
            'show_in_saved' => $group->show_in_saved,
            'description' => $group->description,
            'options' => $options,
        ]);
    }

    public function delete(Request $request, FormUiElement $element)
    {
        // Удаление привязки
        $element->delete();

        // Ничего не возвращаем
        return response()->json([]);
    }

    public function move(Request $request, FormUiForm $form)
    {
        // Изменение порядка привязки
        $order = json_decode($request->input('order'), true);
        $orderMarkers = [];
        foreach ($order as $record) {
            $element = FormUiElement::find($record[0]);

            $key = "$record[1]$record[2]";
            $orderMarkers[$key] = isset($orderMarkers[$key]) ? $orderMarkers[$key] + 1 : 0;

            $element->order = $orderMarkers[$key];
            $element->parent_table = $record[1];
            $element->parent_id = $record[2];

            $element->save();
        }


        // Ничего не возвращаем
        return response()->json([]);
    }

    public function get(Request $request)
    {
        $groups = [];

        foreach (FormUiGroup::where('show_in_saved', '=', 1)->get() as $group) {
            $groups[] = [
                "id" => $group->id,
                "title" => $group->name
            ];
        }

        return response()->json($groups);
    }

    public function link(Request $request, FormUiGroup $group)
    {
        [$data, $options, $elementData] = FormsUIGroupsController::parseDifferentData($request);

        $elementData = FormsUIGroupsController::preparingCreatingElementData($elementData, $group, 'form_ui_groups');

        $element = FormUiElement::create($elementData);

        // Возвращаем данные созданного шага
        return response()->json([]);
    }

    public function clone(Request $request, FormUiGroup $group)
    {
        $originalId = $group->id;
        [$data, $options, $elementData] = FormsUIGroupsController::parseDifferentData($request);

        $group = $group->replicate();
        $group->show_in_saved = false;
        $group->save();

        $elementData = FormsUIGroupsController::preparingCreatingElementData($elementData, $group, 'form_ui_groups');

        $element = FormUiElement::create($elementData);

        // Дублируем все внутренности группы
        $children = FormUiElement::where('parent_table', '=', 'form_ui_groups')->where('parent_id', '=', $originalId)->get();
        foreach ($children as $child) {
            $childNew = $child->replicate();
            $childNew->parent_id = $group->id;
            $childNew->save();
        }

        // Возвращаем данные созданного шага
        return response()->json([]);
    }
}
