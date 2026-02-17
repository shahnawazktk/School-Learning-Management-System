@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid p-4">
    @php
        $totalSubjects = $enrollments->count();
        $pendingCount = $pendingAssignments->count();
        $recentSubmissionsCount = $recentSubmissions->count();
        $completionRate = $pendingCount + $recentSubmissionsCount > 0
            ? round(($recentSubmissionsCount / ($pendingCount + $recentSubmissionsCount)) * 100, 1)
            : 0;
    @endphp

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(120deg, #0d6efd 0%, #0dcaf0 100%);">
                <div class="card-body text-white p-4 p-lg-5">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <h2 class="mb-2 fw-bold">Welcome back, {{ Auth::user()->name }}</h2>
                            <p class="mb-3 opacity-75">Track your classes, assignments, attendance, and academic progress from one dashboard.</p>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('student.assignments') }}" class="btn btn-light btn-sm fw-semibold">
                                    <i class="fas fa-tasks me-1"></i>Assignments
                                </a>
                                <a href="{{ route('student.subjects') }}" class="btn btn-outline-light btn-sm fw-semibold">
                                    <i class="fas fa-book-open me-1"></i>Subjects
                                </a>
                                <a href="{{ route('student.resources') }}" class="btn btn-outline-light btn-sm fw-semibold">
                                    <i class="fas fa-folder-open me-1"></i>Resources
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-5 mt-4 mt-lg-0">
                            <div class="row g-3 text-center">
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                                        <h4 class="mb-1 fw-bold">{{ $attendancePercentage }}%</h4>
                                        <small>Attendance</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                                        <h4 class="mb-1 fw-bold">{{ number_format($averageGrade, 1) }}%</h4>
                                        <small>Avg. Grade</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                                        <h4 class="mb-1 fw-bold">{{ $totalSubjects }}</h4>
                                        <small>Subjects</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                                        <h4 class="mb-1 fw-bold">{{ $pendingCount }}</h4>
                                        <small>Pending Tasks</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-2">Completion</small>
                    <h4 class="fw-bold mb-1">{{ $completionRate }}%</h4>
                    <div class="progress" style="height: 7px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $completionRate }}%" aria-valuenow="{{ $completionRate }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-2">Pending Assignments</small>
                    <h4 class="fw-bold mb-0">{{ $pendingCount }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-2">Recent Submissions</small>
                    <h4 class="fw-bold mb-0">{{ $recentSubmissionsCount }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <small class="text-muted d-block mb-2">Academic Score</small>
                    <h4 class="fw-bold mb-0">{{ number_format($averageGrade, 1) }}%</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-hourglass-half me-2 text-warning"></i>Upcoming Deadlines</h5>
                    <a href="{{ route('student.assignments') }}" class="btn btn-outline-primary btn-sm">All</a>
                </div>
                <div class="card-body">
                    @if($pendingCount > 0)
                        <div class="list-group list-group-flush">
                            @foreach($pendingAssignments as $assignment)
                                @php
                                    $dueDate = $assignment->due_date;
                                    $daysLeft = $dueDate ? now()->diffInDays($dueDate, false) : null;
                                @endphp
                                <div class="list-group-item px-0 py-3">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">{{ $assignment->title }}</h6>
                                            <small class="text-muted d-block">{{ $assignment->course->title ?? 'N/A' }}</small>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ $dueDate ? $dueDate->format('M d, Y h:i A') : 'No due date' }}
                                            </small>
                                        </div>
                                        @if(!is_null($daysLeft))
                                            <span class="badge {{ $daysLeft < 0 ? 'bg-danger' : ($daysLeft <= 2 ? 'bg-warning text-dark' : 'bg-primary') }}">
                                                {{ $daysLeft < 0 ? 'Overdue' : ($daysLeft === 0 ? 'Due Today' : $daysLeft . 'd left') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-check fa-3x text-success mb-3"></i>
                            <p class="text-muted mb-0">No pending assignments right now.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-check-circle me-2 text-success"></i>Submission Activity</h5>
                    <a href="{{ route('student.assignments') }}" class="btn btn-outline-primary btn-sm">Open</a>
                </div>
                <div class="card-body">
                    @if($recentSubmissionsCount > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentSubmissions as $submission)
                                <div class="list-group-item px-0 py-3">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">{{ $submission->assignment->title ?? 'N/A' }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>{{ optional($submission->submitted_at ?? $submission->created_at)->format('M d, Y h:i A') ?? 'N/A' }}
                                            </small>
                                        </div>
                                        @if(!is_null($submission->marks_obtained))
                                            <span class="badge bg-success">{{ $submission->marks_obtained }}/{{ $submission->assignment->max_marks ?? 100 }}</span>
                                        @else
                                            <span class="badge bg-secondary">Under Review</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No submissions yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-book-open me-2 text-primary"></i>Enrolled Subjects</h5>
                    <a href="{{ route('student.subjects') }}" class="btn btn-primary btn-sm">View All</a>
                </div>
                <div class="card-body">
                    @if($totalSubjects > 0)
                        <div class="row g-3">
                            @foreach($enrollments as $enrollment)
                                <div class="col-md-4">
                                    @php
                                        $status = strtolower((string) $enrollment->status);
                                        $badgeClass = $status === 'completed' ? 'bg-success' : ($status === 'dropped' ? 'bg-danger' : 'bg-primary');
                                    @endphp
                                    <div class="card border h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title mb-0">{{ $enrollment->course->title ?? $enrollment->subject->name ?? 'N/A' }}</h6>
                                                <span class="badge {{ $badgeClass }}">{{ ucfirst($enrollment->status) }}</span>
                                            </div>
                                            <p class="card-text text-muted small mb-3">
                                                @if($enrollment->subject)
                                                    <i class="fas fa-code me-1"></i>Code: {{ $enrollment->subject->code }}<br>
                                                    <i class="fas fa-star me-1"></i>Credits: {{ $enrollment->subject->credits }}
                                                @endif
                                            </p>
                                            <a href="{{ route('student.subjects') }}" class="btn btn-outline-primary btn-sm">Open Subject</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No enrollments found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
