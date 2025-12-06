<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Models\Rentee;
use App\Http\Controllers\ReportsController;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');


// Public product details page (Inertia -> ViewDetailsGadget)
Route::get('/gadgets/{product}', [ProductController::class, 'view'])->name('gadgets.show');


// Public product details page (Inertia -> ViewDetailsGadget)
Route::get('/gadgets/{product}', [ProductController::class, 'view'])->name('gadgets.show');

Route::get('/register/rentee', function () {
    return Inertia::render('Auth/RegisterRentee');
})->name('register.rentee');

Route::post('/register/rentee', [
    App\Http\Controllers\RenteeRegistrationController::class,
    'store'
])->name('register.rentee');
Route::get('/email/confirm', function () {
    return Inertia::render('Auth/VerifyEmail', [
        'email' => request('email'),
    ]);
})->name('email.confirm.show');

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

    // Rentor Registration





    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
        ->group(function () {
            Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
        });
    Route::get('/customers', function () {
        $rentees = Rentee::paginate(10); // Fetch rentees with pagination
        return Inertia::render('Admin/Customers', [
            'rentees' => $rentees,
        ]);
    })->name('customers.index');

    Route::get('/customers/{id}', function ($id) {
        $customer = Rentee::findOrFail($id); // Fetch customer details
        return Inertia::render('Admin/CustomerDetails', [
            'customer' => $customer,
        ]);
    })->name('customers.details');

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::post('/products/batch-destroy', [ProductController::class, 'destroy'])->name('products.batchDestroy');
    Route::post('/categories/{category}/save-products', [CategoryController::class, 'saveProducts'])->name('categories.saveProducts');
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

Route::get('/email/confirm', function () {
    return Inertia::render('Auth/ConfirmEmail', [
        'email' => request('email'),
    ]);
})->name('email.confirm.show');

Route::get('/reports', [\App\Http\Controllers\ReportsController::class, 'index'])->name('reports.index');
