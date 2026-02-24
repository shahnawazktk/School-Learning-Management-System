@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid py-2">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <h1 class="h3 mb-1">School Profile</h1>
                <p class="text-muted mb-0">Manage core school information displayed across the LMS.</p>
            </div>
            <a href="{{ route('admin.settings') }}" class="btn btn-outline-secondary">
                <i class="fas fa-cog me-1"></i>Account Settings
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <div class="fw-semibold mb-1">Please fix the following errors:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-12 col-lg-4">
                <div class="card admin-card h-100">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 84px; height: 84px;">
                            <i class="fas fa-user-shield fa-2x"></i>
                        </div>
                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-2">{{ auth()->user()->email }}</p>
                        <span class="badge text-bg-primary px-3 py-2 text-uppercase">{{ auth()->user()->role }}</span>

                        <hr>

                        <div class="text-start small">
                            <p class="mb-2">
                                <span class="text-muted">School Record:</span>
                                <span class="fw-semibold">{{ $school ? 'Available' : 'Not created yet' }}</span>
                            </p>
                            <p class="mb-0 text-muted">
                                Use the form to create or update school details. These values are used in admin and reporting screens.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="card admin-card">
                    <div class="card-header bg-white border-bottom-0 pt-3">
                        <h5 class="mb-0">School Details</h5>
                    </div>
                    <div class="card-body pt-3">
                        <form action="{{ route('admin.profile.update') }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="school_name" class="form-label">School Name <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    name="school_name"
                                    id="school_name"
                                    class="form-control @error('school_name') is-invalid @enderror"
                                    value="{{ old('school_name', $school->name ?? '') }}"
                                    placeholder="Enter school name"
                                    required>
                                @error('school_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="school_address" class="form-label">Address</label>
                                <textarea
                                    name="school_address"
                                    id="school_address"
                                    class="form-control @error('school_address') is-invalid @enderror"
                                    rows="3"
                                    placeholder="Enter school address">{{ old('school_address', $school->address ?? '') }}</textarea>
                                @error('school_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="school_contact" class="form-label">Contact Number</label>
                                <input
                                    type="text"
                                    name="school_contact"
                                    id="school_contact"
                                    class="form-control @error('school_contact') is-invalid @enderror"
                                    value="{{ old('school_contact', $school->contact ?? '') }}"
                                    placeholder="e.g. +1 555 123 4567">
                                @error('school_contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i>Save Changes
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-light border">Back to Dashboard</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card admin-card mt-4">
                    <div class="card-header bg-white border-bottom-0 pt-3">
                        <h5 class="mb-0">Recent Notifications</h5>
                    </div>
                    <div class="card-body pt-3">
                        @php($notifications = auth()->user()->notifications->take(5))

                        @if ($notifications->isNotEmpty())
                            <div class="list-group list-group-flush">
                                @foreach ($notifications as $notification)
                                    <div class="list-group-item px-0 {{ $notification->read_at ? '' : 'fw-semibold' }}">
                                        <div class="d-flex justify-content-between gap-2">
                                            <span>{{ $notification->data['message'] ?? 'No message' }}</span>
                                            <small class="text-muted text-nowrap">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">No notifications available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
