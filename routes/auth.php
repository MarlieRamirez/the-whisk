<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SectorController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::controller(CategoryController::class)->group(function () {
        Route::get('category', 'index');
        Route::get('category/new', 'new')->name('category.form');
        Route::post('category', 'store')->name('category.store');
        Route::get('category/{id}', 'show')->name('category.edit');
        Route::put('category/{id}', 'update')->name('category.update');
        Route::delete('category/{id}', 'destroy')->name('category.destroy');;
    });

    Route::controller(SectorController::class)->group(function () {
        Route::get('types', 'index');
        Route::get('types/new', 'new')->name('types.form');
        Route::post('types', 'store')->name('types.store');
        Route::get('types/{id}', 'show')->name('types.edit');
        Route::put('types/{id}', 'update')->name('types.update');
        Route::delete('types', 'destroy')->name('types.destroy');;
    });

    Route::controller(BrandController::class)->group(function () {
        Route::get('brand', 'index');
        Route::get('brand/new', 'new')->name('brand.form');
        Route::get('brand/{id}', 'show')->name('brand.edit');
        Route::post('brand', 'store')->name('brand.store');
        Route::put('brand/{id}', 'update')->name('brand.update');
        Route::delete('brand', 'destroy')->name('brand.destroy');;
    });
    

});
