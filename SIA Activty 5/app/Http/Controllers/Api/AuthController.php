<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'full_name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ]);
    }

    // Login
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'message' => 'Login successful',
            'user' => $user
        ]);
    }

    // Get logged user
    public function user()
    {
        return response()->json(Auth::user());
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}