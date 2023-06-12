@extends('layouts.base')

@section('meta')
    @foreach (explode(';', $service->meta) as $meta)
        <meta name="{{ explode('=', $meta)[0] }}" content="{{ explode('=', $meta)[1] }}">
    @endForeach
@endSection

@section('title', $service->title)

@section('content')

    <section class='hero gradient-1'>
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <h1>
                        {{ $service->h1 }}
                    </h1>
                    <p class='hero-text'>
                        {{ $service->description }}
                    </p>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="hero-icon">
                        <i class="{{ $service->image }}"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-layout.section bg='{{ $bg }}'>
        <x-layout.container>
            <span class="d-block fs-4 fw-bold mb-3" id="service">Заполните форму</span>
            <form action="#" id='sarchdoveer'>
                <x-form.input form-floating="true" name="reesterNum" value=" " type="text" label="Реестровый номер"
                    required="true"></x-form.input>
                <x-form.input form-floating="true" name="date" value=" " type="date" label="Дата удостоверения"
                    required="true"></x-form.input>
                <x-form.input type="select" name="type" label="Кто удостоверил" form-floating="true" id='type'>
                    <option value="not">Нотариус</option>
                    <option value="RKU">Работник консульского учреждения</option>
                    <option value="DLOMS">Должностное лицо органа местного самоуправления</option>
                </x-form.input>
                <div id="special-inputs">
                    <div id="inputs-not">
                        <x-form.input form-floating="true" name="notName" value=" " type="text"
                            label="ФИО нотариуса миниму 5 символов" required="true">
                        </x-form.input>
                        <div id="not-list">

                        </div>
                    </div>
                    <div id="inputs-consul" style='display:none;'>
                        <x-form.input form-floating="true" name="konsulName" value=" " type="text"
                            label="ФИО работника" required="true">
                        </x-form.input>
                        <x-form.input type="select" name="country" label="Страна" form-floating="true">
                            @foreach ($countrys as $country)
                                <option value="{{ $country->name }}">{{ $country->name }}</option>
                            @endforeach
                        </x-form.input>
                    </div>
                    <div id="inputs-region" style='display:none;'>
                        <x-form.input form-floating="true" name="employeeName" value=" " type="text"
                            label="ФИО работника" required="true">
                        </x-form.input>
                        <x-form.input type="select" name="region" label="Страна" form-floating="true">
                            @foreach ($districts as $district)
                                <option value="{{ $district->name }}">{{ $district->name }}</option>
                            @endforeach
                        </x-form.input>
                    </div>
                </div>
                <div id='captchaform' style="display: none;">
                    <div class="mb-2">
                        <iframe src="https://xn--h1aeu.xn--80asehdb/storage/pars/capches/capch65.png" frameborder="0"
                            id='captchaimg'>

                        </iframe>
                    </div>
                    <input type="text" id='code' style='display: none;' name='code'>
                    <x-form.input form-floating="true" name="captcha" id='captcha' value=" " type="text"
                        label="Капча" required="true">
                    </x-form.input>
                    <button class="btn btn-primary mt-1" id="captchabtn" type='button'>Отправить</button>
                </div>
                <button class="btn btn-primary mt-1" id="searchbtn" type='button'>Найти</button>
            </form>
            <span class="fs-4 fw-bold " id="error"></span>
            <span class="fs-4 fw-bold " id="result"></span>
            </div>
        </x-layout.container>
    </x-layout.section>
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
        ///////////////////////////////Поиск по нотариусам////////////////////////////////////////
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
        //Поиск нотариуса
        document.getElementsByName('notName')[0].oninput = () => {
            let notName = document.getElementsByName('notName')[0];
            // if (notName.length > 2) {
            if (notName.value.length = 5 && notName.value.length > 7) {
                echoResult('Начинаю поиск нотариусов')
                console.log(notName.value, );
                searchNot(notName.value);
            }
        }
        //Отправка запроса на поиск нотариуса
        function searchNot(name) {
            let request = sendRequest('GET', "api/doveer/searchNot/" + name)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
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
    </style>
@endSection
