@extends('layouts.base')

@section('meta')
    @foreach (explode(';', $service->meta) as $meta)
        <meta name="{{ explode('=', $meta)[0] }}" content="{{ explode('=', $meta)[1] }}">
    @endForeach
@endSection

@section('title', $service->title)

@section('content')

    <div class="header-decor header-decor--{{ $service->id }}"></div>

    <section class='hero'>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h1>
                        {{-- {{ $service->h1 }} --}}
                        Проверка доверенности
                    </h1>
                    <p class='hero-text'>{{ $service->description }}</p>
                </div>
            </div>
        </div>
        <div class="header-decor-mob header-decor-mob--{{ $service->id }} d-block d-lg-none"></div>
    </section>

    <section class="section-service-form" id="service">
        <div class="container">
            {{-- <span class="d-block fs-4 fw-bold mb-3" id="service">Заполните форму</span> --}}
            <div class="form-blue">
                <h2>Проверка доверенности</h2>
                <form action="#" id='sarchdoveer'>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-12">
                                    <x-form.input name="reesterNum" value=" " type="text" label="Реестровый номер" required="true" formFloating="true"></x-form.input>
                                </div>
                                <div class="col-md-6">
                                    <x-form.input type="select" name="type" label="Кто удостоверил" id='type' formFloating="true">
                                        <option value="not">Нотариус</option>
                                        <option value="RKU">Работник консульского учреждения</option>
                                        <option value="DLOMS">Должностное лицо органа местного самоуправления</option>
                                    </x-form.input>
                                </div>
                                <div class="col-md-6">
                                    <x-form.input name="date" value=" " type="date" label="Дата удостоверения" required="true" formFloating="true"></x-form.input>
                                </div>
                            </div>
                            <div id="special-inputs">
                                <div id="inputs-not">
                                    <x-form.input name="notName" value=" " type="text" label="ФИО нотариуса миниму 4 символов" required="true" formFloating="true"></x-form.input>
                                    <div id="not-list"></div>
                                </div>
                                <div id="inputs-consul" style='display:none;'>
                                    <x-form.input name="konsulName" value=" " type="text" label="ФИО работника" required="true" formFloating="true"></x-form.input>
                                    <x-form.input type="select" name="country" label="Страна"></x-form.input>
                                </div>
                                <div id="inputs-region" style='display:none;'>
                                    <x-form.input name="employeeName" value=" " type="text" label="ФИО работника" required="true" formFloating="true">
                                    </x-form.input>
                                    <x-form.input type="select" name="region" label="Регион" formFloating="true"></x-form.input>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div id='captchaform' style="display: none;">
                                <div class="mb-2">
                                    <iframe src="https://xn--h1aeu.xn--80asehdb/storage/pars/capches/capch65.png" frameborder="0" id='captchaimg'></iframe>
                                </div>
                                <input type="text" id='code' style='display: none;' name='code'>
                                <x-form.input name="captcha" id='captcha' value=" " type="text" label="Капча" required="true"></x-form.input>
                                <button class="btn btn--black mt-1" id="captchabtn" type='button'>Отправить</button>
                            </div>
                            <div class="form-service__privacy-text">Нажимая на кнопку «Найти», Вы соглашаетесь с политикой сайта. Мы не передаём третьим лицам ваши персональные данные. Они находятся под надёжной защитой</div>
                            <button class="btn btn--black mt-1" id="searchbtn" type='button'>Найти</button>
                        </div>
                    </div>
                </form>
                <span class="fs-4 fw-bold " id="error"></span>
                <span class="fs-4 fw-bold " id="result"></span>
            </div>
        </div>
    </section>
    <section class="about-list" id="service">
        <div class="container">
            <h2>О сервисе</h2>
            <div class="block bg-white mt-4">
                <div class="row">
                    <div class="col-12">
                        {!! $service->text !!}
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <script>
        let searchBtn = document.querySelector('#searchbtn');
        let captchaForm = document.querySelector('#captchaform');
        let code = document.querySelector('#code');
        let captcha = document.querySelector('#captcha');

        document.querySelector('#type').addEventListener('change', function() {
            let type = document.querySelector('#type').value;
            console.log(type);
            let consulBlock = document.querySelector('#inputs-consul');
            let regionBlock = document.querySelector('#inputs-region');
            let notBlock = document.querySelector('#inputs-not');
            if (type == 'not') {
                notBlock.style.display = 'block';
                consulBlock.style.display = 'none';
                regionBlock.style.display = 'none';
                return true;
            }
            if (type == 'RKU') {
                consulBlock.style.display = 'block';
                regionBlock.style.display = 'none';
                notBlock.style.display = 'none';
                return true;
            }
            if (type == 'DLOMS') {
                consulBlock.style.display = 'none';
                notBlock.style.display = 'none';
                regionBlock.style.display = 'block';
                return true;
            }
        })
        ///////////////////////////////Подгрузка стран////////////////////////////////////////
        function getCountry() {
            sendRequest('GET', "api/doveer/getCountry")
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    appendCountry(data);
                });
        }

        function appendCountry(countrys) {
            let countryList = document.querySelector('#country');
            for (let i = 0; i < countrys.length; i++) {
                let option = document.createElement('option');
                option.text = countrys[i].name;
                option.value = countrys[i].name;
                countryList.appendChild(option);
            }
        }
        getCountry();
        ///////////////////////////////Подгрузка стран////////////////////////////////////////
        ///////////////////////////////Подгрузка регионов////////////////////////////////////////
        function getDistrict() {
            sendRequest('GET', "api/doveer/getDistrict")
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    appendDistrict(data);
                });
        }
        function appendDistrict(districts) {
            let disctrictList = document.querySelector('#region');
            for (let i = 0; i < districts.length; i++) {
                let option = document.createElement('option');
                option.text = districts[i].name;
                option.value = districts[i].name;
                disctrictList.appendChild(option);
            }
        }
        getDistrict();
        ///////////////////////////////Подгрузка регионов////////////////////////////////////////
        //Функция для AJAX
        function sendRequest(method, url, data) {
            return fetch(url, {
                method: method,
                body: data
            })
        }
        //Вывод ошибки
        function echoError(error) {
            let errorBlock = document.querySelector('#error');
            errorBlock.innerText = ' ';
            errorBlock.innerText = error;
            setTimeout(function() {
                errorBlock.innerText = ' ';
            }, 4000)
            echoResult("");
        }

        function echoResult(result) {
            let resultBlock = document.querySelector('#result');
            resultBlock.innerText = ' ';
            resultBlock.innerText = result;
        }

        function clearCaptchaForm() {
            code.value = " ";
            captcha.value = " ";
        }
        ///////////////////////////////Функции работы с капчей////////////////////////////////////////
        //Вывод капчи
        function AppendCaptcha(data) {
            let img = document.querySelector('#captchaimg');
            img.src = data['result']['captcha'];
            setTimeout(function() {
                img.contentWindow.location.reload(true)
                captchaForm.style.display = 'block';
            }, 1000)
            code.value = data['result']['code'];
        }
        document.querySelector('#captchabtn').onclick = () => {
            echoResult('Ожидайте...')
            captchaForm.style.display = 'none';
            searchBtn.style.display = 'block';
            let data = new FormData();
            data.append('captcha', captcha.value);
            data.append('code', code.value);
            let request = sendRequest('POST', "api/doveer/result", data)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    clearCaptchaForm();
                    if (data['result']['error'] != undefined) {
                        echoResult(data['result']['error']);
                        return false;
                    }
                    echoResult(data['result']);
                });
        }
        ///////////////////////////////Функции работы с капчей////////////////////////////////////////
        //функция запускающия поиск
        searchBtn.onclick = () => {
            echoResult('Подгружаю капчу...')
            let forma = document.querySelector('#sarchdoveer');
            let data = new FormData(forma);
            let request = sendRequest('POST', "api/doveer/captcha", data)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    if (data['result']['error'] == undefined) {
                        searchBtn.style.display = 'none';
                        AppendCaptcha(data);
                        echoResult('Введите капчу')
                    } else {
                        echoError(data['result']['error']);
                    }
                });

        }
        ///////////////////////////////Поиск по нотариусам////////////////////////////////////////
        //Поиск нотариуса
        document.getElementsByName('notName')[0].oninput = () => {
            let notName = document.getElementsByName('notName')[0];
            let notList = document.querySelector('#not-list');
                notList.style.display = 'none'
                notList.innerHTML = " ";
            if (notName.value.length > 4) {
                echoResult('Начинаю поиск нотариусов')
                searchNot(notName.value);
            } else {
                let notList = document.querySelector('#not-list');
                notList.style.display = 'none'
                notList.innerHTML = " ";
            }
        }
        //Отправка запроса на поиск нотариуса
        function searchNot(name) {
            let request = sendRequest('GET', "api/doveer/searchNot/" + name)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    let notList = document.querySelector('#not-list');
                    notList.style.display = 'none'
                    notList.innerHTML = " ";
                    AppendNot(data);
                });
        }
        //Вывод нотариусов
        function AppendNot(data) {
            let notList = document.querySelector('#not-list');
            notList.style.display = 'block';
            notList.innerHTML = " ";
            for (key in data) {
                let name = data[key][0]['fullName'];
                notList.appendChild(getNotBlock(name));
            }
            echoResult(' ')
        }
        //Блок для
        function getNotBlock(name) {
            let row = document.createElement('div');
            row.setAttribute('class', 'row');
            let col = document.createElement('div')
            row.setAttribute('class', 'col-12 bg-white"');
            let span = document.createElement('span');
            span.setAttribute('class', 'm-5')
            span.innerText = name;
            row.appendChild(col);
            col.appendChild(span);
            row.onclick = () => {
                let input = document.getElementsByName('notName')[0];
                input.value = row.innerText;
                let notList = document.querySelector('#not-list');
                notList.style.display = 'none';
                return false;
            }
            return row;
        }
        ///////////////////////////////Поиск по нотариусам////////////////////////////////////////
    </script>
    <style>
        #not-list {
            overflow-y: scroll;
            overflow-x: hidden;
            margin-top: -10px;
            border: 1px solid #adb5bd;
            border-radius: 10px;
            display: none;
            max-height: 200px;
        }

        #captchaimg {
            width: 340px;
            height: 100px;
        }

        /* для Chrome/Edge/Safari */
        *::-webkit-scrollbar {
            height: 0px;
            width: 0px;
        }

        *::-webkit-scrollbar-track {
            background: var(#039ddf);
        }

        *::-webkit-scrollbar-thumb {
            background-color: var(white);
            border-radius: 5px;
            border: 3px solid var(white);
        }
    </style>
@endSection
