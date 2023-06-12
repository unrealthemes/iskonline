@extends('layouts.admin.base-admin-page')

@section('title', 'Управление шагами форм')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.forms.index") }}'>Формы</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.forms.steps.index") }}'>Шаги</x-menu.breadcrumb-item>
@endSection


@section('section-content')

@endSection