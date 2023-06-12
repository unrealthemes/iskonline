@extends('layouts.admin.base-admin-page')

@section('title', $record[$info['record_title_column']].' (редактирование)')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.$info[table].index") }}'>{{ $info['title'] }}</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.$info[table].edit", ["$info[record_name]" => $record->id]) }}'>Редактирование</x-menu.breadcrumb-item>
@endSection


@section('section-content')
<x-layout.row>
    <x-blocks.block>
        <x-form.form action='{{ route("admin.$info[table].store") }}'>
            @foreach($info['columns'] as $column)
            <x-form.input name="{{ $column['name'] }}" label="{{ $column['label'] }}" type="{{ $column['type'] }}" value="{{ $record[$column['name']] }}"></x-form.input>
            @endForeach
            <x-form.btn>Сохранить</x-form.btn>
        </x-form.form>
    </x-blocks.block>
</x-layout.row>

@endSection