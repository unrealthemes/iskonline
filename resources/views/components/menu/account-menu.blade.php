@if ($auth)
<x-layout.menu-dropdown btn='true' text='{{ $name }}' link=''>

    <x-layout.menu-dropdown-item link="{{ route('account.profile') }}">Профиль</x-layout.menu-dropdown-item>
    <x-layout.menu-dropdown-item link="{{ route('account.applications') }}">Документы</x-layout.menu-dropdown-item>

    @if ($user->status == 0)
    <x-layout.menu-dropdown-item link="{{ route('admin.index') }}">Админка</x-layout.menu-dropdown-item>
    @endIf

    <x-layout.menu-dropdown-item hr="1"></x-layout.menu-dropdown-item>
    <x-layout.menu-dropdown-item link="{{ route('logout') }}">Выйти</x-layout.menu-dropdown-item>
</x-layout.menu-dropdown>
@else
<!-- <x-form.btn link='{{ route("login") }}' color='outline-primary'>Войти</x-form.btn> -->
{{-- <x-form.btn link="{{ route('login') }}" color="small" class="text-primary bg-ghost">Вход</x-form.btn>
<x-form.btn link="{{ route('register') }}" color="small" class="text-primary bg-ghost">Регистрация</x-form.btn> --}}
<a class="header__enter" href="{{ route('login') }}">Вход</a>
<a class="header__reg btn" href="{{ route('register') }}">Регистрация</a>
@endif