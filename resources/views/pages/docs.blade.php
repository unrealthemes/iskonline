@extends('layouts.base')

@section('title', 'Правовая информация')

@section('content')

<x-layout.section bg=''>
    <x-layout.container>
        <div class="block bg-white">
            <h2>Пользовательское соглашение</h2><br>
            <a href="{{ asset('docs/license_agreement.docx') }}" target="_blank" class="btn btn-primary">Скачать</a>
        </div>
        <div class="block bg-white mt-4">
            <h2>Соглашение на обработку персональных данных</h2><br>
            <a href="{{ asset('docs/personal_data_processing_agreement.docx') }}" target="_blank" class="btn btn-primary">Скачать</a>
        </div>
        <div class="block bg-white mt-4">
            <h2>Гарантийная политика</h2><br>
            <a href="{{ asset('docs/warranty_policy.docx') }}" target="_blank" class="btn btn-primary">Скачать</a>
        </div>
        <div class="block bg-white mt-4">
            <h2>Публичная оферта</h2><br>
            <a href="{{ asset('docs/public_offer.docx') }}" target="_blank" class="btn btn-primary">Скачать</a>
        </div>
    </x-layout.container>
</x-layout.section>

@endSection