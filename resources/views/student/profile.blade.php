@extends('layouts.student.app')

@push('styles')
<style>
    .profile-hero {
        background: linear-gradient(120deg, #0d6efd, #0dcaf0);
        color: #fff;
        border: 0;
    }

    .profile-avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.18);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        overflow: hidden;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .info-label {
        color: #667085;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: .02em;
        margin-bottom: .2rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="card profile-hero shadow-sm mb-4">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center g-3">
                <div class="col-auto">
                    <div class="profile-avatar">
                        @if(!empty($student->profile_image))
                            <img src="{{ asset('storage/' . $student->profile_image) }}" alt="Profile image">
                        @else
                            {{ strtoupper(substr($user->name ?? 'ST', 0, 2)) }}
                        @endif
                    </div>
                </div>
                <div class="col">
                    <h3 class="mb-1 fw-bold">{{ $user->name }}</h3>
                    <p class="mb-2 opacity-75">{{ $user->email }}</p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge text-bg-light">Student ID: {{ $student->student_id ?? 'N/A' }}</span>
                        <span class="badge text-bg-light">Class: {{ $student->class ?? 'N/A' }} - {{ $student->section ?? 'N/A' }}</span>
                        <span class="badge text-bg-light">Status: {{ ucfirst($student->status ?? 'N/A') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-xl-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Academic Profile</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="info-label">Roll Number</div>
                        <div class="fw-semibold">{{ $student->roll_number ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">Academic Year</div>
                        <div class="fw-semibold">{{ $student->academic_year ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label">Date of Birth</div>
                        <div class="fw-semibold">
                            {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') : 'N/A' }}
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="info-label">Gender</div>
                        <div class="fw-semibold">{{ $student->gender ? ucfirst($student->gender) : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Contact & Address Information</h5>
                    <span class="badge text-bg-primary">Editable</span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="profile_image" class="form-label">Profile Image</label>
                                <input
                                    type="file"
                                    id="profile_image"
                                    name="profile_image"
                                    accept="image/png,image/jpeg,image/jpg,image/webp"
                                    class="form-control @error('profile_image') is-invalid @enderror">
                                <div class="form-text">Allowed: JPG, PNG, WEBP. Max size 2MB.</div>
                                @error('profile_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea
                                    id="address"
                                    name="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    rows="3"
                                    placeholder="House no, street, area">{{ old('address', $student->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="city" class="form-label">City</label>
                                <input
                                    type="text"
                                    id="city"
                                    name="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city', $student->city) }}"
                                    placeholder="City">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="state" class="form-label">State</label>
                                <input
                                    type="text"
                                    id="state"
                                    name="state"
                                    class="form-control @error('state') is-invalid @enderror"
                                    value="{{ old('state', $student->state) }}"
                                    placeholder="State">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="zip_code" class="form-label">Zip Code</label>
                                <input
                                    type="text"
                                    id="zip_code"
                                    name="zip_code"
                                    class="form-control @error('zip_code') is-invalid @enderror"
                                    value="{{ old('zip_code', $student->zip_code) }}"
                                    placeholder="Zip Code">
                                @error('zip_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="emergency_contact" class="form-label">Emergency Contact</label>
                                <input
                                    type="text"
                                    id="emergency_contact"
                                    name="emergency_contact"
                                    class="form-control @error('emergency_contact') is-invalid @enderror"
                                    value="{{ old('emergency_contact', $student->emergency_contact) }}"
                                    placeholder="Name and phone number">
                                @error('emergency_contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
