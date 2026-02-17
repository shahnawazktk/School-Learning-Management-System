@extends('layouts.teacher.app')
@section('page_title', 'My Profile')

@section('content')
<div class="container-fluid px-0">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Profile update failed.</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    @if(!empty($teacher->profile_image))
                        <img src="{{ asset('storage/' . $teacher->profile_image) }}" alt="Teacher Profile" class="rounded-circle mb-3" style="width:120px; height:120px; object-fit:cover;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width:120px; height:120px; font-size:2.1rem; font-weight:700;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-1">{{ $teacher->department ?? 'Teacher' }}</p>
                    <p class="text-muted small mb-3">{{ $teacher->teacher_id }}</p>
                    <span class="badge bg-success">{{ ucfirst((string) ($teacher->status ?? 'active')) }}</span>
                    <hr>
                    <div class="text-start small">
                        <div class="mb-2"><strong>Email:</strong> {{ $user->email }}</div>
                        <div class="mb-2"><strong>Qualification:</strong> {{ $teacher->qualification ?? 'N/A' }}</div>
                        <div><strong>Experience:</strong> {{ $teacher->experience ?? 0 }} years</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-user-pen me-2 text-primary"></i>Update Profile</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('teacher.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                <input type="text" name="department" class="form-control" value="{{ old('department', $teacher->department) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Qualification</label>
                                <input type="text" name="qualification" class="form-control" value="{{ old('qualification', $teacher->qualification) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Experience (Years)</label>
                                <input type="number" name="experience" min="0" class="form-control" value="{{ old('experience', $teacher->experience) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="profile_image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address', $teacher->address) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $teacher->city) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" value="{{ old('state', $teacher->state) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">ZIP Code</label>
                                <input type="text" name="zip_code" class="form-control" value="{{ old('zip_code', $teacher->zip_code) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Emergency Contact</label>
                                <input type="text" name="emergency_contact" class="form-control" value="{{ old('emergency_contact', $teacher->emergency_contact) }}">
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
