<!-- <footer class="navbar-fixed-bottom border-top bg-light py-3">
    <x-layout.container>
        <x-layout.row>
            <x-layout.column4>
                <a class='text-decoration-none' href="{{ route('contacts') }}">Контактыы</a><br>
                <a class='text-decoration-none' href="{{ route('license-agreement') }}">Пользовательское соглашение</a>
            </x-layout.column4>
        </x-layout.row>
    </x-layout.container>
</footer> -->

{{--
<!-- Подвал -->
<footer>
    <x-layout.container>
        <div class="row">
            <div class="col-12 col-md-3">
                <ul class="menu vertical footer-menu mt-3">
                    <li><a href="{{ route('account.profile') }}">Личный кабинет</a></li>
                    <li><a href="{{ route('login') }}">Вход</a></li>
                    <li><a href="{{ route('register') }}">Регистрация</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-3">
                <ul class="menu vertical footer-menu mt-3">
                    <li><a href="mailto:coderlair@yandex.ru">Помощь</a></li>
                    <li><a href="{{ route('contacts') }}">Контакты</a></li>
                    <li><a href="{{ route('license-agreement') }}">Правовая информация</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-6">
                <div class="footer-social d-flex align-items-center justify-content-end gap-3 mt-3">
                    <!-- <a href="https://ok.ru" class="social">
                        <i class="fa-brands fa-odnoklassniki"></i>
                    </a>
                    <a href="https://vk.com" class="social">
                        <i class="fa-brands fa-vk"></i>
                    </a>
                    <a href="https://t.me" class="social">
                        <i class="fa-solid fa-paper-plane"></i>
                    </a> -->
                </div>
            </div>
        </div>
    </x-layout.container>
</footer> --}}

<!-- Подвал -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="row">
                    <div class="col-sm-12 col-6">
                        <div class="logo logo--footer">иск<span class="text--blue">.</span>онлайн</div>
                    </div>
                    <div class="col-sm-12 col-6">
                        <ul class="footer__social">
                            <div class="footer__social-item">
                                <a href="#" class="footer__social-link" style="background-image: url(img/icons/ok.svg);">Одноклассники</a>
                            </div>
                            <div class="footer__social-item">
                                <a href="#" class="footer__social-link" style="background-image: url(img/icons/vk.svg);">Вконтакте</a>
                            </div>
                            <div class="footer__social-item">
                                <a href="#" class="footer__social-link" style="background-image: url(img/icons/tg.svg);">Телеграм</a>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6">
                <ul class="footer__menu">
                    <li class="footer__menu-item"><a href="{{ route('about') }}" class="footer__menu-link">О нас</a></li>
                    <li class="footer__menu-item"><a href="{{ route('blog') }}" class="footer__menu-link">Блог</a></li>
                    <li class="footer__menu-item"><a href="{{ route('contacts') }}" class="footer__menu-link">Контакты</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-6">
                <ul class="footer__menu">
                    <li class="footer__menu-item"><a href="{{ route('login') }}" class="footer__menu-link">Вход</a></li>
                    <li class="footer__menu-item"><a href="{{ route('register') }}" class="footer__menu-link">Регистрация</a></li>
                    <li class="footer__menu-item"><a href="{{ route('account.profile') }}" class="footer__menu-link">Личный кабинет</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="footer__menu">
                    <li class="footer__menu-item"><a href="mailto:coderlair@yandex.ru" class="footer__menu-link">Помощь</a></li>
                    <li class="footer__menu-item"><a href="{{ route('license-agreement') }}" class="footer__menu-link">Правовая информация</a></li>
                    <li class="footer__menu-item"><a href="{{ asset('docs/license_agreement.docx') }}" class="footer__menu-link" target="_blank">Пользовательское соглашение</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>