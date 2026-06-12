<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\StorefrontController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/cliente/entrar', [CustomerAuthController::class, 'create'])->name('customer.login');
    Route::post('/cliente/entrar', [CustomerAuthController::class, 'store'])->name('customer.login.store');
    Route::post('/cliente/cadastro', [CustomerAuthController::class, 'register'])->name('customer.register');
});

Route::get('/cliente', CustomerDashboardController::class)->name('customer.dashboard');

Route::get('/', [StorefrontController::class, 'home'])->name('home');
Route::get('/produtos', [StorefrontController::class, 'products'])->name('products.index');
Route::get('/produtos/{product:slug}', [StorefrontController::class, 'show'])->name('products.show');

Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrinho/{product}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/carrinho/item/{itemKey}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrinho/item/{itemKey}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/pedido/{order:code}/sucesso', [CheckoutController::class, 'success'])->name('checkout.success');

Route::prefix('gestao')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('products', AdminProductController::class)->except('show');
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
});
