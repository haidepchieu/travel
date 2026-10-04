<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Homepage & Tour Browsing
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tour/{slug}', [HomeController::class, 'showTour'])->name('tour.show');
Route::get('/destination/{slug}', [HomeController::class, 'showDestination'])->name('destination.show');
Route::get('/activities/{slug}', [HomeController::class, 'showActivity'])->name('activities.show');
Route::get('/wishlist', [HomeController::class, 'wishlist'])->name('wishlist');

// Blog & Travel Tips
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Package Combo (Matching https://chestnuttravel.net/package/)
Route::get('/package', [HomeController::class, 'packageCombos'])->name('package.index');

// Tour Booking & Enquiry (Open for both Guests and Logged-in Users, rate limited to prevent spam)
Route::post('/booking', [BookingController::class, 'store'])->middleware('throttle:15,1')->name('booking.store');
Route::post('/tour/enquiry', [BookingController::class, 'enquiry'])->middleware('throttle:15,1')->name('tour.enquiry');
Route::get('/booking/success/{code}', [BookingController::class, 'success'])->name('booking.success');
Route::get('/booking/lookup', [BookingController::class, 'lookup'])->name('booking.lookup');

// Customer Authentication (Rate limited against brute force & spam)
Route::get('/login', fn () => redirect()->route('home', ['action' => 'login']))->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1')->name('customer.login');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1')->name('customer.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('customer.logout');

// Customer Dashboard (Requires Login)
Route::middleware('auth')->group(function () {
    Route::get('/my-account', [AccountController::class, 'index'])->name('my-account');
    Route::post('/my-account/profile', [AccountController::class, 'updateProfile'])->name('my-account.profile');
});

// Customized Tour (Matching https://chestnuttravel.net/customized-tour/)
Route::get('/customized-tour', [HomeController::class, 'customizedTour'])->name('customized-tour');
Route::post('/customized-tour', [BookingController::class, 'storeCustomizedTour'])->middleware('throttle:15,1')->name('customized-tour.store');

// Direct Article URL fallback (matches https://chestnuttravel.net/{slug}/)
Route::get('/{slug}', [BlogController::class, 'show'])->where('slug', '[a-zA-Z0-9\-_]+')->name('blog.direct');

