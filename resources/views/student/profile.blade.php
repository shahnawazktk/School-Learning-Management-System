@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid p-4">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="fas fa-user fa-3x text-primary"></i>
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $student->student_id }}</p>
                    <span class="badge bg-success">{{ ucfirst($student->status) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">Full Name</small>
                            <p class="mb-0"><strong>{{ $user->name }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Email</small>
                            <p class="mb-0"><strong>{{ $user->email }}</strong></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">Student ID</small>
                            <p class="mb-0"><strong>{{ $student->student_id }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Class</small>
                            <p class="mb-0"><strong>{{ $student->class }} - {{ $student->section }}</strong></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">Roll Number</small>
                            <p class="mb-0"><strong>{{ $student->roll_number }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Academic Year</small>
                            <p class="mb-0"><strong>{{ $student->academic_year }}</strong></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">Date of Birth</small>
                            <p class="mb-0"><strong>{{ $student->date_of_birth ? $student->date_of_birth->format('M d, Y') : 'N/A' }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Gender</small>
                            <p class="mb-0"><strong>{{ ucfirst($student->gender ?? 'N/A') }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <small class="text-muted">Address</small>
                            <p class="mb-0"><strong>{{ $student->address ?? 'N/A' }}</strong></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <small class="text-muted">City</small>
                            <p class="mb-0"><strong>{{ $student->city ?? 'N/A' }}</strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">State</small>
                            <p class="mb-0"><strong>{{ $student->state ?? 'N/A' }}</strong></p>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Zip Code</small>
                            <p class="mb-0"><strong>{{ $student->zip_code ?? 'N/A' }}</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <small class="text-muted">Emergency Contact</small>
                            <p class="mb-0"><strong>{{ $student->emergency_contact ?? 'N/A' }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
