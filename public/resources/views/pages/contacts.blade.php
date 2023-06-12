@extends('layouts.base')

@section('title', 'Контакты')

@section('content')

<x-layout.section bg=''>
    <x-layout.container>
        <h2>Контакты</h2>
        <br>
        <div class="block bg-white">
            <div class="row mb-3">
                <div class="col-12 col-md-7 mt-3">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-location-dot text-primary"></i>
                        <p class="ms-3">г. Москва, проезд Лубянский, д. 15, стр. 2, пом. I </p>
                        <!-- <br> <small class="text-primary">метро Алексеевская</small> -->
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <i class="fa-solid fa-envelope text-primary"></i>
                        <p class="ms-3"><a href="mailto:podat-v-sud@yandex.ru">podat-v-sud@yandex.ru</a><br></p>
                    </div>

                </div>
                <div class="col-12 col-md-5 mt-3">
                    <div class="">
                        Адвокатское бюро г. Москвы "Москоу лигал"<br>
                        ИНН: 7709481378<br>
                        КПП: 770901001 <br>
                        ОГРН: 1157700020950<br>
                        р/с: 40703810201100000088<br>
                        к/с: 30101810200000000593<br>
                        БИК: 044525593 <br>
                        Банк: АО «АЛЬФА-БАНК»<br>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <iframe class='mt-4 block p-0' src="https://yandex.ru/map-widget/v1/?um=constructor%3Af35328018ca42472146d536fe09d06290b9c91f7796454ba040313473b4b3ce3&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
        </div>
        <h3 class="mt-5">Документы</h3>
        <br>
        <x-layout.row>
            <div class='col-12 col-md-4 mt-2'>
                <img href="{{ asset('/images/doc1-full.jpg') }}" role="button" data-fancybox="documents" data-caption="Свидетельство о государственной регистрации некоммерческой организации" class='w-100 shadow' src="{{ asset('/images/doc1-full.jpg') }}" alt="Свидетельство о государственной регистрации некоммерческой организации" title="Свидетельство о государственной регистрации некоммерческой организации">
            </div>
            <div class='col-12 col-md-4 mt-2'>
                <img href="{{ asset('/images/doc2-full.jpg') }}" role="button" data-fancybox="documents" data-caption="Свидетельство о государственной регистрации юридического лица" class='w-100 shadow' src="{{ asset('/images/doc2-full.jpg') }}" alt="Свидетельство о государственной регистрации юридического лица" title="Свидетельство о государственной регистрации юридического лица">
            </div>
            <div class='col-12 col-md-4 mt-2'>
                <img href="{{ asset('/images/doc3-full.jpg') }}" role="button" data-fancybox="documents" data-caption="Свидетельство о постановке на налоговый учет" class='w-100 shadow' src="{{ asset('/images/doc3-full.jpg') }}" alt="Свидетельство о постановке на налоговый учет" title="Свидетельство о постановке на налоговый учет">
            </div>
        </x-layout.row>
        <br>
        <h3 class="mt-5">Напишите нам</h3>
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
    </x-layout.container>
</x-layout.section>


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