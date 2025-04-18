<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
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
// Route::get('/cart', [CartController::class, 'cart'])->name('cart.get');
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

require __DIR__.'/auth.php';
