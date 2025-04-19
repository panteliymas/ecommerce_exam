<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Admin\ProductsController as AdminProductsController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Api\ProductsApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CartController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Products
Route::get('/', [ProductsController::class, 'catalog'])->name('products.catalog');
Route::get('/products/{id}', [ProductsController::class, 'product'])->name('products.product');

// cart
Route::get('/cart', [CartController::class, 'cart'])->name('cart.get');
Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/{product_id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/checkout', [CartController::class, 'checkoutPage'])->name('cart.checkout');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout.post');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(\App\Http\Middleware\AdminMiddleware::class)
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('dashboard');

        Route::get('/products', [AdminProductsController::class, 'catalog'])->name('products.catalog');
        Route::get('/product/{id?}', [AdminProductsController::class, 'product'])->name('products.product');
        Route::post('/product', [AdminProductsController::class, 'saveProduct'])->name('products.create');
        Route::post('/product/{id}', [AdminProductsController::class, 'saveProduct'])->name('products.save');
        Route::delete('/product/{id}', [AdminProductsController::class, 'deleteProduct'])->name('products.delete');

        Route::get('/categories', [AdminProductsController::class, 'categories'])->name('categories');
        Route::get('/category/{id?}', [AdminProductsController::class, 'category'])->name('categories.category');
        Route::post('/category', [AdminProductsController::class, 'saveCategory'])->name('categories.create');
        Route::post('/category/{id}', [AdminProductsController::class, 'saveCategory'])->name('categories.save');
        Route::delete('/category/{id}', [AdminProductsController::class, 'deleteCategory'])->name('categories.delete');

    });

require __DIR__.'/auth.php';
