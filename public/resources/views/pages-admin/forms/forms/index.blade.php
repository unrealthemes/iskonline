@extends('layouts.admin.base-admin-page')

@section('title', 'Управление формами')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.forms.forms.index") }}'>Формы</x-menu.breadcrumb-item>
@endSection

@section('actions')
<x-form.btn link="{{ route('admin.forms.forms.create'); }}">Создать</x-form.btn>
@endSection

@section('section-content')
<div class="row">
    <div class="bg-white block">
        <table id="applicationsTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Форма</th>
                    <th>Сервис</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($forms as $form)
                @if (isset($services[$form->service_id]))
                <tr>
                    <td><a href="{{ route('admin.forms.forms.edit', ['form' => $form->id]) }}" class="text-primary">{{ $form->name }}</a></td>
                    <td><a href="{{ route('admin.services.edit', ['service' => $form->service_id]) }}" class="text-primary">{{ $services[$form->service_id] }}</a></td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endSection