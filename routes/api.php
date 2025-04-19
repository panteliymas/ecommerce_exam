<?php

use App\Http\Controllers\Api\ProductsApiController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::name('api.')
    ->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->name('login');

        Route::get('/products', [ProductsApiController::class, 'index'])->name('products.index');
        Route::get('/products/{id}', [ProductsApiController::class, 'show'])->name('products.show');

        
    });

Route::name('api.')
    // ->middleware('auth:sanctum')
    ->group(function() {
        Route::post('/products', [ProductsApiController::class, 'store'])->name('products.store');
        Route::put('/products/{id}', [ProductsApiController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductsApiController::class, 'destroy'])->name('products.destroy');
    });