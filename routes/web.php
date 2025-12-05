<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Models\Product; 


// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');


// Public product details page (Inertia -> ViewDetailsGadget)
Route::get('/gadgets/{product}', [ProductController::class, 'view'])->name('gadgets.show');

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

Route::get('/viewdetails', function () {
    return Inertia::render('Pages/ViewDetailsGadget'); // or return view('auth.login');
})->name('view');


Route::get('/login', function () {
    return Inertia::render('Auth/Login'); 
})->name('login');

Route::get('/register', function () {
    return Inertia::render('Auth/Register'); 
})->name('register');

Route::get('/test', function () {
    return Inertia::render('TestComponent');
});
