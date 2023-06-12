@extends('layouts.base-admin')

@section('content')
<x-layout.section>
    <x-layout.container>
        <x-blocks.jumbotron bg='light'>
            <div class="py-5">
                <h1 class="display-5 fw-bold">Авторизация</h1>
                <x-form.form action='{{ route("auth") }}'>
                    <x-form.input type='email' name='email' label='Email' />
                    <x-form.input type='password' name='password' label='Пароль' />
                    <x-form.btn>Войти</x-form.btn>
                </x-form.form>
            </div>
        </x-blocks.jumbotron>
        <div class="center mt-5">
            <x-form.btn color='warning ' link='{{ route("home") }}'>На главную</x-form.btn>
        </div>
    </x-layout.container>
</x-layout.section>
@endSection