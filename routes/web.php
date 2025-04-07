<?php

use App\Http\Controllers\DashboardController;
use App\Http\Middleware\Admin;
use App\Models\Ingredients;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('admin', function () {
//     return Inertia::render('DashboardAdmin', ["lowStock"=>Ingredients::all()]);
// })->middleware(Admin::class)->name('dashboard');

Route::get('admin', [DashboardController::class, 'widget']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
