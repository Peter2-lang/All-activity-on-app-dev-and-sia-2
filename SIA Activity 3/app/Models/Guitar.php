<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guitar extends Model
{
    // Allows these fields to be saved to the database
    protected $fillable = ['brand', 'model_name', 'guitar_type', 'price', 'stock_quantity', 'image'];
}