@extends('layouts.admin.base-admin-page')

@section('title', 'Управление элементами вставки')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.services.index") }}'>Сервисы</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.services.edit", ["service" => $service->id]) }}'>{{ $service->name }}</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.areas.index", ["service" => $service->id]) }}'>Элементы вставки</x-menu.breadcrumb-item>
@endSection

@section('actions')
<x-form.btn link="{{ route('admin.areas.create', ['service' => $service->id]); }}">Создать</x-form.btn>
@endSection

@section('section-content')
<div class="row">
    <div class="bg-white block">
        <table id="applicationsTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Элементы вставки</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($areas as $area)
                <tr>
                    <td><a href="{{ route('admin.areas.edit', ['area' => $area->id]) }}" class="text-primary">{{ $area->name }}</a></td>
                    <td>
                        <a href="{{ route('admin.areas.delete', ['area' => $area->id]) }}" class="confirm text-danger"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endSection