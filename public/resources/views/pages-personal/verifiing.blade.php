@extends('layouts.base')

@section('title', 'Личный кабинет')

@section('content')
<x-layout.section>
    <x-layout.container>
        <x-blocks.jumbotron bg='light'>
            <h1 class="display-5 fw-bold">Подтвердите почту</h1>
            <p class='fs-5 mt-3'>Личный кабинет создан, но чтобы начать им пользоваться, Вам необходимо подтвердить email. Письмо для подтверждения отправлено на почту <span class='text-primary'>{{ $user->email }}</span></p>
        </x-blocks.jumbotron>
    </x-layout.container>
</x-layout.section>
@endSection