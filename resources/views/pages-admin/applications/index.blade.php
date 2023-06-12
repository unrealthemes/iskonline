@extends('layouts.admin.base-admin-page')

@section('title', 'Управление заявлениями')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.applications.index") }}'>Заявления</x-menu.breadcrumb-item>
@endSection


@section('section-content')
<x-layout.row>
    <div class="col-12">
        <div class="block bg-white">
            <table id="applicationsTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Сервис</th>
                        <th>Пользователь</th>
                        <th>Телефон</th>
                        <th>Дата</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                    @if (($application->user_id == 0 or isset($users[$application->user_id])) and isset($services[$application->service_id]))
                    <tr>
                        <td><a role="button" data-id="{{ $application->id }}" data-bs-toggle="modal" data-bs-target="#applicationModal" class="text-primary" data-confirmed="{{ $application->confirmed }}" data-edited="{{ $application->edited }}" data-application_status_id="{{ $application->application_status_id }}" data-payed="{{ $application->payed }}" onclick="setModal(event)">{{ $services[$application->service_id] }}</a></td>
                        <td>{!! $application->user_id ? htmlspecialchars($users[$application->user_id]) : "<span class='text-warning'>Неавтор. пользователь</span>" !!}</td>
                        <td>{!! $application->user_id ? htmlspecialchars($usersTel[$application->user_id]) : "<span class='text-warning'>-</span>" !!}</td>
                        <td><span hidden>{{ $application->created_at }}</span>{{ date('d.m.Y H:i', strtotime($application->created_at)) }}</td>
                        @if($application->application_status_id <= 2) @if($application->application_status_id == 1)
                            <td class="table-{{ $application->payed ? 'danger' : 'secondary' }}">
                                @if($application->payed == 1)<i class="text-danger fa-solid fa-triangle-exclamation"></i>@endIf
                                @else
                            <td class="table-{{ $application->payed ? 'success' : 'danger' }}">
                                @if($application->payed == 0)<i class="text-danger fa-solid fa-triangle-exclamation"></i>@endIf
                                @endif
                                {{ $application_statuses[$application->application_status_id]->name }}
                                @if($application->edited == 1)<i class="text-warning fa-solid fa-lock"></i>@endIf
                            </td>
                            @else
                            <td class="table-{{ $application->payed ? 'success' : 'secondary' }}">{{ $application_statuses[$application->application_status_id]->name }}</td>
                            @endIf
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <div class="col-12 mt-4">
        <div class="block bg-white">
            <h3>Обозначения</h3>
            <table class="mt-2 table">
                <tbody>
                    <tr>
                        <td class="table-success">Готов</td>
                        <td>Документ оплачен, готов, еще есть возможность редактировать</td>
                    </tr>
                    <tr>
                        <td class="table-success">Готов <i class="text-warning fa-solid fa-lock"></i></td>
                        <td>Документ оплачен, готов, уже редактирован</td>
                    </tr>
                    <tr>
                        <td class="table-secondary">Готов </td>
                        <td>Услуга оплачена, но пользователь ещё не просмотрел данные (Касается сервисов типа "HTML на выходе")</td>
                    </tr>
                    <tr>
                        <td class="table-secondary">Оплата сервисного сбора</td>
                        <td>Документ ждёт оплаты, редактирование и загрузка пока недоступны</td>
                    </tr>
                    <tr>
                        <td class="table-secondary">Оплата сервисного сбора <i class="text-warning fa-solid fa-lock"></i></td>
                        <td>Документ ждёт оплаты, загрузка пока недоступна, редактирование заблокировано <b class="text-danger">(Естественным путём не возникает)</b></td>
                    </tr>
                    <tr>
                        <td><b>Случаи некорректной отработки сервиса</b></td>
                    </tr>
                    <tr>
                        <td class="table-danger"><i class="text-danger fa-solid fa-triangle-exclamation"></i> Оплата сервисного сбора</td>
                        <td>Документ считается оплаченным, но загрузка недоступна</td>
                    </tr>
                    <tr>
                        <td class="table-danger"><i class="text-danger fa-solid fa-triangle-exclamation"></i> Готов</td>
                        <td>Документ отображается готовым, но не оплачен, загрузка недоступна</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layout.row>
<div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
    <form class="modal-dialog" action="{{ route('admin.applications.update') }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applicationModalLabel">Действия с заявлением</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column gap-3">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="application_status_id">Статус</label>
                        <select class="form-select form-select-lg" name="application_status_id" id="application_status_id">
                            @foreach($application_statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endForeach
                        </select>
                        <br>
                        <label for="confirmed">Подтверждение</label>
                        <select class="form-select form-select-lg" name="confirmed" id="confirmed">
                            <option value="0">Не подтверждено</option>
                            <option value="1">Подтверждено</option>
                        </select>
                        <br>
                        <label for="payed">Оплата</label>
                        <select class="form-select form-select-lg" name="payed" id="payed">
                            <option value="0">Не оплачено</option>
                            <option value="1">Оплачено</option>
                        </select>
                        <br>
                        <label for="edited">Редактирование</label>
                        <select class="form-select form-select-lg" name="edited" id="edited">
                            <option value="0">Не редактировано</option>
                            <option value="1">Редактировано</option>
                        </select>
                        <br>
                        <a href="" id="document" class="btn btn-success">Скачать документ / Получить данные</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>

            </div>
        </div>
    </form>
</div>
<script>
    window.jQuery = window.$ = $;

    jQuery(function($) {
        $(document).ready(function() {
            $('#applicationsTable').DataTable({
                "language": {
                    "lengthMenu": "Показывать _MENU_ строк на страницу",
                    "zeroRecords": "Ничего не найдено - увы :(",
                    "info": "<b>Стр. _PAGE_ из _PAGES_</b>",
                    "infoEmpty": "Нет записей",
                    "infoFiltered": "(Выбрано из _MAX_ записей)",
                    "paginate": {
                        "first": "Первая",
                        "last": "Последняя",
                        "next": "Следующая",
                        "previous": "Предыдущая"
                    },
                    "search": "Поиск",
                },
                "order": [
                    [3, 'desc']
                ]
            });
        });
    });

    const q = (el, item = document) => item.querySelector(el);
    const qq = (el, item = document) => item.querySelectorAll(el);

    const modal = {
        application_status_id: q(`#application_status_id`),
        confirmed: q(`#confirmed`),
        payed: q(`#payed`),
        edited: q(`#edited`),
        id: q(`#id`),
    };

    const documentLink = q('#document');

    const setModal = ev => {
        let el = ev.target;
        for (let key in modal) {
            modal[key].value = el.dataset[key];
        }

        documentLink.href = `https://xn--h1aeu.xn--80asehdb/%D0%B0%D0%B4%D0%BC%D0%B8%D0%BD/%D0%B7%D0%B0%D1%8F%D0%B2%D0%BB%D0%B5%D0%BD%D0%B8%D1%8F/%D0%B4%D0%BE%D0%BA%D1%83%D0%BC%D0%B5%D0%BD%D1%82/${el.dataset.id}`;
    }
</script>
@endSection