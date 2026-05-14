@extends('layouts.app')

@section('content')
    <h2>Current Collection</h2>
    <p>Select a sneaker to view its value and history:</p>
    
    <ul>
        @foreach($items as $s)
            <li style="margin-bottom: 10px;">
                <strong>{{ $s['name'] }}</strong> — 
                <a href="{{ route('sneakers.show', $s['id']) }}">View Details</a>
            </li>
        @endforeach
    </ul>
@endsection