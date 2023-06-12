@extends('layouts.base')

@section('title', $blog->title)

@section('meta')
<meta name="description" content="{{ $blog->description }}">
<meta name="keywords" content="{{ $blog->keywords }}">
@endSection

@section('content')

<!-- Начальная секция -->
<section class='hero gradient-1'>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
                <h1>
                    {!! $blog->h1 !!}
                </h1>
                <p class='hero-text'>{!! $blog->subtitle !!}</p>

            </div>
            <div class="col-12 col-lg-4">
                <div class="hero-icon">
                    <i class="{{ $blog->icon_class }}"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        @if ($blog->show_author_block)
        <div class="block bg-white" style="float: left; display: inline-block; margin-right: 30px; margin-bottom: 30px; width: 274px;">
            <img src="{{ asset('/images/founder.png') }}" width="100" alt="Preview" class="img rounded rounded-lg w-100">
            <p class="fs-5 mt-3"><b>Фёдор Кременьщуков</b></p>
            <p style="line-height: 1; margin: 5px 0px;"><span class="text-primary">Старший юрист</span><br>Опыт 17 лет</p>
        </div>
        @endif
        {!! $text !!}
        @if ($blog->show_share_block)
        <div class="block bg-white py-4 mt-3">
            <div class="d-flex align-items-center gap-2">
                <p class="text-secondary">Поделиться:</p>
                <a href="https://ok.ru" class="social">
                    <i class="fa-brands fa-odnoklassniki"></i>
                </a>
                <a href="https://vk.com" class="social">
                    <i class="fa-brands fa-vk"></i>
                </a>
                <a href="https://t.me" class="social">
                    <i class="fa-solid fa-paper-plane"></i>
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

<section>
    <div class="container">
        <h2>Другие статьи</h2>

        <x-blog.blog-list except="{{ $blog->id }}"></x-blog.blog-list>
    </div>
</section>

@if ($blog->show_form_block)
<section>
    <div class="container">
        <h2>Остались вопросы?</h2>
        <div class="block bg-white mt-4">
            <x-form.form action="{{ route('contacts-post') }}">
                <input type="hidden" name="captcha_token" id="captcha_token">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-form.input required="true" name="fio" label="Ваше ФИО" form-floating="true"></x-form.input>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form.input required="true" type="email" name="email" label="Email" form-floating="true"></x-form.input>
                    </div>
                </div>
                <div class="mt-3 mb-3">
                    <x-form.input required="true" type="textarea" name="msg" label="Ваше сообщение" form-floating="true" rows="5"></x-form.input>
                </div>

                <x-form.btn>Отправить</x-form.btn>
                <p class="text-muted mt-2">*Нажимая на кнопку "Отправить", Вы соглашаетесь с <a target="_blank" class="text-primary" href="{{ route('license-agreement') }}">политикой сайта</a></p>
            </x-form.form>
        </div>
    </div>

</section>
@endif

@endSection