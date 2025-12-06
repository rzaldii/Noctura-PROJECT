<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\EventDetailController;
// Middleware
use App\Http\Middleware\AuthCustom;
use App\Http\Middleware\GuestCustom;
use App\Http\Middleware\RoleCustomer;
use App\Http\Middleware\RoleOrganizer;
// Customer Controllers
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\ProfileCustomerController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController;
// Organizer Controllers
use App\Http\Controllers\Organizer\DashboardController as OrganizerDashboardController;
use App\Http\Controllers\Organizer\EventController;
use App\Http\Controllers\Organizer\OrderController as OrganizerOrderController;
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

// Detail event
Route::get('/detail/event/{id}', [EventDetailController::class, 'show'])->name('event.detail');
Route::post('/detail/event/{id}/add-to-cart', [EventDetailController::class, 'addToCart'])->name('event.add_to_cart');
Route::post('/detail/event/{id}/order-now', [EventDetailController::class, 'orderNow'])->name('event.order_now');

// guest
Route::middleware(GuestCustom::class)->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
});

// customer
Route::middleware([AuthCustom::class, RoleCustomer::class])->prefix('customer')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');
    // Profile
    Route::get('/profile', [ProfileCustomerController::class, 'index'])->name('customer.profile');
    Route::get('/profile/edit', [ProfileCustomerController::class, 'edit'])->name('customer.profile.edit');
    Route::post('/profile/update', [ProfileCustomerController::class, 'update'])->name('customer.profile.update');
    Route::post('/logout', [ProfileCustomerController::class, 'logout'])->name('customer.logout');
    // Cart page
    Route::get('/cart', [CartController::class, 'index'])->name('customer.cart');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('customer.cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('customer.cart.delete');
    Route::post('/event/{id}/add-to-cart', [CartController::class, 'addFromEvent'])->name('event.add_to_cart');
    Route::post('/event/{id}/order-now', [OrderController::class, 'orderNow'])->name('event.order_now');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('customer.cart.update');
    Route::delete('/cart/delete/event/{eventId}', [CartController::class, 'deleteEvent'])->name('customer.cart.delete_event');
    // Checkout lewat keranjang
    Route::get('/checkout/{eventId}', [OrderController::class, 'checkoutShow'])->name('checkout.show');
    Route::post('/checkout/{eventId}', [OrderController::class, 'checkoutSubmit'])->name('checkout.submit');
    // Checkout langsung
    Route::get('/customer/checkout/direct', [OrderController::class, 'directCheckout'])->name('customer.checkout.direct');
    Route::post('/customer/checkout/direct', [OrderController::class, 'directCheckoutSubmit'])->name('customer.checkout.direct.submit');
    // Riwayat
    Route::get('/orders', [OrderController::class, 'history'])->name('customer.orders');
    // Detail order
    Route::get('/orders/{id}', [OrderController::class, 'detail'])->name('customer.orders.detail');
    // Download tiket pdf
    Route::get('/orders/{id}/download', [OrderController::class, 'downloadTicket'])->name('customer.orders.download');


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
    Route::prefix('organizer')->middleware(['auth', 'role:organizer'])->group(function () {
    // Halaman daftar pemesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('organizer.orders');
    // Approve pemesanan
    Route::post('/orders/{id}/approve', [OrderController::class, 'approve'])->name('organizer.orders.approve');
    // Cancel pemesanan
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('organizer.orders.cancel');});
    // Pemesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('organizer.orders');
    // Profile
    Route::get('/profile', [ProfileOrganizerController::class, 'index'])->name('organizer.profile');
    Route::post('/logout', [ProfileOrganizerController::class, 'logout'])->name('organizer.logout');
});

