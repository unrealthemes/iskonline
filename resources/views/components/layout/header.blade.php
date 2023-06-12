<header class="header">
    <div class="container">
        <div class="header__row">

            <!-- Левая часть шапки -->
            <a href="{{ route('home'); }}" class="logo logo--header">иск<span class="text--blue">.</span>онлайн</a>
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
            <button class="burger d-flex d-md-none">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Правая часть шапки -->
            <div class="header__lk d-md-flex d-none">
                <x-menu.account-menu></x-menu.account-menu>
            </div>
        </div>
    </div>
</header>

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