@extends('layouts.base-admin')

@section('header')
<x-layout.header-admin></x-layout.header-admin>
@endSection

@section('sidebar')
<x-layout.sidebar></x-layout.sidebar>
@endSection

@section('content')
<x-layout.section-admin>
    <x-layout.container fluid='1'>
        <x-menu.breadcrumb>
            <x-menu.breadcrumb-item link="{{ route('admin.index') }}">Админ. панель</x-menu.breadcrumb-item>
            @yield('breadcrumbs')
        </x-menu.breadcrumb>


        <div class="border-bottom pb-2 d-flex justify-content-between align-items-center mb-3">
            <h1>@yield('title')</h1>
            <div class="d-flex align-items-center gap-1">
                @yield('actions')
            </div>
        </div>

        @yield('section-content')
    </x-layout.container>
</x-layout.section-admin>
@endSection