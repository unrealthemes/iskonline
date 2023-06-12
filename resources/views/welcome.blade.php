<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://me.lifegame.su/docsgen/css/app.css" rel="stylesheet">
    <script src="https://me.lifegame.su/docsgen/js/app.js" defer=""></script>

    <!-- <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style> -->
</head>

<body>
    <header class="">
        <div class="bg-light border-bottom">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="https://me.lifegame.su/docsgen">Главная</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="#">Home 2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="#">Home 3</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid py-2">
                    <div class="navbar-brand bg-primary text-light p-2 rounded d-flex align-items-center">
                        <img style="width: 60px" src="https://me.lifegame.su/docsgen/images/logo.png" alt="Logo">
                        <div class="ms-3">
                            <div class="logo-title">
                                Moscow<br>legal
                            </div>
                            <div class="logo-description">
                                Адвокатское бюро
                            </div>
                        </div>
                    </div>
                    <div class="w-100">
                        Автоматизированный <br> программный комплекс
                    </div>
                    <div class="text-nowrap me-3">
                        <i class="bi bi-geo-alt-fill"></i>Работаем по всей России
                    </div>
                    <ul class="navbar-nav d-flex">
                        <a class="btn btn-outline-primary " href="https://me.lifegame.su/docsgen/%D0%B2%D1%85%D0%BE%D0%B4">Войти</a>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <section class="bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="mt-3 col-7">
                    <h1 class="display-5 fw-bold">Вы всё сделаете сами<br>– без юриста</h1>
                    <p class="fs-5 mt-3">Подготовите документы, заполните заявление, оплатите<br>госпошлину, отправите претензию и многое другое<br>доступно онлайн</p>
                    <div class="mt-5 d-flex justify-content-between align-items-start">
                        <button class="btn btn-primary btn-lg" role="submit">Оформить заявку</button>
                        <div class="me-5">
                            <span>Цифра дня:</span>
                            <div class="fs-1 fw-bold">60 000</div>
                            <span class="text-small text-muted">Пользователей<br>зарегистрировано</span>
                        </div>
                    </div>
                </div>
                <div class="mt-3 col-5">
                    <div class="bg-white p-5 rounded shadow ">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item" data-bs-interval="3000">
                                    <div class="text-center">
                                        <span class="p-2 fs-7 badge bg-primary text-primary" style="--bs-bg-opacity: .2;">Защита от коронавируса</span>
                                        <p class="fs-5">
                                            <i class="bi bi-people-fill" style="font-size: 7em;"></i><br>
                                            Соблюдайте дистанцию
                                        </p>
                                    </div>
                                </div>
                                <div class="carousel-item active" data-bs-interval="3000">
                                    <div class="text-center">
                                        <span class="p-2 fs-7 badge bg-primary text-primary" style="--bs-bg-opacity: .2;">Защита от коронавируса</span>
                                        <p class="fs-5">
                                            <i class="bi bi-people-fill" style="font-size: 7em;"></i><br>
                                            Носите маски
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class=" py-5">
        <div class="container">
            <h2 class="text-center">Рекомендуемые сервисы</h2>
            <br>
            <div class="row">
                <div class="mt-3 col-4">
                    <div class="card shadow">
                        <div class="card-header p-4 bg-primary ">
                            <h2 class="text-white font-weight-bold h5">Претензия к застройщику</h2>
                        </div>
                        <div class="card-body p-4">
                            <p>Описание претензии к застройщику</p>
                        </div>
                        <div class="card-footer p-4 pt-0 bg-white border-top border-white">
                            <a class="btn btn-outline-primary " href="https://me.lifegame.su/docsgen/%D0%BF%D1%80%D0%B5%D1%82%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F-%D0%BA-%D0%B7%D0%B0%D1%81%D1%82%D1%80%D0%BE%D0%B9%D1%89%D0%B8%D0%BA%D1%83"><strong>Оформить заявку</strong></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center">Как подать заявку</h2>
            <br>
            <div class="row">
                <div class="mt-3 col-4">
                    <div class="bg-white p-4 border rounded-3 shadow">
                        <div class="text-center">
                            <i style="font-size: 6em;" class="text-primary bi bi-file-earmark-text"></i>
                            <p>Заполните формы и сервис<br>сформирует документ</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3 col-4">
                    <div class="bg-white p-4 border rounded-3 shadow">
                        <div class="text-center">
                            <i style="font-size: 6em;" class="text-primary bi bi-download"></i>
                            <p>Скачайте сформированный<br>документ онлайн</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3 col-4">
                    <div class="bg-white p-4 border rounded-3 shadow">
                        <div class="text-center">
                            <i style="font-size: 6em;" class="text-primary bi bi-envelope-check"></i>
                            <p>Отправьте готовый документ<br> адресату</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class=" py-5">
        <div class="container">
            <h2 class="text-center">Наши преимущества</h2>
            <br>
            <div class="row">
                <div class="mt-3 col-6">
                    <div class="bg-white p-4 border rounded-3 shadow">
                        <div class="d-flex align-items-center">
                            <i style="font-size: 5em" class="text-primary bi bi-file-earmark-check-fill"></i>
                            <p class="ms-5 fs-5">Проверенная претензия</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3 col-6">
                    <div class="bg-white p-4 border rounded-3 shadow">
                        <div class="d-flex align-items-center">
                            <i style="font-size: 5em" class="text-primary bi bi-person-x-fill"></i>
                            <p class="ms-5 fs-5">Не нужно обращаться<br>и переплачивать юристам</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3 col-6">
                    <div class="bg-white p-4 border rounded-3 shadow">
                        <div class="d-flex align-items-center">
                            <i style="font-size: 5em" class="text-primary bi bi-stopwatch-fill"></i>
                            <p class="ms-5 fs-5">Процедура займёт не более 15 минут</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3 col-6">
                    <div class="bg-white p-4 border rounded-3 shadow">
                        <div class="d-flex align-items-center">
                            <i style="font-size: 5em" class="text-primary bi bi-send-check-fill"></i>
                            <p class="ms-5 fs-5">Наличие возможности отправить документ онлайн без личного визита в магазин или на почту</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="navbar-fixed-bottom border-top">
        <div class="bg-light border-bottom">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="https://me.lifegame.su/docsgen">Главная</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="#">Home 2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " aria-current="page" href="#">Home 3</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </footer>


</body>

</html>