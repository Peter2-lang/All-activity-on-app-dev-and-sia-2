<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        // ✅ Internal Users
        $users = User::all();

        // ✅ External API (Always works)
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        if ($response->successful()) {
            $news = array_slice($response->json(), 0, 5);
        } else {
            $news = [];
        }

        return view('dashboard', compact('users', 'news'));
    }
}