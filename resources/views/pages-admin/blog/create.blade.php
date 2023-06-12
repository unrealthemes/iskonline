@extends('layouts.admin.base-admin-page')

@section('title', 'Создание страницы')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.blog.index") }}'>Страницы</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.blog.create") }}'>Создание</x-menu.breadcrumb-item>
@endSection


@section('section-content')
<div class="row">
    <div class="bg-white block">
        <x-form.form action="{{ route('admin.blog.store') }}" class="">
            <x-form.input name="h1" label="Заголовок" class="form-control-lg" required="true"></x-form.input>
            <x-form.input name="subtitle" label="Подзаголовок" required="true"></x-form.input>
            <x-form.input type="file" name="preview" label="Превью" required="true"></x-form.input>
            <div class="row mt-5">
                <div class="col-6">
                    <x-form.input name='link' label="Ссылка" form-floating="true" required="true"></x-form.input>
                </div>
                <div class="col-6">
                    <x-form.input name='title' label="Title" form-floating="true" required="true"></x-form.input>
                </div>
                <div class="col-6">
                    <x-form.input type="textarea" name='keywords' label="Keywords" form-floating="true" rows="5" required="true"></x-form.input>
                </div>
                <div class="col-6">
                    <x-form.input type="textarea" name='description' label="Description" form-floating="true" rows="5" required="true"></x-form.input>
                </div>
                <div class="col-12">
                    <x-form.input name="icon_class" label="Класс иконки Fontawesome" form-floating="true" required="true"></x-form.input>
                </div>
            </div>
            <div class="mt-5">
                <x-form.checkbox name="show_author_block" label="Показывать автора" checked="true"></x-form.checkbox>
                <x-form.checkbox name="show_form_block" label="Показывать форму" checked="true"></x-form.checkbox>
                <x-form.checkbox name="show_share_block" label="Показывать блок 'Поделиться'" checked="true"></x-form.checkbox>
            </div>

            <div class="mt-5">
                <x-form.input type="textarea" name="text" label="HTML страницы" rows="10" required="true"></x-form.input>
            </div>

            <x-form.btn class="mt-3">Сохранить</x-form.btn>
        </x-form.form>
    </div>
</div>
@endSection