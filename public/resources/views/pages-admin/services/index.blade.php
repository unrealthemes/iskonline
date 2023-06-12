@extends('layouts.admin.base-admin-page')

@section('title', 'Управление сервисами')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.services.index") }}'>Сервисы</x-menu.breadcrumb-item>
@endSection

@section('actions')
<x-form.btn color="primary" link="{{ route('admin.services.create') }}">Добавить</x-form.btn>
@endSection

@section('section-content')
<x-layout.row>
    <div class="col-12">
        <div class="block bg-white">
            <table id="servicesTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Цена, <small><i class="fa-solid fa-ruble-sign"></i></small></th>
                        <th>Тип</th>
                        <th>Приоритет отображения</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                    <tr>
                        <td><a href="{{ route('admin.services.edit', ['service' => $service->id]) }}" class="text-primary"><i class="{{ $service->image }}"></i> {{ $service->name }}</a></td>
                        <td>{{ $service->price }}</td>
                        <td>{{ $services_types[$service->service_type_id] }}</td>
                        <td>{{ $service->rating }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-layout.row>

<script>
    window.jQuery = window.$ = $;

    jQuery(function($) {
        $(document).ready(function() {
            $('#servicesTable').DataTable({
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
                    "search": "Поиск"
                }
            });
        });
    });
</script>
@endSection