<?php
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Вход, регистрация и т.д.
Route::get('/вход', [UserController::class, 'login'])->name('login');
Route::get('/подтверждение-входа', [UserController::class, 'loginConfirmation'])->name('login.confirmation');

Route::get('/регистрация', [UserController::class, 'register'])->name('register');
Route::get('/подтверждение-регистрации', [UserController::class, 'registerConfirmation'])->name('register.confirmation');

Route::get('/выход', [UserController::class, 'logout'])->name('logout');

// Подтверждения
Route::post('/подтверждение-номера', [ConfirmationController::class, 'confirmFlashcall'])->name('confirm.flashcall');
Route::post('/подтверждение-смс', [ConfirmationController::class, 'confirmSMS'])->name('confirm.sms');
Route::post('/повторное-подтверждение', [ConfirmationController::class, 'repeatConfirmation'])->name('confirm.repeat');

// Аккаунт
Route::middleware('auth')->prefix('/кабинет')->group(function () {
    Route::get('/профиль', [AccountController::class, 'profile'])->name('account.profile');
    Route::post('/обновление-профиля', [AccountController::class, 'profileUpdate'])->name('account.profile.update');
    Route::get('/заявления', [AccountController::class, 'applications'])->name('account.applications');
});
