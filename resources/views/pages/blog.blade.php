{{-- Коллекция записей блогов --}}

@extends('layouts.base')
@section('title', "Наш блог")

<div class="header-decor header-decor--blog"></div>


@section('content')

<section class="p-0">
    <div class="container">
        <h1>Блог</h1>

        <div class="blogs-collection">
            <x-blog.blog-list limit="-1"></x-blog.blog-list>
        </div>
    </div>
</section>


@endSection