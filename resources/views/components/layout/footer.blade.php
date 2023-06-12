<section class="form-feedback__wrapper" id="">
    <div class="container">
        <div class="form-blue">
            <div class="h2">Напишите нам</div>
            <x-form.form action="{{ route('contacts-post') }}" class="form-feedback">
                <input type="hidden" name="captcha_token" id="captcha_token">
                <div class="form__text-bg d-md-none">
                    <p>Задайте вопрос или внесите свое предложение.</p>
                    <p>Наши специалисты вам обязательно ответят!</p>                            
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <x-form.input required="true" name="fio" label="Ваше имя" placeholder="Как к вам обращаться?" formFloating="true"></x-form.input>
                            </div>
                            <div class="col-12 col-md-6">
                                <x-form.input required="true" type="email" name="email" label="Электронная почта" placeholder="example@mail.ru" formFloating="true"></x-form.input>
                            </div>
                            <div class="col-12">
                                <x-form.input type="select" name="type" label="Тема обращения" id='type' formFloating="true">
                                    <option disabled>На какую тему ваш вопрос?</option>
                                    <option value="Брак">Иск о расторжении брака</option>
                                    <option value="Подсудность">Территориальная подсудность</option>
                                    <option value="Калькулятор">Калькулятор неустойки по ДДУ</option>
                                    <option value="ДДУ">Претензия по ДДУ к застройщику</option>
                                    <option value="Госпошлина">Узнать рекизиты госпошлины</option>
                                </x-form.input>
                            </div>    
                            <div class="col-12">
                                <x-form.input required="true" type="textarea" name="msg" label="Ваше сообщение" rows="8" placeholder="Задайте вопрос или внесите предложение" formFloating="true"></x-form.input>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 form-feedback__aside">
                        <div class="form__text-bg d-md-block d-none">
                            <p>Задайте вопрос или внесите свое предложение.</p>
                            <p>Наши специалисты вам обязательно ответят!</p>                            
                        </div>
                        <x-form.btn class="btn--black">Отправить</x-form.btn>
                        <p class="note-personal">*Нажимая на кнопку "Отправить", Вы соглашаетесь с <a target="_blank" class="" href="{{ route('license-agreement') }}" style="color: inherit; text-decoration: underline;">политикой сайта</a>. Мы не передаём третьим лицам ваши персональные данные. Они находятся под надёжной защитой</p>
                    </div>

                    
                </div>
            </x-form.form>
        </div>
    </div>
</section>

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
                        <ul class="social-list social-list--footer">
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