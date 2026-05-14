<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

// 1. Redirect the home page to the booking form automatically
Route::get('/', function () {
    return redirect()->route('booking.create');
});

// 2. The route to show the form
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');

// 3. The route to handle the form submission
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');