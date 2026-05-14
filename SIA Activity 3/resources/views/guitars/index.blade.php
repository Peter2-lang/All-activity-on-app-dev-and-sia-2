<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2>🎸 Guitar Inventory</h2>
        <a href="{{ route('guitars.create') }}" class="btn btn-primary">Add New Guitar</a>
    </div>

    <!-- BONUS: SEARCH BAR -->
    <form action="{{ route('guitars.index') }}" method="GET" class="d-flex mt-3">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search brand or model...">
        <button type="submit" class="btn btn-dark">Search</button>
    </form>
    
    <table class="table table-bordered mt-3 align-middle bg-white shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Photo</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guitars as $g)
            <tr>
                <td>
                    @if($g->image)
                        <img src="{{ asset('uploads/guitars/' . $g->image) }}" width="60" height="60" style="object-fit: cover;" class="rounded border">
                    @else
                        <div class="bg-light text-center py-2 text-muted" style="width:60px; font-size:10px;">No Image</div>
                    @endif
                </td>
                <td>{{ $g->brand }}</td>
                <td>{{ $g->model_name }}</td>
                <td>
                    <a href="{{ route('guitars.show', $g->id) }}" class="btn btn-sm btn-info text-white">View</a>
                    <a href="{{ route('guitars.edit', $g->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('guitars.destroy', $g->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">No results found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- BONUS: PAGINATION -->
    <div class="d-flex justify-content-center mt-4">
        {{ $guitars->appends(['search' => request('search')])->links() }}
    </div>
</div>