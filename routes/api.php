<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategorysController;
use Illuminate\Support\Facades\Route;

Route::get('/productsa', [ProductsController::class, 'index_api']);
Route::get('/productsaf', [ProductsController::class, 'filterIndex_api']);
Route::post('/productsa', [ProductsController::class, 'store_api'])->middleware(['auth', 'verified']);
Route::get('/productsa/{id}/edit', [ProductsController::class, 'edit_api'])->middleware(['auth', 'verified']);
Route::put('/productsa/{id}', [ProductsController::class, 'update_api'])->middleware(['auth', 'verified']);
Route::delete('/productsa/{id}', [ProductsController::class, 'destroy_api'])->middleware(['auth', 'verified']);

Route::get('/categorysapi', [CategorysController::class, 'index_api']);
Route::post('/categorysa', [CategorysController::class, 'store_api'])->middleware(['auth', 'verified']);
Route::get('/categorysa/{id}/edit', [CategorysController::class, 'edit_api'])->middleware(['auth', 'verified']);
Route::put('/categorysa/{id}', [CategorysController::class, 'update_api'])->middleware(['auth', 'verified']);
Route::delete('/categorysa/{id}', [CategorysController::class, 'destroy_api'])->middleware(['auth', 'verified']);
