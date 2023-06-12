@extends('layouts.admin.base-admin-page')

@section('title', 'Управление группами')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.forms.index") }}'>Формы</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.forms.groups.index") }}'>Группы</x-menu.breadcrumb-item>
@endSection


@section('section-content')

@endSection