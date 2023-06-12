@extends('layouts.admin.base-admin-page')

@section('title', $info['title'].' (создание)')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.$info[table].index") }}'>{{ $info['title'] }}</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.$info[table].create") }}'>Создание</x-menu.breadcrumb-item>
@endSection


@section('section-content')
<x-layout.row>
    <x-blocks.block>
        <x-form.form action='{{ route("admin.$info[table].store") }}'>
            @foreach($info['columns'] as $column)
            <x-form.input name="{{ $column['name'] }}" label="{{ $column['label'] }}" type="{{ $column['type'] }}"></x-form.input>
            @endForeach
            <x-form.btn>Сохранить</x-form.btn>
        </x-form.form>
    </x-blocks.block>
</x-layout.row>

@endSection