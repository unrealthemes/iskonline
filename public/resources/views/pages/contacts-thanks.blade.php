@extends('layouts.base')

@section('title', 'Спасибо за обращение')

@section('content')
<x-layout.section>
    <x-layout.container>
        <h1 class="fw-bold">Спасибо за обращение!</h1>
        <p class='fs-5 mt-3'>Мы в скором времени Вам ответим</p>
        <br>
        <x-form.btn class='btn-lg' link='{{ route("contacts") }}'>Назад</x-form.btn>
    </x-layout.container>
</x-layout.section>
@endSection