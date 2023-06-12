@extends('layouts.base-admin')

@section('header')
<x-layout.header-admin></x-layout.header-admin>
@endSection

@section('sidebar')
<x-layout.sidebar></x-layout.sidebar>
@endSection

@section('content')
<x-layout.section-admin>
    <x-layout.container fluid='1'>
        <x-form.form action="{{ route('calculator') }}">
            <x-blocks.block bg="light">
                <h3>Создание категории документов</h3>
                <x-layout.row>
                    <x-layout.column12>
                        <x-form.input name="fio" label="ФИО"></x-form.input>
                    </x-layout.column12>
                    <x-layout.column12>
                        <x-form.input name="inn" label="ИНН"></x-form.input>
                    </x-layout.column12>
                    <x-layout.column12>
                        <x-form.input name="adress" label="Адрес проживания"></x-form.input>
                    </x-layout.column12>
                </x-layout.row>

                <x-form.btn>Отправить</x-form.btn>
            </x-blocks.block>
        </x-form.form>
    </x-layout.container>
</x-layout.section-admin>
@endSection