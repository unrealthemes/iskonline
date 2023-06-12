@extends('layouts.admin.base-admin-page')

@section('title', 'Добавление сервиса')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.services.index") }}'>Сервисы</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.services.create") }}'>Создание</x-menu.breadcrumb-item>
@endSection

@section('section-content')
<x-layout.row>
    <div class="col-6">
        <div class="block bg-white">
            <x-form.form action="{{ route('admin.services.store') }}" method="POST">
                <x-tabs.tabs>
                    <x-tabs.tabs-button tab-id="main" content-id="mainContent" active="true">Главное</x-tabs.tabs-button>
                    <x-tabs.tabs-button tab-id="meta" content-id="metaContent">СЕО</x-tabs.tabs-button>
                    <x-tabs.tabs-button tab-id="additional" content-id="additionalContent">Дополнительно</x-tabs.tabs-button>
                    <!-- <x-tabs.tabs-button tab-id="handle" content-id="handleContent">Обработка</x-tabs.tabs-button> -->
                </x-tabs.tabs>
                <div class="mt-3 mb-3">
                    <x-tabs.tabs-content>
                        <x-tabs.tabs-pane tab-id="main" content-id="mainContent" active="true">
                            <h4>Главное</h4>
                            <div class="row mt-2">
                                <div class="col-6 mt-2">
                                    <x-form.input form-floating="true" name="name" label="Название"></x-form.input>
                                </div>
                                <div class="col-6 mt-2">
                                    <x-form.input type="select" form-floating="true" name="service_type_id" label="Тип сервиса">
                                        @foreach ($services_types as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                        @endForeach
                                    </x-form.input>
                                </div>
                                <div class="col-6 mt-2">
                                    <x-form.input type="number" form-floating="true" name="price" label="Цена, рубли" value="499"></x-form.input>
                                </div>
                                <div class="col-6 mt-2">
                                    <x-form.input form-floating="true" name="image" label="Класс иконки" value="fa-solid fa-icons"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input form-floating="true" name="link" label="Ссылка" value="ссылка-через-дефис"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input form-floating="true" name="description" label="Описание на карточке" value="Готовый документ за N минут"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input form-floating="true" name="preview_text" label="Описание сервиса , которые будет видно на главной странице" value="Сервис позволяет..."></x-form.input>
                                </div>
                            </div>

                        </x-tabs.tabs-pane>
                        <x-tabs.tabs-pane tab-id="meta" content-id="metaContent">
                            <h4>СЕО</h4>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <h5>Мета-теги</h5>
                                </div>
                                <div class="col-6 mt-2">
                                    <x-form.input form-floating="true" name="h1" label="H1" value="h1"></x-form.input>
                                </div>
                                <div class="col-6 mt-2">
                                    <x-form.input form-floating="true" name="title" label="Title" value="title"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input rows="5" type="textarea" form-floating="true" name="meta" label="Мета-теги через ';'" value="keywords=ключевые, слова, и, тд;description=описание"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <h5>Текст</h5>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input rows="10" type="textarea" form-floating="true" name="text" label="HTML-код текста" value="Текст"></x-form.input>
                                </div>
                            </div>

                        </x-tabs.tabs-pane>
                        <x-tabs.tabs-pane tab-id="additional" content-id="additionalContent">
                            <h4>Дополнительно</h4>

                            <div class="row mt-2">
                                <div class="col-12 mt-2">
                                    <x-form.input form-floating="true" name="videos" label="Ссылки на видео в YouTube через |" value="|"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input type="number" form-floating="true" name="rating" label="Приоритет отображения" value="-1"></x-form.input>
                                    <span class="text-muted">*0 - по умолчанию, обычный приоритет, -1 - не отображать</span>
                                </div>
                            </div>
                        </x-tabs.tabs-pane>
                        <!-- <x-tabs.tabs-pane tab-id="handle" content-id="handleContent">
                            <h4>Обработка</h4>
                            <span class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Раздел в разработке</span>
                            <div class="row mt-2">
                                <div class="col-12 mt-2">
                                    <x-form.input name="template" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" type="file" multiple label="Шаблон(ы)"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input rows="10" type="textarea" form-floating="true" name="php" label="PHP-код обработки" value=""></x-form.input>
                                </div>
                            </div>
                        </x-tabs.tabs-pane> -->
                    </x-tabs.tabs-content>
                </div>

                <x-form.btn>Сохранить</x-form.btn>
            </x-form.form>
        </div>
    </div>
</x-layout.row>
@endSection