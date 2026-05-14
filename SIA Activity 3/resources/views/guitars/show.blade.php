<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<div class="container mt-5">
    <div class="card p-5 shadow">
        <h1>{{ $guitar->brand }} - {{ $guitar->model_name }}</h1>
        <hr>
        <p><strong>Category:</strong> {{ $guitar->guitar_type }}</p>
        <p><strong>Price:</strong> ₱{{ number_format($guitar->price, 2) }}</p>
        <p><strong>In Stock:</strong> {{ $guitar->stock_quantity }} units</p>
        <a href="{{ route('guitars.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>
</div>