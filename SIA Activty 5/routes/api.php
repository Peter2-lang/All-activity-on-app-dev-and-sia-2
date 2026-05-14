<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/users', function () {
    return response()->json(['message' => 'API works']);
});
Route::get('/users', [UserController::class, 'index']);
// ==================== PUBLIC ROUTES ====================

// Health check
Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is running',
        'timestamp' => now()->toIso8601String(),
    ]);
});

// ==================== USERS (PUBLIC) ====================

// IMPORTANT: search must come BEFORE {id}
Route::get('/users/search', [UserController::class, 'search']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);

Route::get('/users', [UserController::class, 'index']);

// ==================== NEWS API ====================

Route::prefix('news')->group(function () {
    Route::get('/headlines', [PostController::class, 'headlines']);
    Route::get('/search', [PostController::class, 'search']);
    Route::get('/categories', [PostController::class, 'categories']);
    Route::get('/category/{category}', [PostController::class, 'byCategory']);
});

// ==================== AUTH (PUBLIC) ====================

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// ==================== PROTECTED ROUTES ====================

Route::middleware('auth:sanctum')->group(function () {

    // Logged-in user info
    Route::get('/user', [AuthController::class, 'user']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Clear news cache (admin only ideally)
    Route::post('/news/clear-cache', [PostController::class, 'clearCache']);
});