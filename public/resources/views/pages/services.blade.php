@extends('layouts.base')

@section('title', 'Сервисы')

@section('content')
<x-layout.section bg='light'>
    <x-layout.container>
        <x-layout.row>
            <x-layout.column7>
                <h1 class="display-5 fw-bold">Наши сервисы</h1>
                <p class='fs-5 mt-3'>Здесь представлены все наши сервисы, способные упростить Вам процесс работы с юридическими документами</p>
            </x-layout.column7>
        </x-layout.row>
    </x-layout.container>
</x-layout.section>

<x-service.services-list show-all='true'></x-service.services-list>
@endSection