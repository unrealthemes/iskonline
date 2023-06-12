@extends('layouts.base')

@section('title', 'Подготовка документа')

@section('content')

<x-layout.section bg=''>
    <x-layout.container>
        <h1 id="title" class="text-center">Идёт подготовка Вашего документа...</h1>
        <div class="progress mt-5" style="height: 40px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
        </div>
        <div class="mt-5 d-none" id="banner">
            <div class="row">
                <div class="col-12 col-md-2"></div>
                <div class="col-12 col-md-8">
                    <div style="position: relative;">
                        <img class="img img-fluid shadow rounded" src="{{ $img }}" alt="Image">
                        <div class="banner-inner rounded" style="display: grid; place-items: center; position: absolute; bottom: 0px; left: 0px; width: 100%; height: calc(100% / 3 * 2); background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                            <h3 class="">Доступно после оплаты</h3>
                        </div>
                    </div>

                </div>
            </div>
            <div class="text-center mt-4">
                <h2>
                    Получите готовый документ всего за 499 руб!<br>
                </h2>
                <span class="text-muted">В юридической компании это будет стоять ~10 000 руб.</span>
                <br>
                <br>
                <x-form.btn link="{{ route('applications.payment', ['application' => $application->id, 'service' => $service->id]) }}" class="btn-lg">Оплатить</x-form.btn>

            </div>
        </div>
        <script>
            const $ = (el, item = document) => item.querySelector(el);
            const $$ = (el, item = document) => item.querySelectorAll(el);

            let time = 0;

            const addPerc = () => {
                time += Math.trunc(Math.random() * 2);
                time = Math.min(time, 100);

                $('.progress-bar').style.width = `${time}%`;
                $('.progress-bar').innerText = `${time}%`;

                if (time < 100) {
                    setTimeout(addPerc, Math.trunc(Math.trunc() * 5000));
                } else {
                    setTimeout(() => {
                        $('.progress-bar').classList.add('bg-success');
                        $('.progress-bar').innerHTML = "Готово!";
                        setTimeout(() => {
                            $('.progress').classList.add('d-none');
                            showImage();
                        }, 1000);
                    }, 300);

                }
            }

            const showImage = () => {
                $('#banner').classList.remove('d-none');
                $("#title").innerText = "Ваш документ готов!";
            }

            addPerc();
        </script>
    </x-layout.container>
</x-layout.section>

@endSection