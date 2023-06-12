@extends('layouts.base')

@section('content')
<x-layout.section>
    <x-layout.container>
        <x-menu.breadcrumb>
            <x-menu.breadcrumb-item link="{{ route('home') }}">Главная</x-menu.breadcrumb-item>
            <x-menu.breadcrumb-item link="{{ route('categories') }}">Категории документов</x-menu.breadcrumb-item>
            <x-menu.breadcrumb-item link="{{ route('category') }}">Гражданское право</x-menu.breadcrumb-item>
        </x-menu.breadcrumb>
        <h1>Гражданское право</h1>
        <p>Документы, связанные с гражданским правом</p>
        <x-layout.row>
            <x-layout.column4>
                <x-card.card>
                    <x-card.card-header><a class="text-decoration-none">Гражданское право</a></x-card.card-header>
                    <x-card.card-body>
                        <h5 class="card-title">Претензия по защите прав потребителей</h5>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint fuga earum asperiores magnam debitis nobis cupiditate enim voluptas, nisi provident!</p>
                        <div class="d-flex gap-1 mt-3">
                            <a href="{{ route('calculator') }}" class="btn btn-outline-primary">Составить документ<i class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </x-card.card-body>
                </x-card.card>
            </x-layout.column4>
            <x-layout.column4>
                <x-card.card>
                    <x-card.card-header><a class="text-decoration-none">Гражданское право</a></x-card.card-header>
                    <x-card.card-body>
                        <h5 class="card-title">Претензия по защите прав потребителей</h5>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint fuga earum asperiores magnam debitis nobis cupiditate enim voluptas, nisi provident!</p>
                        <div class="d-flex gap-1 mt-3">
                            <a href="" class="btn btn-outline-primary">Составить документ<i class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </x-card.card-body>
                </x-card.card>
            </x-layout.column4>
            <x-layout.column4>
                <x-card.card>
                    <x-card.card-header><a class="text-decoration-none">Гражданское право</a></x-card.card-header>
                    <x-card.card-body>
                        <h5 class="card-title">Претензия по защите прав потребителей</h5>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint fuga earum asperiores magnam debitis nobis cupiditate enim voluptas, nisi provident!</p>
                        <div class="d-flex gap-1 mt-3">
                            <a href="" class="btn btn-outline-primary">Составить документ<i class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </x-card.card-body>
                </x-card.card>
            </x-layout.column4>
            <x-layout.column4>
                <x-card.card>
                    <x-card.card-header><a class="text-decoration-none">Гражданское право</a></x-card.card-header>
                    <x-card.card-body>
                        <h5 class="card-title">Претензия по защите прав потребителей</h5>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint fuga earum asperiores magnam debitis nobis cupiditate enim voluptas, nisi provident!</p>
                        <div class="d-flex gap-1 mt-3">
                            <a href="" class="btn btn-outline-primary">Составить документ<i class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </x-card.card-body>
                </x-card.card>
            </x-layout.column4>
            <x-layout.column4>
                <x-card.card>
                    <x-card.card-header><a class="text-decoration-none">Гражданское право</a></x-card.card-header>
                    <x-card.card-body>
                        <h5 class="card-title">Претензия по защите прав потребителей</h5>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint fuga earum asperiores magnam debitis nobis cupiditate enim voluptas, nisi provident!</p>
                        <div class="d-flex gap-1 mt-3">
                            <a href="" class="btn btn-outline-primary">Составить документ<i class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </x-card.card-body>
                </x-card.card>
            </x-layout.column4>
            <x-layout.column4>
                <x-card.card>
                    <x-card.card-header><a class="text-decoration-none">Гражданское право</a></x-card.card-header>
                    <x-card.card-body>
                        <h5 class="card-title">Претензия по защите прав потребителей</h5>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Sint fuga earum asperiores magnam debitis nobis cupiditate enim voluptas, nisi provident!</p>
                        <div class="d-flex gap-1 mt-3">
                            <a href="" class="btn btn-outline-primary">Составить документ<i class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </x-card.card-body>
                </x-card.card>
            </x-layout.column4>
        </x-layout.row>
    </x-layout.container>
</x-layout.section>
@endSection