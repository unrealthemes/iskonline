@extends('layouts.admin.base-admin-page')

@section('title', $area->name)

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.services.index") }}'>Сервисы</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.services.edit", ["service" => $service->id]) }}'>{{ $service->name }}</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.areas.index", ["service" => $service->id]) }}'>Элементы вставки</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.areas.edit", ["area" => $area->id]) }}'>Редактирование</x-menu.breadcrumb-item>
@endSection

@section('section-content')
<x-tabs.tabs>
    <x-tabs.tabs-button tab-id="editFormTab" content-id="editFormContent">Данные элемента вставки</x-tabs.tabs-button>
    <x-tabs.tabs-button tab-id="areaTab" content-id="areaContent" active="true">Содержимое</x-tabs.tabs-button>
</x-tabs.tabs>
<x-tabs.tabs-content>
    <x-tabs.tabs-pane tab-id="editFormTab" content-id="editFormContent">
        <div class="row mt-3">
            <div class="col-6">
                <div class="bg-white block">
                    <x-form.form action="{{ route('admin.areas.update', ['area' => $area->id]) }}">
                        <x-form.input name="name" label="Название" form-floating="true" value="{{ $area->name }}"></x-form.input>
                        <span class="text-muted">*Название маленькими буквами латиницей, без пробелов (разделение через "-" или "_")</span>
                        <br><br>
                        <x-form.btn>Сохранить</x-form.btn>
                    </x-form.form>
                </div>
            </div>
        </div>
    </x-tabs.tabs-pane>
    <x-tabs.tabs-pane tab-id="areaTab" content-id="areaContent" active="true">
        <div class="row document-constructor">
            <input type="hidden" id="form-inputs" value="{{ implode(';', $names) }}">
            <input type="hidden" id="form-groups" value="{{ implode(';', $groups) }}">
            <div class="col-8">
                <div class="bg-white block">
                    <h4>Содержимое вставки</h4>
                    <ul class="document-area document-area-area bg-light rounded-lg rounded p-2 py-3 mt-3">

                    </ul>
                    <x-form.form action="{{ route('admin.areas.update', ['area' => $area->id]) }}">
                        <input type="hidden" name="areas" value="{{ $area->areas }}">
                        <x-form.btn>Сохранить</x-form.btn>
                    </x-form.form>
                </div>
            </div>
            <div class="col-4">
                <div class="bg-white block">
                    <h4>Элементы</h4>
                    <ul class="document-area-trash rounded alert alert-danger py-3 mt-3" style="border: 0px; display: grid; place-items: center;">
                        <i class="text-danger fa-solid fa-trash"></i>
                    </ul>
                    <ul class="document-area document-area-tools bg-light rounded-lg rounded p-2 py-3 mt-3">

                    </ul>
                </div>
            </div>
        </div>
    </x-tabs.tabs-pane>
</x-tabs.tabs-content>

@endSection