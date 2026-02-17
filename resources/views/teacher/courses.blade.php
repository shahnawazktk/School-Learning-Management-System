@extends('layouts.teacher.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-chalkboard-teacher"></i> My Courses</h2>
            <p class="text-muted">Manage your courses and enrolled students</p>
        </div>
    </div>

    <div class="row">
        @forelse($courses as $course)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title">{{ $course->name }}</h5>
                        <span class="badge bg-primary">{{ $course->code }}</span>
                    </div>
                    
                    <p class="text-muted mb-3">
                        <i class="fas fa-book"></i> {{ $course->subject->name ?? 'N/A' }}
                    </p>
                    
                    <div class="d-flex justify-content-between text-center border-top pt-3">
                        <div>
                            <h6 class="mb-0">{{ $course->enrollments_count }}</h6>
                            <small class="text-muted">Students</small>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $course->assignments_count }}</h6>
                            <small class="text-muted">Assignments</small>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $course->credits ?? 3 }}</h6>
                            <small class="text-muted">Credits</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No courses assigned yet.
            </div>
        </div>
        @endforelse
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection
