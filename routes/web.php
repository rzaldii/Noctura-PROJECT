<?php
// ============================================
// FILE 1: routes/web.php - FIXED VERSION
// ============================================
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
use App\Http\Controllers\Customer\CustomerOrderController;
// Organizer Controllers
use App\Http\Controllers\Organizer\DashboardController as OrganizerDashboardController;
use App\Http\Controllers\Organizer\EventController;
use App\Http\Controllers\Organizer\OrganizerOrderController;
use App\Http\Controllers\Organizer\TicketController;
use App\Http\Controllers\Organizer\ProfileOrganizerController;

// ========== LANDING & PUBLIC ROUTES ==========
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Detail event (public - bisa diakses tanpa login)
Route::get('/detail/event/{id}', [EventDetailController::class, 'show'])->name('event.detail');

// ========== AUTH ROUTES (GUEST ONLY) ==========
Route::middleware(GuestCustom::class)->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
});

// Clear login session
Route::get('/login/clear', function () {
    session()->flush();
    return redirect()->route('login');
})->name('login.clear');

// ========== CUSTOMER ROUTES ==========
Route::middleware([AuthCustom::class, RoleCustomer::class])->prefix('customer')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');

    // Profile
    Route::get('/profile', [ProfileCustomerController::class, 'index'])->name('customer.profile');
    Route::get('/profile/edit', [ProfileCustomerController::class, 'edit'])->name('customer.profile.edit');
    Route::post('/profile/update', [ProfileCustomerController::class, 'update'])->name('customer.profile.update');
    Route::post('/logout', [ProfileCustomerController::class, 'logout'])->name('customer.logout');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('customer.cart');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('customer.cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('customer.cart.delete');
    Route::delete('/cart/delete/event/{eventId}', [CartController::class, 'deleteEvent'])->name('customer.cart.delete_event');

    // Add to cart & Order now - HANYA DI SINI, TIDAK DI PUBLIC
    Route::post('/event/{id}/add-to-cart', [EventDetailController::class, 'addToCart'])->name('event.add_to_cart');
    Route::post('/event/{id}/order-now', [EventDetailController::class, 'orderNow'])->name('event.order_now');

    // Checkout & Orders
    Route::get('/checkout/{eventId}', [CustomerOrderController::class, 'checkoutShow'])->name('checkout.show');
    Route::post('/checkout/{eventId}', [CustomerOrderController::class, 'checkoutSubmit'])->name('checkout.submit');
    Route::get('/checkout/direct', [CustomerOrderController::class, 'directCheckout'])->name('customer.checkout.direct');
    Route::post('/checkout/direct', [CustomerOrderController::class, 'directCheckoutSubmit'])->name('customer.checkout.direct.submit');
    Route::get('/orders', [CustomerOrderController::class, 'history'])->name('customer.orders');
    Route::get('/orders/{id}', [CustomerOrderController::class, 'detail'])->name('customer.orders.detail');
    Route::get('/orders/{id}/download', [CustomerOrderController::class, 'downloadTicket'])->name('customer.orders.download');
});

// ========== ORGANIZER ROUTES ==========
Route::middleware([AuthCustom::class, RoleOrganizer::class])->prefix('organizer')->group(function () {
    // Dashboard
    Route::get('/dashboard', [OrganizerDashboardController::class, 'index'])->name('organizer.dashboard');

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('organizer.events');
    Route::get('/events/create', [EventController::class, 'create'])->name('organizer.events.create');
    Route::post('/events', [EventController::class, 'store'])->name('organizer.events.store');
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('organizer.events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('organizer.events.update');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('organizer.events.destroy');

    // Tickets
    Route::get('/events/{event}/tickets', [TicketController::class, 'index'])->name('organizer.tickets.index');
    Route::get('/events/{event}/tickets/create', [TicketController::class, 'create'])->name('organizer.tickets.create');
    Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->name('organizer.tickets.store');
    Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('organizer.tickets.edit');
    Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('organizer.tickets.update');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('organizer.tickets.destroy');

    // Orders
    Route::get('/orders', [OrganizerOrderController::class, 'index'])->name('organizer.orders');
    Route::get('/orders/report', [OrganizerOrderController::class, 'report'])->name('organizer.orders.report');
    Route::get('/orders/{id}', [OrganizerOrderController::class, 'show'])->name('organizer.orders.show');
    Route::post('/orders/{id}/approve', [OrganizerOrderController::class, 'approve'])->name('organizer.orders.approve');
    Route::post('/orders/{id}/cancel', [OrganizerOrderController::class, 'cancel'])->name('organizer.orders.cancel');

    // Profile
    Route::get('/profile', [ProfileOrganizerController::class, 'index'])->name('organizer.profile');
    Route::post('/logout', [ProfileOrganizerController::class, 'logout'])->name('organizer.logout');
});
