@extends('layouts.base')

@section('title', "Наш блог")


@section('content')

<section>
    <div class="container">
        <h2>Наши статьи</h2>

        <x-blog.blog-list limit="-1"></x-blog.blog-list>
    </div>
</section>


@endSection