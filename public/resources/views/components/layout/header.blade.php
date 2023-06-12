<header class="header i-s-k">
    <div class="container">
        <div class="row">

            <!-- Левая часть шапки -->
            <div class="col-lg-2 col-md-3 col-9">
                <a href="{{ route('home'); }}" class="logo logo--header">иск<span class="text--blue">.</span>онлайн</a>
            </div>
            <div class="col-lg-4 col-md-5 col-3">
                <ul class="header__nav d-md-flex d-none">
                <li class="header__nav-item">
                    <a href="{{ route('about') }}" class="header__nav-link">О нас</a>
                </li>
                <li class="header__nav-item">
                    <a href="{{ route('blog') }}" class="header__nav-link">Блог</a>
                </li>
                <li class="header__nav-item">
                    <a href="{{ route('contacts') }}" class="header__nav-link">Контакты</a>
                </li>
                </ul>
                <div class="justify-content-end align-items-center d-flex d-md-none">
                <button class="burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                </div>
            </div>

            {{-- <!-- Левая часть шапки -->
            <div class="d-flex align-items-center">
                <a href="{{ route('home'); }}" class="brand text-primary">иск.онлайн</a>
                <ul class="menu lg-hidden">
                    <li><a href="{{ route('about') }}">О нас</a></li>
                    <li><a href="{{ route('contacts') }}">Контакты</a></li>
                    <li><a href="{{ route('blog') }}">Блог</a></li>
                </ul>
                <div class="lg-show ms-4 sm-hidden">
                    <div class="burger" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas" aria-controls="mobileMenuOffcanvas">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div> --}}

            {{-- <!-- Правая часть шапки -->
            <div class="d-flex align-items-center gap-3 sm-hidden">
                <x-menu.account-menu></x-menu.account-menu>
            </div>

            <div class="sm-show">
                <div class="burger" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas" aria-controls="mobileMenuOffcanvas">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div> --}}

            <!-- Правая часть шапки -->
            <div class="col-lg-3 col-md-4 offset-lg-3 justify-content-md-end d-md-flex d-none">
                <x-menu.account-menu></x-menu.account-menu>
            </div>
        </div>
    </div>
</header>
<!-- Выезжающее меню -->
{{-- <div class="offcanvas offcanvas-top" tabindex="-1" id="mobileMenuOffcanvas" aria-labelledby="mobileMenuOffcanvas">
    <div class="offcanvas-header">
        <p class="offcanvas-title fs-5" id="mobileMenuOffcanvas">Меню</p>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="menu vertical">
            <li><a href="{{ route('about') }}">О нас</a></li>
            <li><a href="{{ route('contacts') }}">Контакты</a></li>
            <li><a href="{{ route('blog') }}">Блог</a></li>
        </ul>
        <div class="d-flex flex-column align-items-start gap-3 mt-3 sm-show">
            <x-menu.account-menu></x-menu.account-menu>
        </div>

    </div>
</div> --}}

<!-- Выезжающее меню -->
<div class="mob-menu" style="display: none;">
    <button class="mob-menu__close">Закрыть</button>
    <div class="mob-menu__container">
        <div class="mob-menu__account">
            <x-menu.account-menu></x-menu.account-menu>
        </div>
        <ul class="mob-menu__nav">
            <li class="mob-menu__nav-item"><a href="{{ route('about') }}" class="mob-menu__link">О нас</a></li>
            <li class="mob-menu__nav-item"><a href="{{ route('blog') }}" class="mob-menu__link">Блог</a></li>
            <li class="mob-menu__nav-item"><a href="{{ route('contacts') }}" class="mob-menu__link">Контакты</a></li>
        </ul>
    </div>
</div>