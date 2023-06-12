@extends('layouts.admin.base-admin-page')

@section('title', $form->name)

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.forms.forms.index") }}'>Формы</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.forms.forms.edit", ["form" => $form->id]) }}'>Редактирование</x-menu.breadcrumb-item>
@endSection

@section('actions')
<x-form.btn class="confirm" color="danger" link="{{ route('admin.forms.forms.delete', ['form' => $form->id]); }}">Удалить</x-form.btn>
@endSection

@section('section-content')
<div class="row">
    <x-tabs.tabs>
        <x-tabs.tabs-button tab-id="main" content-id="mainContent">Данные формы</x-tabs.tabs-button>
        <x-tabs.tabs-button tab-id="constructor" content-id="constructorContent" active="true">Конструктор</x-tabs.tabs-button>
        <x-tabs.tabs-button tab-id="names" content-id="namesContent">Имена полей и групп</x-tabs.tabs-button>
    </x-tabs.tabs>

    <x-tabs.tabs-content>
        <x-tabs.tabs-pane tab-id="main" content-id="mainContent">
            <div class="bg-white block">
                <h4>Данные формы</h4>
                <x-form.form action="{{ route('admin.forms.forms.update', ['form' => $form->id]) }}" class="mt-4">
                    <x-form.input name="name" label="Название" form-floating="true" value="{{ $form->name }}"></x-form.input>
                    <x-form.input type="select" name="service_id" label="Сервис" form-floating="true">
                        @foreach ($services as $key => $value)
                        <option value="{{ $key }}" {{ $key == $form->service_id ? "selected" : "" }}>{{ $value }}</option>
                        @endForeach
                    </x-form.input>
                    <x-form.btn class="mt-3">Сохранить</x-form.btn>
                </x-form.form>
            </div>
        </x-tabs.tabs-pane>
        <x-tabs.tabs-pane tab-id="constructor" content-id="constructorContent" active="true">
            <x-form-constructor form-id="{{ $form->id }}"></x-form-constructor>
        </x-tabs.tabs-pane>
        <x-tabs.tabs-pane tab-id="names" content-id="namesContent">
            <div class="block bg-white">
                <h4>Имена полей формы</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Имя поля</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($names as $name)
                        <tr>
                            <td>{{ $name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3 block bg-white">
                <h4>Имена групп формы</h4>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Имя группы</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                        @if ($group)
                        <tr>
                            <td>{{ $group }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-tabs.tabs-pane>
    </x-tabs.tabs-content>

    <script src=""></script>
</div>
@endSection