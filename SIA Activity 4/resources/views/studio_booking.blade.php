<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .card { border-radius: 15px; border: none; }
        .btn-submit { background-color: #6c5ce7; color: white; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg p-4">
                <h3 class="text-center mb-4">🎙️ Record Studio Booking</h3>

                <!-- Success Message Bonus -->
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Show All Errors (Summary) -->
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf <!-- CSRF Protection -->

                    <!-- 1. Text Field -->
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="client_name" class="form-control" value="{{ old('client_name') }}">
                        @error('client_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- 2. Email Field -->
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="text" name="client_email" class="form-control" value="{{ old('client_email') }}">
                        @error('client_email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="row">
                        <!-- 3. Date Field -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Session Date</label>
                            <input type="date" name="session_date" class="form-control" value="{{ old('session_date') }}">
                        </div>
                        <!-- 4. Number Field -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hours</label>
                            <input type="number" name="duration" class="form-control" value="{{ old('duration') }}">
                        </div>
                    </div>

                    <!-- 5. Select Dropdown -->
                    <div class="mb-3">
                        <label class="form-label">Studio Room</label>
                        <select name="studio_room" class="form-control">
                            <option value="">-- Select Room --</option>
                            <option value="A" {{ old('studio_room') == 'A' ? 'selected' : '' }}>Main Hall (Room A)</option>
                            <option value="B" {{ old('studio_room') == 'B' ? 'selected' : '' }}>Vocal Booth (Room B)</option>
                            <option value="C" {{ old('studio_room') == 'C' ? 'selected' : '' }}>Mixing Suite (Room C)</option>
                        </select>
                    </div>

                    <!-- 6. Textarea -->
                    <div class="mb-3">
                        <label class="form-label">Special Requirements</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-submit w-100 py-2 mt-2">Confirm Reservation</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>