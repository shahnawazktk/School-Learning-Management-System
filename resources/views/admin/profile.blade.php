@extends('layouts.admin.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Admin Profile</h1>

        <div class="row">
            <!-- Left Column: Admin Info -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Admin Info</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ auth()->user()->profile_photo_url ?? asset('images/default-avatar.png') }}"
                            alt="Admin Avatar" class="rounded-circle mb-3" width="120">
                        <h5>{{ auth()->user()->name }}</h5>
                        <p>{{ auth()->user()->email }}</p>
                        <p>Role: {{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: School Info & Actions -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>School Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- School Name -->
                            <div class="mb-3">
                                <label for="school_name" class="form-label">School Name</label>
                                <input type="text" name="school_name" id="school_name" class="form-control"
                                    value="{{ old('school_name', $school->name ?? '') }}" required>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="school_address" class="form-label">Address</label>
                                <textarea name="school_address" id="school_address" class="form-control" rows="2" required>{{ old('school_address', $school->address ?? '') }}</textarea>
                            </div>

                            <!-- Contact -->
                            <div class="mb-3">
                                <label for="school_contact" class="form-label">Contact Number</label>
                                <input type="text" name="school_contact" id="school_contact" class="form-control"
                                    value="{{ old('school_contact', $school->contact ?? '') }}" required>
                            </div>

                            <!-- Actions -->
                            <button type="submit" class="btn btn-primary">Update School Info</button>
                            <a href="#" class="btn btn-warning ms-2">Change Password</a>
                        </form>
                    </div>
                </div>

                <!-- Notifications Preview -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Recent Notifications</h5>
                    </div>
                    <div class="card-body">
                        @if (auth()->user()->notifications->count() > 0)
                            <ul class="list-group">
                                @foreach (auth()->user()->notifications->take(5) as $notification)
                                    <li class="list-group-item {{ $notification->read_at ? '' : 'fw-bold' }}">
                                        {{ $notification->data['message'] ?? 'No message' }}
                                        <small
                                            class="text-muted float-end">{{ $notification->created_at->diffForHumans() }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No notifications yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
