@extends('layouts.admin.base-admin-page')

@section('title', 'Управление формами')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.forms.index") }}'>Формы</x-menu.breadcrumb-item>
@endSection


@section('section-content')
<div class="row">
    <div class="col-3">
        <div class="block bg-white">
            <h3><a href="{{ route('admin.forms.forms.index') }}">Формы</a></h3>
        </div>
    </div>
    <div class="col-3">
        <div class="block bg-white">
            <h3><a href="{{ route('admin.forms.steps.index') }}">Шаги</a></h3>
        </div>
    </div>
    <div class="col-3">
        <div class="block bg-white">
            <h3><a href="{{ route('admin.forms.groups.index') }}">Группы</a></h3>
        </div>
    </div>
    <div class="col-3">
        <div class="block bg-white">
            <h3><a href="{{ route('admin.forms.inputs.index') }}">Поля ввода</a></h3>
        </div>
    </div>
</div>
@endSection