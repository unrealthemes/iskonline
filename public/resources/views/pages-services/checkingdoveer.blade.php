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
                            label="ФИО нотариуса минимум 4 символов" required="true">
                        </x-form.input>
                        <div id="not-list">

                        </div>
                    </div>
                    <div id="inputs-consul" style='display:none;'>
                        <x-form.input form-floating="true" name="konsulName" value=" " type="text"
                            label="ФИО работника" required="true">
                        </x-form.input>
                        <x-form.input type="select" name="country" label="Страна" form-floating="true">

                        </x-form.input>
                    </div>
                    <div id="inputs-region" style='display:none;'>
                        <x-form.input form-floating="true" name="employeeName" value=" " type="text"
                            label="ФИО работника" required="true">
                        </x-form.input>
                        <x-form.input type="select" name="region" label="Регион" form-floating="true">

                        </x-form.input>
                    </div>
                </div>
                <div id='captchaform' style="display: none;">
                    <div class="mb-2 form-floating">
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
    <section class="pt-2">
        <div class="container">
            <span class="fs-4 fw-bold " id="service">О сервисе</span>
            <div class="block bg-white mt-4 about">
                <div class="row">
                    <div class="col-12">
                        {!! $service->text !!}
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

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
    <script>
        checkDoveer();
    </script>
@endSection
