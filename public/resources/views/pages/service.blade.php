@extends('layouts.base')

@section('meta')
@foreach(explode(';', $service->meta) as $meta)
<meta name="{{ explode('=', $meta)[0] }}" content="{{ explode('=', $meta)[1] }}">
@endForeach
@endSection

@section('title', $service->title)

@section('content')

<?php $decors = [1, 2, 4, 5]; ?>

@if (in_array($service->id, $decors))
    <div class="header-decor header-decor--{{ $service->id }}"></div>
@endif
{{-- <!-- {{ $service->id }} --> --}}
<section class='hero'>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1>{{ $service->h1 }}</h1>
                <p class='hero-text'>{{ $service->description }} @if ($service->price > 0) всего за {{ $service->price }} руб. @endif</p>
            </div>
        </div>
    </div>

    @if (in_array($service->id, $decors))
        <div class="header-decor-mob header-decor-mob--{{ $service->id }} d-block d-lg-none"></div>
    @endif
</section>


<x-service.service-form-section :service="$service"></x-service.service-form-section>

<section class="pt-2">
    <div class="container">
        <span class="fs-4 fw-bold " id="service">О сервисе</span>

        <div class="about">
            <div class="row">
                <div class="col-12">
                    {!! $service->text !!}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <x-layout.section>
    <x-layout.container>
        <h2 class="text-center">Видео о сервисе</h2>
        <br>
        <x-layout.row>
            @foreach(explode(";", $service->videos) as $video)
            <x-layout.column6>
                <iframe class="rounded shadow" width="100%" height="315" src="{{ $video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </x-layout.column6>
            @endforeach

        </x-layout.row>
    </x-layout.container>
</x-layout.section> -->
@endSection