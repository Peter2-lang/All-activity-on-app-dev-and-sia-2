<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SneakerController;

// Redirect home to the sneakers list
Route::get('/', function () { return redirect('/sneakers'); });

// Required Routes
Route::get('/sneakers', [SneakerController::class, 'index'])->name('sneakers.index');
Route::get('/sneakers/{id}', [SneakerController::class, 'show'])->name('sneakers.show');