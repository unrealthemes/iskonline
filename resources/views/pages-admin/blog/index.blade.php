@extends('layouts.admin.base-admin-page')

@section('title', 'Управление страницами')

@section('breadcrumbs')
<x-menu.breadcrumb-item link='{{ route("admin.blog.index") }}'>Страницы</x-menu.breadcrumb-item>
@endSection

@section('actions')
<x-form.btn link="{{ route('admin.blog.create'); }}">Создать</x-form.btn>
@endSection

@section('section-content')
<div class="row">
    <div class="bg-white block">
        <table id="applicationsTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Страница</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blog as $page)
                <tr>
                    <td><a href="{{ route('admin.blog.edit', ['blog' => $page->id]) }}" class="text-primary">{{ $page->h1 }}</a></td>
                    <td>
                        <a target="_blank" href="{{ route('blog.show.'.$page->id) }}" class="me-2 text-primary"><i class="fa-solid fa-eye"></i></a>
                        <a href="{{ route('admin.blog.delete', ['blog' => $page->id]) }}" class="confirm text-danger"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endSection