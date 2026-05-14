<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // 1. Show the form
    public function create()
    {
        return view('studio_booking');
    }

    // 2. Handle form submission & Validation
    public function store(Request $request)
    {
        // Validation (30 pts)
        $request->validate([
            'client_name' => 'required|min:5',      // Rule: Required & Min length
            'client_email' => 'required|email',    // Rule: Required & Email format
            'session_date' => 'required|date',     // Rule: Date format
            'duration' => 'required|numeric|min:1', // Rule: Numeric & Min value
            'studio_room' => 'required',           // Rule: Required
            'notes' => 'nullable|max:200'          // Rule: Max characters
        ], [
            // Custom Validation Messages (Bonus)
            'client_name.min' => 'Please enter your full professional name.',
            'duration.min' => 'Minimum booking is 1 hour.',
        ]);

        // If validation passes, redirect with success message (Bonus)
        return back()->with('success', 'Studio session booked successfully for ' . $request->client_name . '!');
    }
}