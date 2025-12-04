<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

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
