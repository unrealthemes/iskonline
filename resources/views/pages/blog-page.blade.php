@extends('layouts.base')

@section('title', $blog->title)

@section('meta')
<meta name="description" content="{{ $blog->description }}">
<meta name="keywords" content="{{ $blog->keywords }}">
@endSection

@section('content')

<div class="header-decor header-decor--blog-single"></div>

<!-- Начальная секция -->
<section class="blog-single__main">
    <div class="container">
        @if ($blog->preview) 
            <div class="blog-single__cover">
                <img src="{{ $blog->preview }}" alt="{{ $blog->h1 }}">
            </div>
        @endif
        <h1>{!! $blog->h1 !!}</h1>
        {{-- <p class='hero-text'>{!! $blog->subtitle !!}</p> --}}
        @if ($blog->show_author_block)
        <div class="blog-author">
            <img src="{{ asset('/images/founder.png') }}" width="160" alt="Фёдор Кременьщуков" class="blog-author__cover">
            <div class="blog-author__text">
                <div class="blog-author__name">Фёдор Кременьщуков</div>
                <div class="blog-author__role">Старший юрист</div>
            </div>
        </div>
        @endif
        {!! $text !!}
        @if ($blog->show_share_block)
        <div class="row row--blog-share shadow-bottom">
            <div class="col-lg-4">
                <div class="social-media">
                    <div class="social-media__title h3">Поделиться</div>
                    <ul class="social-list social-list--blog">
                        <div class="social-list__item">
                            <a href="#" class="social-list__link social-list__link--ok">
                                <svg class="social-list__item-icon">
                                    <use xlink:href="/img/sprite-social.svg#ok"></use>
                                </svg>
                                <svg class="social-list__item-icon social-list__item-icon--hover">
                                    <use xlink:href="/img/sprite-social.svg#ok--dark"></use>
                                </svg>
                                Одноклассники
                            </a>

                        </div>
                        <div class="social-list__item">
                            <a href="#" class="social-list__link">
                                <svg class="social-list__item-icon">
                                    <use xlink:href="/img/sprite-social.svg#vk"></use>
                                </svg>
                                <svg class="social-list__item-icon social-list__item-icon--hover">
                                    <use xlink:href="/img/sprite-social.svg#vk--dark"></use>
                                </svg>
                                Вконтакте
                            </a>
                        </div>
                        <div class="social-list__item">
                            <a href="#" class="social-list__link">
                                <svg class="social-list__item-icon">
                                    <use xlink:href="/img/sprite-social.svg#tg"></use>
                                </svg>
                                <svg class="social-list__item-icon social-list__item-icon--hover">
                                    <use xlink:href="/img/sprite-social.svg#tg--dark"></use>
                                </svg>
                                Телеграм
                            </a>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<section>
    <div class="container">
        <h2>Другие статьи</h2>

        <div class="blog__slider-wrapper">
            <x-blog.blog-list except="{{ $blog->id }}"></x-blog.blog-list>
        </div>

    </div>
</section>

@if ($blog->show_form_block)
<section class="blog-articles">
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