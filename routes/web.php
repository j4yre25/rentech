<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
        ->group(function () {
            Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
        });

    Route::resource('products', ProductController::class);
});


Route::get('/test', function () {
    return Inertia::render('TestComponent');
});
