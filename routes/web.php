<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ViewProductController;
use App\Http\Controllers\RentsController;
use App\Models\Rentee;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register/rentee', function () {
    return Inertia::render('Auth/RegisterRentee');
})->name('register.rentee');

Route::post('/register/rentee', [
    App\Http\Controllers\RenteeRegistrationController::class,
    'store'
])->name('register.rentee');

Route::get('/register/rentor', function () {
    return Inertia::render('Auth/RegisterRentor');
})->name('register.rentor');

Route::post('/register/rentor', [
    App\Http\Controllers\RentorRegistrationController::class,
    'store'
])->name('register.rentor');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

// Rentee Routes
Route::get('/gadgets', [ViewProductController::class, 'list'])->name('gadgets.list');
Route::get('/gadgets/{product}', [ViewProductController::class, 'show'])->name('gadgets.show');
Route::get('/gadgets/{product}/rent', [ViewProductController::class, 'rent'])->name('gadgets.rent');
Route::post('/gadgets/{product}/rent', [RentsController::class, 'store'])->name('gadgets.rent.store');

Route::get('/my-rents', [RentsController::class, 'index'])->name('rents.index');
// End of Rentee Routes

    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
        ->group(function () {
            Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
        });
        
    Route::get('/customers', function () {
        $rentees = Rentee::paginate(10);
        return Inertia::render('Admin/Customers', [
            'rentees' => $rentees,
        ]);
    })->name('customers.index');

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});

Route::get('/viewdetails', function () {
    return Inertia::render('Pages/ViewDetailsGadget');
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

Route::get('/email/confirm', function () {
    return Inertia::render('Auth/VerifyEmail', [
        'email' => request('email'),
    ]);
})->name('email.confirm.show');
