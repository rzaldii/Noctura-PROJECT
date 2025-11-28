<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Middleware\AuthCustom;
use App\Http\Middleware\GuestCustom;
use App\Http\Middleware\RoleCustomer;
use App\Http\Middleware\RoleOrganizer;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\ProfileCustomerController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('guest.custom')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
});

Route::get('/login/clear', function () {
    session()->flush();
    return redirect()->route('login');
})->name('login.clear');

// guest
Route::middleware(GuestCustom::class)->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
});

// customer
Route::middleware([AuthCustom::class, RoleCustomer::class])->group(function () {
    Route::get('/customer/dashboard', [DashboardController::class, 'index'])
        ->name('customer.dashboard');
    Route::get('/customer/cart', function() { return 'Keranjang'; })
        ->name('customer.cart');
    Route::get('/customer/history', function() { return 'Riwayat'; })
        ->name('customer.history');
    Route::get('/customer/profile', [ProfileCustomerController::class, 'index'])
        ->name('customer.profile');
    Route::post('/customer/logout', [ProfileCustomerController::class, 'logout'])
        ->name('customer.logout');
});

// organizer
Route::middleware([AuthCustom::class, RoleOrganizer::class])->group(function () {
    Route::get('/organizer/dashboard')->name('organizer.dashboard');
});
