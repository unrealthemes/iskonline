@extends('layouts.base')

@section('title', 'Ответ сервиса')

@section('content')

<x-layout.section bg=''>
    <x-layout.container>
        <h2>Результат</h2>
        <br>
        <div class="block bg-white">
            {!! $answer !!}
        </div>
    </x-layout.container>
</x-layout.section>

@endSection