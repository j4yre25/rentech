<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');



// Admins
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:rentor', // Restrict access to rentors only
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Rentor Registration
    Route::get('/register/rentor', function () {
        return Inertia::render('Auth/RegisterRentor');
    })->name('register.rentor');

    Route::post('/register/rentor', [
        App\Actions\Fortify\CreateNewRentor::class,
        'create'
    ])->name('register.rentor');

    // Rentor Login
    Route::get('/login/rentor', function () {
        return Inertia::render('Auth/RentorLogin');
    })->name('login.rentor');

    Route::post('/login/rentor', [
        App\Http\Controllers\AuthenticatedSessionController::class,
        'store'
    ])->name('login.rentor');



    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
        ->group(function () {
            Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
        });

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});

Route::get('/test', function () {
    return Inertia::render('TestComponent');
});
