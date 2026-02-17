@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid p-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Welcome Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white p-4">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h2 class="mb-2">Welcome back, {{ Auth::user()->name }}!</h2>
                            <p class="mb-0 opacity-75">
                                You have {{ $pendingAssignments->count() }} pending assignments
                                and are enrolled in {{ $enrollments->count() }} subjects.
                                Your attendance is {{ $attendancePercentage }}% this period.
                            </p>
                        </div>
                        <div class="col-lg-4">
                            <div class="row text-center g-3 mt-3 mt-lg-0">
                                <div class="col-4">
                                    <div class="bg-white bg-opacity-25 rounded p-3">
                                        <h3 class="mb-0">{{ $attendancePercentage }}%</h3>
                                        <small>Attendance</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="bg-white bg-opacity-25 rounded p-3">
                                        <h3 class="mb-0">{{ number_format($averageGrade, 1) }}%</h3>
                                        <small>Avg. Grade</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="bg-white bg-opacity-25 rounded p-3">
                                        <h3 class="mb-0">{{ $enrollments->count() }}</h3>
                                        <small>Subjects</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Assignments & Recent Submissions -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Pending Assignments</h5>
                </div>
                <div class="card-body">
                    @if($pendingAssignments->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($pendingAssignments as $assignment)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $assignment->title }}</h6>
                                            <small class="text-muted">{{ $assignment->course->title ?? 'N/A' }}</small>
                                        </div>
                                        <span class="badge bg-warning text-dark">Due: {{ $assignment->due_date->format('M d') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('student.assignments') }}" class="btn btn-primary btn-sm">View All Assignments</a>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No pending assignments</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Recent Submissions</h5>
                </div>
                <div class="card-body">
                    @if($recentSubmissions->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentSubmissions as $submission)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $submission->assignment->title ?? 'N/A' }}</h6>
                                            <small class="text-muted">
                                                Submitted: {{ optional($submission->submitted_at ?? $submission->created_at)->format('M d, Y h:i A') ?? 'N/A' }}
                                            </small>
                                        </div>
                                        @if(!is_null($submission->marks_obtained))
                                            <span class="badge bg-success">{{ $submission->marks_obtained }}/{{ $submission->assignment->max_marks ?? 100 }}</span>
                                        @else
                                            <span class="badge bg-secondary">Pending</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No submissions yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Enrolled Subjects -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-book-open me-2"></i>My Subjects</h5>
                </div>
                <div class="card-body">
                    @if($enrollments->count() > 0)
                        <div class="row g-3">
                            @foreach($enrollments as $enrollment)
                                <div class="col-md-4">
                                    <div class="card border h-100">
                                        <div class="card-body">
                                            <h6 class="card-title mb-2">{{ $enrollment->course->title ?? $enrollment->subject->name ?? 'N/A' }}</h6>
                                            <p class="card-text text-muted small mb-2">
                                                @if($enrollment->subject)
                                                    <i class="fas fa-code me-1"></i>Code: {{ $enrollment->subject->code }}<br>
                                                    <i class="fas fa-star me-1"></i>Credits: {{ $enrollment->subject->credits }}
                                                @endif
                                            </p>
                                            <span class="badge bg-success">{{ ucfirst($enrollment->status) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-4">
                            <a href="{{ route('student.subjects') }}" class="btn btn-primary">View All Subjects</a>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No enrollments found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
