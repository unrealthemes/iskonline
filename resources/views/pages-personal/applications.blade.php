@extends('layouts.base')

@section('title', 'Мои документы')

@section('content')
<x-layout.section>
    <x-layout.container>
        <h1 class="">Мои документы</h1>
        <br>
        <x-applications.applications-list></x-applications.applications-list>
    </x-layout.container>
</x-layout.section>
@endSection