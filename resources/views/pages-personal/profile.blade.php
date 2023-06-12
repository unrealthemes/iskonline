@extends('layouts.base')

@section('title', 'Данные профиля')

@section('content')
<x-layout.section>
    <x-layout.container>
        <h1 class="">Данные профиля</h1>
        <br>
        <div class="block bg-white">
            <x-form.form class='mb-3' action='{{ route("account.profile.update") }}'>
                <x-form.input form-floating='true' suggestions='fio' name='name' value='{{ $user->name }}' label='ФИО' />
                <x-form.input form-floating='true' suggestions='address' name='address' value='{{ $user->address }}' label='Адрес регистрации' />
                <x-form.input form-floating='true' name='email' value='{{ $user->email }}' label='Email' />
                <x-form.input form-floating='true' type='date' name='birthdate' value='{{ $user->birthdate }}' label='Дата рождения' />

                <x-form.input form-floating='true' type='passport' name='passport' value='{{ $user->passport }}' label='Паспорт' />
                <x-form.input form-floating='true' type='date' name='passport_when' value='{{ $user->passport_when }}' label='Когда выдан паспорт' />
                <x-form.input form-floating='true' type='text' name='passport_from' value='{{ $user->passport_from }}' label='Кем выдан паспорт' />

                <x-form.btn class="mt-3">Сохранить</x-form.btn>
            </x-form.form>

            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
        </div>

    </x-layout.container>
</x-layout.section>
@endSection