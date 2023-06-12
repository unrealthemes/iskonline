@extends('layouts.admin.base-admin-page')

@section('title', $service->name)

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.services.index") }}'>Сервисы</x-menu.breadcrumb-item>
<x-menu.breadcrumb-item link='{{ route("admin.services.edit", ["service" => $service->id]) }}'>Редактирование</x-menu.breadcrumb-item>
@endSection

@section('actions')
<x-form.btn class="confirm" confirm-text="Удалять сервис не рекомендуется, его можно просто скрыть!" color="danger" link="{{ route('admin.services.delete', ['service' => $service->id]) }}">Удалить</x-form.btn>
@endSection

@section('section-content')
<x-layout.row>
    <div class="col-6">
        <div class="block bg-white">
            <x-form.form action="{{ route('admin.services.update', ['service' => $service->id]) }}" method="POST">
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
                                    <x-form.input form-floating="true" name="name" label="Название" value="{{ $service->name }}"></x-form.input>
                                </div>
                                <div class="col-6 mt-2">
                                    <x-form.input type="select" form-floating="true" name="service_type_id" label="Тип сервиса">
                                        @foreach ($services_types as $key => $value)
                                        <option value="{{ $key }}" {{ $key == $service->service_type_id ? "selected" : "" }}>{{ $value }}</option>
                                        @endForeach
                                    </x-form.input>
                                </div>
                                <div class="col-6 mt-2">
                                    <x-form.input type="number" form-floating="true" name="price" label="Цена, рубли" value="{{ $service->price }}"></x-form.input>
                                </div>
                                <div class="col-6 mt-2">
                                    <x-form.input form-floating="true" name="image" label="Класс иконки" value="{{ $service->image }}"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input form-floating="true" name="link" label="Ссылка" value="{{ $service->link }}"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input form-floating="true" name="description" label="Описание на карточке" value="{{ $service->description }}"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input form-floating="true" name="preview_text" label="Описание сервиса , которые будет видно на главной странице" value="{{ $service->preview_text }}"></x-form.input>
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
                                    <x-form.input form-floating="true" name="h1" label="H1" value="{{ $service->h1 }}"></x-form.input>
                                </div>
                                <div class="col-6 mt-2">
                                    <x-form.input form-floating="true" name="title" label="Title" value="{{ $service->title }}"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input rows="5" type="textarea" form-floating="true" name="meta" label="Мета-теги через ';'" value="{{ $service->meta }}"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <h5>Текст</h5>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input rows="10" type="textarea" form-floating="true" name="text" label="HTML-код текста" value="{!! $service->text !!}"></x-form.input>
                                </div>
                            </div>

                        </x-tabs.tabs-pane>
                        <x-tabs.tabs-pane tab-id="additional" content-id="additionalContent">
                            <h4>Дополнительно</h4>

                            <div class="row mt-2">
                                <div class="col-12 mt-2">
                                    <x-form.input form-floating="true" name="videos" label="Ссылки на видео в YouTube через точку с запятой" value="{{ $service->videos }}"></x-form.input>
                                </div>
                                <div class="col-12 mt-2">
                                    <x-form.input type="number" form-floating="true" name="rating" label="Приоритет отображения" value="{{ $service->rating }}"></x-form.input>
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
    @if ($service->service_type_id == 0)
    <div class="col-6">
        <div class="block bg-white">
            <h4 class="">Загрузка нового шаблона</h4>
            <x-form.form action="{{ route('admin.services.upload', ['service' => $service->id]) }}" class="downloading-template">
                <x-form.input label="Файл шаблона в формате word" name='template' type="file"></x-form.input>
                <x-form.btn>Загрузить</x-form.btn>
            </x-form.form>

            <h4 class="mt-5">Загруженные шаблоны</h4>
            <table class="mt-3 table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Файл</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody id="templates">
                    @foreach ($templates as $template)
                    <tr>
                        <td><a target="_blank" href="{{ route('admin.services.document', ['document' => $template, 'service' => $service->id]); }}" class="text-primary">{{ $template }}</a></td>
                        <td><span data-document="{{ $template }}" class="delete" role="button"><i class="text-danger fa-solid fa-trash"></i></span></td>
                    </tr>
                    @endForeach

                </tbody>
            </table>

            <script>
                const $ = (el, item = document) => item.querySelector(el);
                const $$ = (el, item = document) => item.querySelectorAll(el);

                const form = $('.downloading-template');
                const templatesTable = $('#templates');

                const getDocumentUrl = `{{ route('admin.services.document', ['document' => 'doc', 'service' => $service->id]); }}`.replace('doc', "");
                const deleteDocumentUrl = `{{ route('admin.services.deleteDocument', ['document' => 'doc', 'service' => $service->id]); }}`.replace('doc', "");

                form.onsubmit = ev => {
                    ev.preventDefault();

                    let fd = new FormData(form);

                    fetch(form.action, {
                        method: "POST",
                        body: fd
                    }).then(r => r.json()).then(r => {
                        let file = r.file;
                        templatesTable.insertAdjacentHTML('beforeend', `
                            <tr>
                                <td><a target="_blank" href="${getDocumentUrl + file}" class="text-primary">${file}</a></td>
                                <td><span data-document="${file}" class="delete" role="button"><i class="text-danger fa-solid fa-trash"></i></span></td>
                            </tr>
                        `);

                    });
                }

                const handleDeleteButtons = () => {
                    $$('.delete').forEach(btn => {
                        btn.onclick = () => {
                            let url = deleteDocumentUrl + btn.dataset.document;

                            fetch(url).then(r => r.json()).then(r => {
                                btn.parentNode.parentNode.remove();
                            });
                        };
                    });
                }

                handleDeleteButtons();
            </script>


            <h4 class="mt-5">Элементы вставки в документ</h4>
            <a href="{{ route('admin.areas.index', ['service' => $service->id]) }}" class="mt-3 btn btn-primary">Перейти к элементам вставки</a>
        </div>
    </div>
    @endIf

    @if ($service->service_type_id != 2)
    <div class="col-8 mt-4">
        <div class="block bg-white">
            <h4>Обработчик</h4>
            <br>
            <p><span class="text-muted" role="button" data-bs-toggle="modal" data-bs-target="#editorHelperModal"><i class="fa-solid fa-circle-info"></i> Справка по написанию обработчика</span></p>
            <br>
            <style type="text/css" media="screen">
                #editor {
                    position: absolute;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    left: 0;

                }

                #editor,
                #editor * {
                    font-family: monospace !important;
                }
            </style>
            <x-form.form action="{{ route('admin.services.handler', ['service' => $service->id]) }}" class="handler-editor">
                <textarea class="d-none" id="handler" name="handler"></textarea>
                <div class="mt-2" style="position: relative; height: 400px;">
                    <div id="editor">{{ $handler }}</div>
                </div>
                <x-form.btn class="mt-3">Сохранить</x-form.btn>
            </x-form.form>

            <script>
                var editor = ace.edit('editor');
                // Default value is the first one in comments
                // All options are set to default value
                editor.setOptions({
                    fontSize: 16, // number | string: set the font size to this many pixels
                });

                editor.session.setMode("ace/mode/php");

                const editorForm = document.querySelector('.handler-editor');

                editorForm.onsubmit = ev => {
                    ev.preventDefault();

                    document.querySelector('#handler').innerHTML = editor.getValue();

                    let fd = new FormData(editorForm);

                    fetch(editorForm.action, {
                        method: "POST",
                        body: fd
                    }).then(r => r.json()).then(r => {
                        console.log(r);
                        let alert = document.createElement('div');
                        alert.className = `mt-3 alert alert-success`;
                        alert.innerHTML = "Обработчик успешно сохранён";
                        editorForm.querySelector('.errors').appendChild(alert);

                        setTimeout(() => {
                            alert.remove();
                        }, 1500);
                    });
                }
            </script>
        </div>
    </div>
    @endif
</x-layout.row>
<div class="modal fade" id="editorHelperModal" tabindex="-1" aria-labelledby="editorHelperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editorHelperModalLabel">Инструкция по обработчику</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Здесь будет техническая памятка по написанию обработчика</p>
                <p>Пока не готова <i class="fa-regular fa-face-smile"></i></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
@endSection