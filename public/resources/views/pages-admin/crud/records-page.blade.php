@extends('layouts.admin.base-admin-page')

@section('title', $info['title'])

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.$info[table].index") }}'>{{ $info['title'] }}</x-menu.breadcrumb-item>
@endSection

@section('actions')
<x-form.btn color='primary' link='{{ route("admin.$info[table].create") }}'>Создать</x-form.btn>
@endSection

@section('section-content')
<x-layout.row>
    @foreach ($records as $record)
    <x-dynamic-component component="records.{{ $info['list_component'] }}.ListComponent" :record="$record"></x-dynamic-component>
    @endForeach
</x-layout.row>

@endSection