<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategorysController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/api.php';

Route::resource('products', ProductsController::class)->only([
    'index', 'filterIndex', 'create', 'store', 'edit', 'update', 'destroy'
]);

Route::resource('categorys', CategorysController::class)->only([
    'create', 'store', 'edit', 'destroy' //'update', 
]);

Route::put('/categorys/update/{category}', [CategorysController::class, 'update'])->name('categorys.update');
