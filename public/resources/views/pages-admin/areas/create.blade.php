@extends('layouts.admin.base-admin-page')

@section('title', 'Добавление элемента вставки')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.services.index") }}'>Сервисы</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.services.edit", ["service" => $service->id]) }}'>{{ $service->name }}</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.areas.index", ["service" => $service->id]) }}'>Элементы вставки</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.areas.create", ["service" => $service->id]) }}'>Создание</x-menu.breadcrumb-item>
@endSection

@section('actions')
<x-form.btn link="{{ route('admin.areas.create', ['service' => $service->id]); }}">Создать</x-form.btn>
@endSection

@section('section-content')
<div class="row">
    <div class="col-6">
        <div class="bg-white block">
            <x-form.form action="{{ route('admin.areas.store', ['service' => $service->id]) }}">
                <input type="hidden" name="areas" value="[]">
                <x-form.input name="name" label="Название" form-floating="true"></x-form.input>
                <span class="text-muted">*Название маленькими буквами латиницей, без пробелов (разделение через "-" или "_")</span>
                <br><br>
                <x-form.btn>Сохранить</x-form.btn>
            </x-form.form>
        </div>
    </div>

</div>
@endSection