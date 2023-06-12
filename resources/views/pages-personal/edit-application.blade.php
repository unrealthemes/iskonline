@extends('layouts.base')

@section('title', 'Редактирование документа')

@section('content')
<x-layout.section>
    <x-layout.container>
        <h1 class="">{{ $service->name }}</h1>
        <div class="text-danger">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Вы можете редактировать данные документа только один раз!
        </div>
    </x-layout.container>
</x-layout.section>

<x-service.service-form-section :service="$service" :application="$application"></x-service.service-form-section>
@endSection