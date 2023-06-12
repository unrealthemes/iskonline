@extends('layouts.base')

@section('title', 'Регистрация')

@section('content')
<x-layout.section>
    <x-layout.container>
        <div class="row">
            <div class="col-12 col-md-3 col-lg-4">

            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="block bg-white">
                    <h2 class="text-center">Регистрация</h2>
                    <x-form.form action='{{ route("register.confirmation") }}' method="GET" class="mt-4 mb-4">
                        <x-form.input form-floating='true' data-tel name='tel' type='tel' label='Телефон'></x-form.input><br>
                        <div class="text-center">
                            <x-form.btn class='btn-lg d-block w-100'>Зарегистрироваться</x-form.btn><br>
                            <p>Уже есть аккаунт? <a href="{{ route('login') }}" class="text-primary">Войти</a></p>
                        </div>
                    </x-form.form>
                </div>
            </div>
        </div>
    </x-layout.container>
</x-layout.section>
@endSection