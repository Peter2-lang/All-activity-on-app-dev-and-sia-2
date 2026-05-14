<?php

namespace App\Http\Controllers;

use App\Models\Guitar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuitarController extends Controller
{
    // BONUS: Search and Pagination
    public function index(Request $request)
    {
        $search = $request->input('search');
        $guitars = Guitar::when($search, function ($query, $search) {
            return $query->where('brand', 'like', "%{$search}%")
                         ->orWhere('model_name', 'like', "%{$search}%");
        })->paginate(3); // Shows 3 items per page

        return view('guitars.index', compact('guitars'));
    }

    public function create() { return view('guitars.create'); }

    // BONUS: Validation & Image Upload
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'model_name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' 
        ]);

        $data = $request->all();

        // Handle Image Saving
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/guitars'), $filename);
            $data['image'] = $filename;
        }

        Guitar::create($data);
        return redirect()->route('guitars.index')->with('success', 'Guitar added successfully!');
    }

    public function show(Guitar $guitar) { return view('guitars.show', compact('guitar')); }

    public function edit(Guitar $guitar) { return view('guitars.edit', compact('guitar')); }

    public function update(Request $request, Guitar $guitar)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/guitars'), $filename);
            $data['image'] = $filename;
        }
        $guitar->update($data);
        return redirect()->route('guitars.index')->with('success', 'Guitar updated!');
    }

    public function destroy(Guitar $guitar)
    {
        $guitar->delete();
        return redirect()->route('guitars.index')->with('success', 'Guitar deleted!');
    }
}