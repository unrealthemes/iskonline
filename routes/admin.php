<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminFormsController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentAreaController;
use App\Http\Controllers\Form\FormsUIGroupsController;
use App\Http\Controllers\Form\FormsUIInputsController;
use App\Http\Controllers\Form\FormsUIStepsController;
use App\Http\Controllers\Form\FormsUIFormsController;

// Админ. панель
Route::middleware(['auth', 'admin'])->prefix('/админ')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    Route::prefix('/заявления')->group(function () {
        Route::get('/', [AdminController::class, 'applications'])->name("admin.applications.index");
        Route::get('/обновить', [AdminController::class, 'applicationUpdate'])->name("admin.applications.update");
        Route::get('/документ/{application}', [AdminController::class, 'applicationGet'])->name("admin.applications.get");
    });

    Route::prefix('/сервисы')->group(function () {
        Route::get('/', [AdminServiceController::class, 'index'])->name("admin.services.index");
        Route::get('/редактирование/{service}', [AdminServiceController::class, 'edit'])->name("admin.services.edit");
        Route::post('/редактирование/{service}', [AdminServiceController::class, 'update'])->name("admin.services.update");
        Route::get('/создание', [AdminServiceController::class, 'create'])->name("admin.services.create");
        Route::post('/создание', [AdminServiceController::class, 'store'])->name("admin.services.store");
        Route::get('/удаление/{service}', [AdminServiceController::class, 'delete'])->name("admin.services.delete");

        Route::get('/документ/{service}/{document}', [AdminServiceController::class, 'document'])->name("admin.services.document");
        Route::post('/загрузка-документа/{service}', [AdminServiceController::class, 'uploadDocument'])->name("admin.services.upload");
        Route::get('/удаление-документа/{service}/{document}', [AdminServiceController::class, 'deleteDocument'])->name("admin.services.deleteDocument");
        Route::post('/обработчик/{service}/', [AdminServiceController::class, 'putHandler'])->name("admin.services.handler");
    });

    Route::prefix('/блог')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('admin.blog.index');
        Route::get('/создание', [BlogController::class, 'create'])->name('admin.blog.create');
        Route::post('/создание', [BlogController::class, 'store'])->name('admin.blog.store');
        Route::get('/редактирование/{blog}', [BlogController::class, 'edit'])->name('admin.blog.edit');
        Route::post('/редактирование/{blog}', [BlogController::class, 'update'])->name('admin.blog.update');
        Route::get('/удаление/{blog}', [BlogController::class, 'delete'])->name('admin.blog.delete');
    });

    Route::prefix('/элементы-вставки')->group(function () {
        Route::get('/{service}', [DocumentAreaController::class, 'index'])->name("admin.areas.index");
        Route::get('/{service}/создание', [DocumentAreaController::class, 'create'])->name("admin.areas.create");
        Route::post('/{service}/создание', [DocumentAreaController::class, 'store'])->name("admin.areas.store");
        Route::get('/редактирование/{area}', [DocumentAreaController::class, 'edit'])->name("admin.areas.edit");
        Route::post('/редактирование/{area}', [DocumentAreaController::class, 'update'])->name("admin.areas.update");
        Route::get('/удаление/{area}', [DocumentAreaController::class, 'delete'])->name("admin.areas.delete");
    });

    Route::prefix('/формы')->group(function () {
        Route::get('/', [AdminFormsController::class, 'index'])->name("admin.forms.index");

        Route::prefix('/формы')->group(function () {
            Route::get('/', [FormsUIFormsController::class, 'index'])->name("admin.forms.forms.index");
            Route::get('/создание', [FormsUIFormsController::class, 'create'])->name("admin.forms.forms.create");
            Route::get('/редактирование/{form}', [FormsUIFormsController::class, 'edit'])->name("admin.forms.forms.edit");

            Route::post('/создание', [FormsUIFormsController::class, 'store'])->name("admin.forms.forms.store");
            Route::post('/редактирование/{form}', [FormsUIFormsController::class, 'update'])->name("admin.forms.forms.update");
            Route::get('/удаление/{form}', [FormsUIFormsController::class, 'delete'])->name("admin.forms.forms.delete");

            Route::get('/json/{form}', [FormsUIFormsController::class, 'getJson'])->name("admin.forms.forms.getJson");
        });

        Route::prefix('/шаги')->group(function () {
            Route::get('/', [FormsUIStepsController::class, 'index'])->name("admin.forms.steps.index");

            Route::post('/создание/{form}', [FormsUIStepsController::class, 'store'])->name("admin.forms.steps.store");
            Route::post('/обновление/{form}', [FormsUIStepsController::class, 'update'])->name("admin.forms.steps.update");
            Route::get('/удаление/{step}', [FormsUIStepsController::class, 'delete'])->name("admin.forms.steps.delete");
            Route::get('/получение', [FormsUIStepsController::class, 'get'])->name("admin.forms.steps.get");
            Route::get('/привязка/{form}/{step}', [FormsUIStepsController::class, 'link'])->name("admin.forms.steps.link");
            Route::get('/копирование/{form}/{step}', [FormsUIStepsController::class, 'clone'])->name("admin.forms.steps.clone");
            Route::post('/перемещение/{form}', [FormsUIStepsController::class, 'move'])->name("admin.forms.steps.move");
        });

        Route::prefix('/группы')->group(function () {
            Route::get('/', [FormsUIGroupsController::class, 'index'])->name("admin.forms.groups.index");

            Route::post('/создание/{form}', [FormsUIGroupsController::class, 'store'])->name("admin.forms.groups.store");
            Route::post('/обновление/{form}', [FormsUIGroupsController::class, 'update'])->name("admin.forms.groups.update");

            Route::get('/удаление/{element}', [FormsUIGroupsController::class, 'delete'])->name("admin.forms.groups.delete");
            Route::get('/получение', [FormsUIGroupsController::class, 'get'])->name("admin.forms.groups.get");
            Route::post('/привязка/{group}', [FormsUIGroupsController::class, 'link'])->name("admin.forms.groups.link");
            Route::post('/копирование/{group}', [FormsUIGroupsController::class, 'clone'])->name("admin.forms.groups.clone");
        });

        Route::prefix('/поля')->group(function () {
            Route::get('/', [FormsUIInputsController::class, 'index'])->name("admin.forms.inputs.index");
            Route::post('/создание/{form}', [FormsUIInputsController::class, 'store'])->name("admin.forms.inputs.store");
            Route::post('/обновление/{form}', [FormsUIInputsController::class, 'update'])->name("admin.forms.inputs.update");

            Route::get('/удаление/{element}', [FormsUIInputsController::class, 'delete'])->name("admin.forms.inputs.delete");
            Route::get('/получение', [FormsUIInputsController::class, 'get'])->name("admin.forms.inputs.get");
            Route::post('/привязка/{input}', [FormsUIInputsController::class, 'link'])->name("admin.forms.inputs.link");
            Route::post('/копирование/{input}', [FormsUIInputsController::class, 'clone'])->name("admin.forms.inputs.clone");

            Route::post('/логика', [FormsUIInputsController::class, 'logic'])->name("admin.forms.inputs.logic");
        });

        Route::prefix('/элементы')->group(function () {
            Route::post('/перемещение', [FormsUIGroupsController::class, 'move'])->name("admin.forms.elements.move");
        });
    });
});
