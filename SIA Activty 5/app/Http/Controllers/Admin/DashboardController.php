<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // ✅ Redirect admin to admin dashboard
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // ✅ Internal API (Users)
        $users = User::all();

        // ✅ External API (Safe version - no API key required)
        $response = Http::get('https://api.thenewsapi.com/v1/news/top?api_token=eAoUNwvgZGmvBoMJVEcU2SqLdppMz4nGzh55VeFm&language=en&locale=us');

        if ($response->successful()) {
            $news = array_slice($response->json(), 0, 5);
        } else {
            $news = [];
        }

        return view('dashboard', compact('users', 'news'));
    }
}