@extends('layouts.teacher.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-user"></i> My Profile</h2>
            <p class="text-muted">View and update your profile information</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 2.5rem;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $teacher->department ?? 'Teacher' }}</p>
                    <p class="text-muted"><small>{{ $teacher->teacher_id }}</small></p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Email:</strong>
                            <p>{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Department:</strong>
                            <p>{{ $teacher->department ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Qualification:</strong>
                            <p>{{ $teacher->qualification ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Experience:</strong>
                            <p>{{ $teacher->experience ?? 0 }} years</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Gender:</strong>
                            <p>{{ ucfirst($teacher->gender ?? 'N/A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong>
                            <p><span class="badge bg-success">{{ ucfirst($teacher->status) }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection
