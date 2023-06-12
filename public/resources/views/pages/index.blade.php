@extends('layouts.base')

@section('title', 'Помощь в создании документов')

@section('content')

<div class="header-decor header-decor--front"></div>

<div class="page-intro">
    <div class="container">
        <div class="page-intro__content">
            <h1>Иски и претензии — онлайн</h1>
            <div class="page-intro__text">
                Автоматическая подготовка претензий, исков и других документов в суд, а также множество других сервисов для помощи в юриспруденции
            </div>
        </div>
    </div>
</div>
           
<section class="features i-s-k">
    <div class="container">
        <ul class="features__list row">
            <li class="features__item col-lg-3 col-6">
                <div class="features__item-content">
                    <svg><use xlink:href="/img/icons-1.svg#checked--blue"></use></svg>
                    Не&nbsp;более 15&nbsp;минут
                </div>
            </li>
            <li class="features__item col-lg-3 col-6">
                <div class="features__item-content">
                    <svg><use xlink:href="/img/icons-1.svg#checked--blue"></use></svg>
                    Без&nbsp;переплат юристам
                </div>
            </li>
            <li class="features__item col-lg-3 col-6">
                <div class="features__item-content">
                    <svg><use xlink:href="/img/icons-1.svg#checked--blue"></use></svg>
                    Документы проверены
                </div>
            </li>
            <li class="features__item col-lg-3 col-6">
                <div class="features__item-content">
                    <svg><use xlink:href="/img/icons-1.svg#checked--blue"></use></svg>
                    Не выходя из&nbsp;дома
                </div>
            </li>
        </ul>
    </div>
</section>

<section class="services i-s-k" id="services">
    <div class="container">
        <x-service.services-list></x-service.services-list>
    </div>
</section>

<section class="how-works i-s-k">
    <div class="container">
        <h2>Как мы работаем</h2>
        <ol class="how-works__list row">
            <li class="how-works__item col-md-4">
                <div class="how-works__item-content">
                    <span class="how-works__counter">1,</span>
                    Заполните форму и&nbsp;сервис сформирует документ
                </div>
            </li>
            <li class="how-works__item col-md-4">
                <div class="how-works__item-content">
                    <span class="how-works__counter">2,</span>
                    Скачайте сформированный документ
                </div>
            </li>
            <li class="how-works__item col-md-4">
                <div class="how-works__item-content">
                    <span class="how-works__counter">3.</span>
                    Отправьте <br>готовый документ адресату
                </div>
            </li>
        </ol>
    </div>
</section>

<section class="about i-s-k">
    <div class="container">
      <h2>О сервисе</h2>
      <div class="about__content row">
        <svg class="about__cite" width="103" height="74" viewBox="0 0 103 74" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M58.4896 74C56.2264 74 54.5918 73.2332 53.5859 71.6995C52.58 70.1658 52.2028 68.2487 52.4543 65.9482L60.7529 11.1192C61.2558 8.05182 62.2617 5.49568 63.7705 3.45078C65.5308 1.15026 68.1713 0 71.6918 0H96.5875C98.5993 0 100.108 0.766838 101.114 2.30051C102.371 3.57858 103 4.98445 103 6.51814C103 8.56303 102.497 10.6079 101.491 12.6528L81.8764 65.1814C80.8705 67.7375 79.4874 69.9102 77.7271 71.6995C76.2183 73.2332 73.8294 74 70.5602 74H58.4896ZM6.11075 74C4.09898 74 2.46442 73.2332 1.20706 71.6995C0.201177 70.1658 -0.17603 68.2487 0.0754415 65.9482L8.75119 11.1192C9.25414 8.05182 10.26 5.49568 11.7688 3.45078C13.5291 1.15026 16.0439 0 19.313 0H44.5858C46.3461 0 47.7292 0.766838 48.7351 2.30051C49.9925 3.57858 50.6211 4.98445 50.6211 6.51814C50.6211 8.56303 50.1182 10.6079 49.1123 12.6528L29.4976 65.1814C28.4917 67.7375 27.1086 69.9102 25.3483 71.6995C23.8395 73.2332 21.4505 74 18.1814 74H6.11075Z" fill="#E4F2FD"/></svg>          
        <div class="about__author col-lg-3 col-md-4 offset-lg-1">
          <div class="about__author-content">
            <img src="img/fedor-kremenshukov.jpg" alt="" class="about__author-photo">
            <div class="about__author-name">Федор Кременьщуков</div>
            <div class="about__author-role">Старший юрист</div>
            <div class="about__author-experience">Опыт 17 лет</div>          
          </div>
        </div>
        <div class="about__text col-lg-7 col-md-8">
          <p>Я юрист более чем с 17-летним стажем. По первому образованию я программист, второе — юридическое образование я получил по зову сердца. <b>Мне действительно нравится помогать гражданам в их сложных жизненных ситуациях.</b> За годы работы я осознал, что люди тратят колоссальные деньги и безумное количество времени на правовые вопросы, которые можно систематизировать, подчинить логике и алгоритмам, исключить фактор человеческой ошибки.</p>
          <p>Вам больше не нужно тратить своё время на запись к адвокату или юристу, рассказывать человеку о своих проблемах, сомневаться, будет ли юридическая помощь оказана качественно и в срок.</p>
          <p><b>Теперь, <span style="color: var(--color-theme);">за 5 минут</span>, заполнив необходимые поля, вы получите юридически выверенный документ, созданный по алгоритму, разработанному при поддержке лучших в своей сфере юристов.</b></p>
          <p>В нашем сервисе собраны самые актуальные правовые сервисы и калькуляторы, вы сможете за секунды определить подсудность в любом регионе, узнать реквизиты для оплаты госпошлины, никогда ещё подготовка и направление претензий и исков не были так доступны для далёкого от юриспруденции человека.</p>
          <p><b>Наша команда искренне верит, что качественная и быстрая правовая помощь должна быть доступна для каждого человека!</b> С уважением, директор сервиса Иск.онлайн, ваш Кременьщуков Федор</p>
        </div>
        <div class="about__bottom col-lg-3 col-md-4 col-12 offset-lg-1">
          <a href="{{ route('about') }}" class="about__more btn btn--white">Узнать больше</a>
        </div>
      </div>
    </div>
  </section>

<section class="blog i-s-k">
    <div class="container">
        <h2>Блог</h2>
        <!--a href="#" class="blog__more btn">Все статьи</a-->
        <x-blog.blog-list></x-blog.blog-list>
    </div>
</section>

@endSection