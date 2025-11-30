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
use App\Http\Controllers\Organizer\DashboardController as OrganizerDashboardController;
use App\Http\Controllers\Organizer\EventController;
use App\Http\Controllers\Organizer\OrderController;
use App\Http\Controllers\Organizer\TicketController;
use App\Http\Controllers\Organizer\ProfileOrganizerController;

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

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


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
Route::middleware([AuthCustom::class, RoleOrganizer::class])->prefix('organizer')->group(function () {
    Route::get('/dashboard', [OrganizerDashboardController::class, 'index'])->name('organizer.dashboard');
    Route::get('/events', [EventController::class, 'index'])->name('organizer.events');
    Route::get('/events/create', [EventController::class, 'create'])->name('organizer.events.create');
    Route::post('/events', [EventController::class, 'store'])->name('organizer.events.store');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('organizer.events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('organizer.events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('organizer.events.destroy');

    // Manage Tiket per Event
    Route::get('/events/{event}/tickets', [TicketController::class, 'index'])->name('organizer.tickets.index');
    Route::get('/events/{event}/tickets/create', [TicketController::class, 'create'])->name('organizer.tickets.create');
    Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->name('organizer.tickets.store');
    Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('organizer.tickets.edit');
    Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('organizer.tickets.update');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('organizer.tickets.destroy');

    // Pemesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('organizer.orders');

    // Profile
    Route::get('/profile', [ProfileOrganizerController::class, 'index'])->name('organizer.profile');
    Route::post('/logout', [ProfileOrganizerController::class, 'logout'])->name('organizer.logout');
});
