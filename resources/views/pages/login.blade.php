@extends('layouts.base')

@section('title', 'Вход в личный кабинет')

@section('content')
<x-layout.section>
    <x-layout.container>
        <div class="row">
            <div class="col-12 col-md-3 col-lg-4">

            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="block bg-white">
                    <h2 class="text-center">Вход в аккаунт</h2>
                    <x-form.form action='{{ route("login.confirmation") }}' method="GET" class="mt-4 mb-4">
                        <x-form.input form-floating='true' name='tel' type='tel' label='Телефон'></x-form.input><br>
                        <div class="text-center">
                            <x-form.btn class='btn-lg w-100 mb-3'>Войти</x-form.btn><br>
                            <p>Еще нет аккаунта? <a href="{{ route('register') }}" class="text-primary">Создать аккаунт</a></p>
                        </div>
                    </x-form.form>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-4">

            </div>
        </div>

    </x-layout.container>
</x-layout.section>
@endSection