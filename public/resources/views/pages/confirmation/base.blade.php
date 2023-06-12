@extends('layouts.base')

@section('title', 'Подтверждение действия')

@section('content')
<x-layout.section>
    <x-layout.container>
        <div class="row">
            <div class="col-12 col-md-3 col-lg-4">

            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="block bg-white">
                    <h2 class="text-center">@yield('title')</h2>
                    <x-form.form action='{{ $action }}' method="GET" class="no-send mt-4 mb-4">
                        <x-form.input form-floating='true' data-tel name='code' type='number' label='Код подтверждения'></x-form.input><br>
                        <input type="hidden" name="tel" value="@yield('tel')">
                        <div class="text-center">
                            <x-form.btn class='btn-lg d-block w-100'>Подтвердить</x-form.btn><br>
                            <x-form.btn class='btn-lg d-none w-100 repeat-code' color='info' role='button'>Отправить повторно</x-form.btn><br>
                            <span class="text-center text-muted mt-2"></span>
                        </div>
                    </x-form.form>
                </div>
            </div>
        </div>
    </x-layout.container>
</x-layout.section>
@endSection