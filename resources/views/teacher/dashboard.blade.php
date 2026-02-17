@extends('layouts.teacher.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid p-4">
    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white p-4">
                    <h2 class="mb-2">Welcome back, {{ Auth::user()->name }}!</h2>
                    <p class="mb-0 opacity-75">You have {{ $courses->count() }} courses and {{ $pendingSubmissions }} pending submissions to grade.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-primary">{{ $courses->count() }}</h2>
                    <p class="text-muted mb-0">Total Courses</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-success">{{ $totalStudents }}</h2>
                    <p class="text-muted mb-0">Total Students</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-warning">{{ $pendingSubmissions }}</h2>
                    <p class="text-muted mb-0">Pending Grading</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h2 class="text-info">{{ $recentAssignments->count() }}</h2>
                    <p class="text-muted mb-0">Recent Assignments</p>
                </div>
            </div>
        </div>
    </div>

    <!-- My Courses -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-book me-2"></i>My Courses</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($courses as $course)
                            <div class="col-md-4 mb-3">
                                <div class="card border">
                                    <div class="card-body">
                                        <h6>{{ $course->title }}</h6>
                                        <p class="text-muted small mb-2">{{ $course->subject->name ?? 'N/A' }}</p>
                                        <div class="d-flex justify-content-between">
                                            <small><i class="fas fa-users me-1"></i>{{ $course->enrollments_count }} Students</small>
                                            <small><i class="fas fa-tasks me-1"></i>{{ $course->assignments_count }} Assignments</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center">No courses assigned</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Assignments -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Recent Assignments</h5>
                </div>
                <div class="card-body">
                    @forelse($recentAssignments as $assignment)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <h6 class="mb-1">{{ $assignment->title }}</h6>
                                <small class="text-muted">{{ $assignment->course->title ?? 'N/A' }}</small>
                            </div>
                            <span class="badge bg-primary">Due: {{ $assignment->due_date->format('M d') }}</span>
                        </div>
                    @empty
                        <p class="text-muted text-center">No recent assignments</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
