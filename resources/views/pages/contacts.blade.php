@extends('layouts.base')

@section('title', 'Контакты')

@section('content')

<div class="header-decor header-decor--contacts"></div>

<section class="contacts-main">
    <div class="container">
        <div class="contacts-main__content">
            <h1>Контакты</h1>
            <div class="row">
                <div class="contact__main col-xl-7 col-md-6">
                    <small>Электронная почта</small>
                    <a href="mailto:podat-v-sud@yandex.ru" class="contacts__email">podat-v-sud@yandex.ru</a>
                    <small>Адрес</small>
                    <div class="contacts__address">г. Москва, проезд Лубянский, д. 15, стр. 2, пом. 1</div>
                    <ul class="social-list social-list--contacts">
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
                <div class="contacts__org col-md-5">
                    <div class="contacts__org-title">Адвокатское бюро г. Москвы "Москоу лигал"</div>
                    {{-- <div class=""> --}}
                        <div class="contacts__org-left">
                            <span class="contacts__org-item">ИНН: 7709481378</span>
                            <span class="contacts__org-item">КПП: 770901001</span>
                            <span class="contacts__org-item">ОГРН: 1157700020950</span>
                        </div>
                        <div class="contacts__org-right">
                            <span class="contacts__org-item">р/с: 40703810201100000088</span>
                            <span class="contacts__org-item">к/с: 30101810200000000593</span>
                            <span class="contacts__org-item">БИК: 044525593 (АО «АЛЬФА-БАНК»)</span>
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</section>

<section class="map__wrapper" id="map">
    <div class="container">
        <div class="map">
            <iframe class='' src="https://yandex.ru/map-widget/v1/?um=constructor%3Af35328018ca42472146d536fe09d06290b9c91f7796454ba040313473b4b3ce3&amp;source=constructor" width="100%" height="410" frameborder="0"></iframe>
        </div>
    </div>
</section>

<section class="contacts-docs">
    <div class="container">
        <h2 class="contacts-docs__title">Документы</h2>
        <div class="shadow-top">
            <div class="contacts-docs__list">
                <div class="contacts-docs__item-wrapper">
                <div class="contacts-docs__item">
                    <img href="{{ asset('/images/doc1-full.jpg') }}" role="button" data-fancybox="documents" data-caption="Свидетельство о государственной регистрации некоммерческой организации" class='w-100 shadow' src="{{ asset('/images/doc1-full.jpg') }}" alt="Свидетельство о государственной регистрации некоммерческой организации" title="Свидетельство о государственной регистрации некоммерческой организации">
                    <p>Свидетельство о государственной регистрации некоммерческой организации</p>
                </div>
                </div>
                <div class="contacts-docs__item-wrapper">
                <div class="contacts-docs__item">
                    <img href="{{ asset('/images/doc2-full.jpg') }}" role="button" data-fancybox="documents" data-caption="Свидетельство о государственной регистрации юридического лица" class='w-100 shadow' src="{{ asset('/images/doc2-full.jpg') }}" alt="Свидетельство о государственной регистрации юридического лица" title="Свидетельство о государственной регистрации юридического лица">
                    <p>Свидетельство о государственной регистрации юридического лица</p>
                </div>
                </div>
                <div class="contacts-docs__item-wrapper">
                <div class="contacts-docs__item">
                    <img href="{{ asset('/images/doc3-full.jpg') }}" role="button" data-fancybox="documents" data-caption="Свидетельство о постановке на налоговый учет" class='w-100 shadow' src="{{ asset('/images/doc3-full.jpg') }}" alt="Свидетельство о постановке на налоговый учет" title="Свидетельство о постановке на налоговый учет">
                    <p>Свидетельство о постановке на налоговый учет</p>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="https://www.google.com/recaptcha/enterprise.js?render=6Leuc3oiAAAAADzJEqSuj_brWvUDzoxAF0fa6W-H"></script>
<script>
    grecaptcha.enterprise.ready(function() {
        grecaptcha.enterprise.execute('6Leuc3oiAAAAADzJEqSuj_brWvUDzoxAF0fa6W-H', {
            action: 'login'
        }).then(function(token) {
            document.getElementById("captcha_token").value = token;
        });
    });
</script>
@endSection