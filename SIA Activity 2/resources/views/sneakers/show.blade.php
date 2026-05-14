@extends('layouts.app')

@section('content')
    <h2>Sneaker Specifications</h2>
    
    <div style="background: #2a2a2a; padding: 20px; border-radius: 8px;">
        <p><strong>Name:</strong> {{ $item['name'] }}</p>
        <p><strong>Brand:</strong> {{ $item['brand'] }}</p>
        <p><strong>Release Year:</strong> {{ $item['year'] }}</p>
        <p><strong>Market Value:</strong> <span style="color: #00ff00;">{{ $item['value'] }}</span></p>
        <p><strong>Description:</strong> {{ $item['desc'] }}</p>
    </div>

    <a href="{{ route('sneakers.index') }}" class="btn">← Back to List</a>
@endsection