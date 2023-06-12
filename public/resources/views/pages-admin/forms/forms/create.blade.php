@extends('layouts.admin.base-admin-page')

@section('title', 'Создание формы')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.forms.forms.index") }}'>Формы</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.forms.forms.create") }}'>Создание</x-menu.breadcrumb-item>
@endSection


@section('section-content')
<div class="row">
    <div class="bg-white block">
        <h4>Данные формы</h4>
        <x-form.form action="{{ route('admin.forms.forms.store') }}" class="mt-4">
            <x-form.input name="name" label="Название" form-floating="true"></x-form.input>
            <x-form.input type="select" name="service_id" label="Сервис" form-floating="true">
                @foreach ($services as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
                @endForeach
            </x-form.input>
            <x-form.btn class="mt-3">Сохранить</x-form.btn>
        </x-form.form>
    </div>
</div>
@endSection