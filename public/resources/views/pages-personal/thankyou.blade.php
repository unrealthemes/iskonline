@extends('layouts.base')

@section('title', 'Спасибо за оплату')

@section('content')
<x-layout.section>
    <x-layout.container>
        <h1 class="fw-bold">Спасибо за оплату! Ваш документ готов</h1>
        <p class='fs-5 mt-3'>Каждый оплаченный документ позволяет нам увеличивать количество сервисов для упрощения все больших задач!</p>
        <br>
        <x-form.btn class='btn-lg' link='{{ route("documents.get", ["application" => $application]) }}'>Скачать документ</x-form.btn>
    </x-layout.container>
</x-layout.section>
@endSection