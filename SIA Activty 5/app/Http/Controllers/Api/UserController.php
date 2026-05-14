<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function index(Request $request)
{
    $query = User::select('id', 'name', 'full_name', 'email', 'role', 'created_at');

    if ($request->has('role')) {
        $query->where('role', $request->role);
    }

    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('full_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $users = $query->get();
    
        return response()->json(User::all());
 
}
    
}