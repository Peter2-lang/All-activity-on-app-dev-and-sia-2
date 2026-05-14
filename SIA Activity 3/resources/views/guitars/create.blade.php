<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<div class="container mt-5">
    <div class="card p-4 shadow mx-auto" style="max-width: 600px;">
        <h3>Add New Guitar</h3>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
            </div>
        @endif

        <form action="{{ route('guitars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-2"><label>Brand</label><input type="text" name="brand" class="form-control" value="{{ old('brand') }}"></div>
            <div class="mb-2"><label>Model Name</label><input type="text" name="model_name" class="form-control" value="{{ old('model_name') }}"></div>
            <div class="mb-2"><label>Price</label><input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}"></div>
            <div class="mb-2"><label>Stock Quantity</label><input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity') }}"></div>
            
            <!-- BONUS: IMAGE UPLOAD -->
            <div class="mb-3">
                <label class="form-label fw-bold">Guitar Photo</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-success w-100">Save Timepiece</button>
            <a href="{{ route('guitars.index') }}" class="btn btn-link d-block text-center mt-2">Back to List</a>
        </form>
    </div>
</div>