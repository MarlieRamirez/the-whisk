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
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\RecipeController;
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
        Route::get('categories/{updated?}', 'index')->name('category.index');
        Route::get('category/new', 'new')->name('category.form');
        Route::post('category', 'store')->name('category.store');
        Route::get('category/{id}', 'show')->name('category.edit');
        Route::put('category/{id}', 'update')->name('category.update');
        Route::delete('category/{id}', 'destroy')->name('category.destroy');;
    });

    Route::controller(SectorController::class)->group(function () {
        Route::get('types/{updated?}', 'index')->name('types.index');
        Route::get('types/new', 'new')->name('types.form');
        Route::post('types', 'store')->name('types.store');
        Route::get('type/{id}', 'show')->name('type.edit');
        Route::put('types/{id}', 'update')->name('type.update');
        Route::delete('type/{id}', 'destroy')->name('type.destroy');;
    });

    Route::controller(BrandController::class)->group(function () {
        Route::get('brands/{updated?}', 'index')->name('brand.index');
        Route::get('brand/new', 'new')->name('brand.form');
        Route::get('brand/{id}', 'show')->name('brand.edit');
        Route::post('brand', 'store')->name('brand.store');
        Route::put('brand/{id}', 'update')->name('brand.update');
        Route::delete('brand/{id}', 'destroy')->name('brand.destroy');;
    });

    Route::controller(IngredientsController::class)->group(function () {
        Route::get('ingredients/{updated?}', 'index')->name('ingredient.index');
        Route::get('ingredient/new', 'new')->name('ingredient.form');
        Route::get('ingredient/{id}', 'show')->name('ingredient.edit');
        Route::post('ingredient', 'store')->name('ingredient.store');
        Route::put('ingredient/{id}', 'update')->name('ingredient.update');
        Route::delete('ingredient/{id}', 'destroy')->name('ingredient.destroy');;
    });

    Route::controller(RecipeController::class)->group(function () {
        //General
        Route::get('recipes/{updated?}', 'index')->name('recipe.index');
        Route::get('recipe/new', 'new')->name('recipe.form');
        Route::get('recipe/{id}', 'show')->name('recipe.edit');
        Route::post('recipe', 'store')->name('recipe.store');
        Route::put('recipe/{id}', 'update')->name('recipe.update');
        Route::delete('recipe/{id}', 'destroy')->name('recipe.destroy');
        //Details
        Route::get('recipes/detail/{id}/{updated?}', 'details_index')->name('details.index');
        Route::delete('recipes/detail/{id}', 'details_destroy')->name('details.destroy');
        Route::get('detail/{id}', 'details_form')->name('details.edit');
        Route::put('detail/{id}', 'details_update')->name('details.update');
    });
    

});
