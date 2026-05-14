<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SneakerController extends Controller
{
    // Our Dataset (Minimum 5 items, 3+ attributes each)
    private $sneakers = [
        ['id' => 1, 'name' => 'Air Jordan 1 Chicago', 'brand' => 'Nike', 'year' => '1985', 'value' => '₱25,000', 'desc' => 'The shoe that changed basketball history forever.'],
        ['id' => 2, 'name' => 'Adidas Superstar', 'brand' => 'Adidas', 'year' => '1969', 'value' => '₱150', 'desc' => 'Original shell-toe classic worn by Run-D.M.C.'],
        ['id' => 3, 'name' => 'Nike Dunk Wu-Tang', 'brand' => 'Nike', 'year' => '1999', 'value' => '₱30,000', 'desc' => 'Ultra-rare yellow and black high-tops.'],
        ['id' => 4, 'name' => 'New Balance 990v1', 'brand' => 'New Balance', 'year' => '1982', 'value' => '₱200', 'desc' => 'The first running shoe to break the $100 price barrier.'],
        ['id' => 5, 'name' => 'Puma Clyde OG', 'brand' => 'Puma', 'year' => '1973', 'value' => '₱120', 'desc' => 'The first ever signature basketball sneaker.'],
    ];

    public function index()
    {
        return view('sneakers.index', ['items' => $this->sneakers]);
    }

    public function show($id)
    {
        $item = collect($this->sneakers)->firstWhere('id', $id);
        
        if (!$item) abort(404);

        return view('sneakers.show', compact('item'));
    }
}