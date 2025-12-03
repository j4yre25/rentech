<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products placeholder
Route::get('/products', function () {
    return Inertia::render('Products/Index', [
        'products' => []
    ]);
})->name('products.index');