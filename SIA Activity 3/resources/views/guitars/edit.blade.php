<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<div class="container mt-5">
    <div class="card p-4 shadow mx-auto" style="max-width: 600px; border-top: 5px solid #ffc107;">
        <h3>Edit Guitar: {{ $guitar->brand }}</h3>
        <p class="text-muted">Update the details or photo for this timepiece.</p>
        
        <!-- BONUS: VALIDATION ERRORS -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guitars.update', $guitar->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Critical for Update routes -->

            <div class="mb-2">
                <label class="form-label fw-bold">Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand', $guitar->brand) }}">
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold">Model Name</label>
                <input type="text" name="model_name" class="form-control" value="{{ old('model_name', $guitar->model_name) }}">
            </div>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-bold">Price (₱)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $guitar->price) }}">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-bold">Stock Quantity</label>
                    <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $guitar->stock_quantity) }}">
                </div>
            </div>

            <!-- BONUS: IMAGE UPDATE SECTION -->
            <div class="mb-3 mt-3 p-3 border rounded bg-light">
                <label class="form-label fw-bold">Guitar Photo</label>
                @if($guitar->image)
                    <div class="mb-2">
                        <small class="text-muted d-block">Current Photo:</small>
                        <img src="{{ asset('uploads/guitars/' . $guitar->image) }}" width="100" class="rounded border shadow-sm">
                    </div>
                @endif
                <input type="file" name="image" class="form-control">
                <small class="text-muted">Leave blank to keep the current photo.</small>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-warning fw-bold text-dark">Update Timepiece</button>
                <a href="{{ route('guitars.index') }}" class="btn btn-outline-secondary">Cancel and Back</a>
            </div>
        </form>
    </div>
</div>