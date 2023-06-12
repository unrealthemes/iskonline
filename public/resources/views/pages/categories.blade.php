@extends('layouts.base')

@section('content')
<x-layout.section>
    <x-layout.container>
        <x-menu.breadcrumb>
            <x-menu.breadcrumb-item link="{{ route('home') }}">Главная</x-menu.breadcrumb-item>
            <x-menu.breadcrumb-item link="{{ route('categories') }}">Категории документов</x-menu.breadcrumb-item>
        </x-menu.breadcrumb>
        <h1>Категории документов</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        <x-layout.row>
            <x-layout.column12>

            </x-layout.column12>
            <x-layout.column12>
                <x-blocks.block>
                    <h3>Гражданское право</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, ipsa.</p>
                    <x-form.btn color='outline-primary'>Услуги</x-form.btn>
                </x-blocks.block>
            </x-layout.column12>
            <x-layout.column12>
                <x-blocks.block>
                    <h3>Гражданское право</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, ipsa.</p>
                    <x-form.btn color='outline-primary'>Услуги</x-form.btn>
                </x-blocks.block>
            </x-layout.column12>
            <x-layout.column12>
                <x-blocks.block>
                    <h3>Гражданское право</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, ipsa.</p>
                    <x-form.btn color='outline-primary'>Услуги</x-form.btn>
                </x-blocks.block>
            </x-layout.column12>
        </x-layout.row>


    </x-layout.container>
</x-layout.section>
@endSection