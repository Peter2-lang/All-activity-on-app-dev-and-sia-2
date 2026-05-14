<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuitarController;

// This handles all the CRUD routes (index, create, store, etc.)
Route::resource('guitars', GuitarController::class);

// This fixes the error on the home page (http://127.0.0.1:8000)
// It will now automatically take you to your Guitar list
Route::get('/', function () {
    return redirect()->route('guitars.index');
});