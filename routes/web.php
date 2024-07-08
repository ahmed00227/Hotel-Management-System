<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsCustomer;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\NotLoggedIn;
use App\Http\Middleware\NotVerified;
use App\Http\Middleware\EmailVerification;
use App\Http\Middleware\IsAdmin;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::fallback(function () {
    return view('authentication.fallback');
});
Route::middleware([AuthCheck::class, EmailVerification::class])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout')->withoutMiddleware([EmailVerification::class]);
    Route::post('/verify/email', [UserController::class, 'verifyEmail'])->name('verify')->withoutMiddleware([EmailVerification::class])->middleware([NotVerified::class]);
    Route::get('/resend/email', [UserController::class, 'resendEmail'])->name('resend')->withoutMiddleware([EmailVerification::class])->middleware([NotVerified::class]);
    Route::get('/user/verification', function () {
        return view('otp');
    })->name('otp-page')->withoutMiddleware([EmailVerification::class])->middleware([NotVerified::class]);
    Route::get('/user', [UserController::class, 'show'])->name('user.show')->withoutMiddleware([EmailVerification::class]);
    Route::get('/user/{id}/bookings', [UserController::class, 'showBookings'])->name('show-bookings');

    Route::get('/booking/create/{id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/create', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('booking.index')->middleware([IsAdmin::class]);

    Route::get('/owners', [UserController::class, 'indexOwners'])->name('owner.index')->middleware([IsAdmin::class]);
    Route::get('/users', [UserController::class, 'indexUsers'])->name('user.index')->middleware([IsAdmin::class]);
    Route::post('/owner/create', [UserController::class, 'createOwner'])->name('owner.create')->middleware([IsCustomer::class]);
    Route::get('/owner/{id}', [UserController::class, 'showOwner'])->name('owner_show');
    Route::get('/owner/request/status', [UserController::class, 'owner_request'])->name('owner_request')->middleware([IsCustomer::class]);


    Route::get('/room/create', [RoomController::class, 'create'])->name('room.create');
    Route::post('/room/create', [RoomController::class, 'store'])->name('room.store');
    Route::get('/room/{id}/bookings', [RoomController::class, 'roomBookings'])->name('room.bookings')->middleware([IsAdmin::class]);
    Route::get('/rooms', [RoomController::class, 'index'])->name('room.index')->middleware([IsAdmin::class]);
    Route::get('/activate/{id}', [RoomController::class, 'activate'])->name('activate')->middleware([IsAdmin::class]);
    Route::post('/city', [RoomController::class, 'cities'])->name('city-country');

    });
Route::middleware([NotLoggedIn::class])->group(function () {
    Route::get('/login', [UserController::class, 'loginPage'])->name('login-page');
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::get('/signup', [UserController::class, 'signupPage'])->name('signup-page');
    Route::post('/signup', [UserController::class, 'registration'])->name('signup');
});

Route::get('/booking/confirmation/{token}', [BookingController::class, 'bookingConfirmation'])->name('booking-confirmation');
Route::post('/city/list',[RoomController::class,'city_list'])->name('city.list');
Route::post('/room/search', [RoomController::class, 'city_search'])->name('city.search');
Route::get('/room/{id}', [RoomController::class, 'show'])->name('room.show');
Route::post('/room/filter',[RoomController::class,'filterRooms'])->name('filter-rooms');
