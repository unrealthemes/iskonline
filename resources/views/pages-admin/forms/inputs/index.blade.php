@extends('layouts.admin.base-admin-page')

@section('title', 'Управление полями ввода')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.forms.index") }}'>Формы</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.forms.inputs.index") }}'>Поля ввода</x-menu.breadcrumb-item>
@endSection


@section('section-content')

@endSection