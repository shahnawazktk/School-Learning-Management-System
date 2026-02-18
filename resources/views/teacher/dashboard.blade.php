@extends('layouts.teacher.app')
@section('page_title', 'Dashboard')

@section('content')
<style>
    .teacher-dashboard .teacher-section-card {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    .teacher-dashboard .teacher-section-card .card-header {
        background: #fff;
        border-bottom: 1px solid #e2e8f0;
        padding-top: .9rem;
        padding-bottom: .9rem;
    }
    .teacher-dashboard .teacher-section-card .table thead th {
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #64748b;
        border-bottom-color: #e2e8f0;
        background: #f8fafc;
    }
    .teacher-dashboard .teacher-section-card .table td {
        border-color: #edf2f7;
    }
    .teacher-dashboard .teacher-stat-card {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.03);
    }
    .teacher-dashboard .teacher-stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
    }
    .teacher-dashboard.is-compact .teacher-section-card .card-header {
        padding-top: .6rem;
        padding-bottom: .6rem;
    }
    .teacher-dashboard.is-compact .teacher-section-card .table > :not(caption) > * > * {
        padding-top: .45rem;
        padding-bottom: .45rem;
        font-size: .9rem;
    }
    .teacher-dashboard.is-compact .teacher-section-card .list-group-item {
        padding-top: .55rem !important;
        padding-bottom: .55rem !important;
    }
    .teacher-dashboard.is-compact .teacher-stat-card .card-body {
        padding-top: .75rem;
        padding-bottom: .75rem;
    }
</style>

<div class="container-fluid p-1 p-lg-2 teacher-dashboard">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(120deg, #0b3a8f 0%, #2563eb 58%, #0ea5e9 100%);">
                <div class="card-body text-white p-4 p-lg-5">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <h2 class="mb-2 fw-bold">Welcome back, {{ auth()->user()->name }}</h2>
                            <p class="mb-3 opacity-75">Manage courses, grade submissions, and track your classroom performance from one dashboard.</p>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('teacher.assignments') }}" class="btn btn-light btn-sm fw-semibold">
                                    <i class="fas fa-tasks me-1"></i>Assignments
                                </a>
                                <a href="{{ route('teacher.submissions') }}" class="btn btn-outline-light btn-sm fw-semibold">
                                    <i class="fas fa-file-lines me-1"></i>Submissions
                                </a>
                                <a href="{{ route('teacher.attendance') }}" class="btn btn-outline-light btn-sm fw-semibold">
                                    <i class="fas fa-calendar-check me-1"></i>Attendance
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-5 mt-4 mt-lg-0">
                            <div class="row g-3 text-center">
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                                        <h4 class="mb-1 fw-bold">{{ $courses->count() }}</h4>
                                        <small>Courses</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                                        <h4 class="mb-1 fw-bold">{{ $totalStudents }}</h4>
                                        <small>Students</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                                        <h4 class="mb-1 fw-bold">{{ $gradedInPeriod }}</h4>
                                        <small>Graded ({{ $periodLabel }})</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                                        <h4 class="mb-1 fw-bold">{{ $overdueGrading }}</h4>
                                        <small>Overdue Review</small>
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
        <div class="col-12">
            <div class="card teacher-section-card">
                <div class="card-body">
                    <form method="GET" action="{{ route('teacher.dashboard') }}" class="row g-3 align-items-end">
                        <div class="col-12 d-flex justify-content-end">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Density Toggle">
                                <button type="button" id="densityComfortableBtn" class="btn btn-outline-secondary active">Comfortable</button>
                                <button type="button" id="densityCompactBtn" class="btn btn-outline-secondary">Compact</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold mb-1">Time Range</label>
                            <select name="period" class="form-select">
                                <option value="today" {{ $selectedPeriod === 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ $selectedPeriod === 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ $selectedPeriod === 'month' ? 'selected' : '' }}>This Month</option>
                                <option value="all" {{ $selectedPeriod === 'all' ? 'selected' : '' }}>All Time</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold mb-1">Course</label>
                            <select name="course_id" class="form-select">
                                <option value="">All Courses</option>
                                @foreach($courseOptions as $option)
                                    <option value="{{ $option->id }}" {{ (int) $selectedCourseId === (int) $option->id ? 'selected' : '' }}>
                                        {{ $option->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-1"></i>Apply
                            </button>
                            <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-secondary w-100">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3 mb-md-0">
            <div class="card teacher-stat-card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block mb-2">Active Courses</small>
                        <h4 class="fw-bold mb-0">{{ $courses->count() }}</h4>
                    </div>
                    <span class="teacher-stat-icon bg-primary-subtle text-primary"><i class="fas fa-book-open"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3 mb-md-0">
            <div class="card teacher-stat-card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block mb-2">Enrolled Students</small>
                        <h4 class="fw-bold mb-0">{{ $totalStudents }}</h4>
                    </div>
                    <span class="teacher-stat-icon bg-success-subtle text-success"><i class="fas fa-users"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card teacher-stat-card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block mb-2">Pending Reviews</small>
                        <h4 class="fw-bold mb-0">{{ $pendingSubmissions }}</h4>
                    </div>
                    <span class="teacher-stat-icon bg-warning-subtle text-warning"><i class="fas fa-clipboard-check"></i></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card teacher-stat-card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <small class="text-muted d-block mb-2">Overdue Grading</small>
                        <h4 class="fw-bold mb-0 text-danger">{{ $overdueGrading }}</h4>
                    </div>
                    <span class="teacher-stat-icon bg-danger-subtle text-danger"><i class="fas fa-triangle-exclamation"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div class="card teacher-section-card h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-book-open me-2 text-primary"></i>My Courses</h5>
                    <a href="{{ route('teacher.courses') }}" class="btn btn-outline-primary btn-sm">View All</a>
                </div>
                <div class="card-body p-0">
                    @if($courses->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No courses assigned.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Course</th>
                                        <th>Students</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td class="fw-semibold">{{ $course->title }}</td>
                                            <td><span class="badge text-bg-light">{{ $course->enrollments_count }}</span></td>
                                            <td class="text-end">
                                                <a href="{{ route('teacher.assignments') }}" class="btn btn-sm btn-outline-secondary">Open</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card teacher-section-card h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-clipboard-list me-2 text-success"></i>Recent Assignments</h5>
                    <a href="{{ route('teacher.assignments') }}" class="btn btn-outline-success btn-sm">Open</a>
                </div>
                <div class="card-body">
                    @if($recentAssignments->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No recent assignments.</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($recentAssignments as $assignment)
                                <div class="list-group-item px-0 py-3">
                                    <div class="d-flex justify-content-between align-items-start gap-3">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">{{ $assignment->title }}</h6>
                                            <small class="text-muted d-block">{{ $assignment->course->title ?? 'N/A' }}</small>
                                        </div>
                                        <span class="badge bg-primary">
                                            Due: {{ optional($assignment->due_date)->format('M d') ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div class="card teacher-section-card h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-check-double me-2 text-danger"></i>Grading Queue</h5>
                    <a href="{{ route('teacher.submissions') }}" class="btn btn-outline-danger btn-sm">Grade Center</a>
                </div>
                <div class="card-body p-0">
                    @if($gradingQueue->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-circle-check fa-3x text-success mb-3"></i>
                            <p class="text-muted mb-0">No pending submissions right now.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Student</th>
                                        <th>Task</th>
                                        <th>Due</th>
                                        <th>Submitted</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gradingQueue as $submission)
                                        @php
                                            $dueDate = optional($submission->assignment)->due_date;
                                            $isLateForReview = $dueDate && $dueDate->isPast();
                                        @endphp
                                        <tr>
                                            <td class="fw-semibold">{{ optional(optional($submission->student)->user)->name ?? 'N/A' }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ optional($submission->assignment)->title ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ optional(optional($submission->assignment)->course)->title ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                @if($dueDate)
                                                    <span class="badge {{ $isLateForReview ? 'bg-danger' : 'bg-secondary' }}">{{ $dueDate->format('M d, Y') }}</span>
                                                @else
                                                    <span class="badge bg-light text-dark">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ optional($submission->submitted_at)->format('M d, h:i A') ?? 'N/A' }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('teacher.submissions') }}" class="btn btn-sm btn-outline-primary">Review</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card teacher-section-card h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-calendar-days me-2 text-primary"></i>Academic Calendar (14 Days)</h5>
                </div>
                <div class="card-body">
                    @if($calendarItems->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-plus fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No events in the next 14 days.</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($calendarItems as $item)
                                <div class="list-group-item px-0 py-3">
                                    <div class="d-flex align-items-start gap-3">
                                        <span class="badge text-bg-{{ $item['badge'] }} mt-1"><i class="fas {{ $item['icon'] }}"></i></span>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold">{{ $item['title'] }}</div>
                                            <small class="text-muted d-block">{{ $item['type'] }}{{ $item['course'] ? ' | '.$item['course'] : '' }}</small>
                                        </div>
                                        <small class="fw-semibold text-nowrap">{{ \Illuminate\Support\Carbon::parse($item['date'])->format('M d') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-12">
            <div class="card teacher-section-card">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2 text-success"></i>Course Performance Snapshot</h5>
                    <a href="{{ route('teacher.courses') }}" class="btn btn-outline-success btn-sm">Manage Courses</a>
                </div>
                <div class="card-body p-0">
                    @if($coursePerformance->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-chart-simple fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No course analytics available.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Course</th>
                                        <th>Students</th>
                                        <th>Pending Grading</th>
                                        <th>Class Average</th>
                                        <th class="text-end">Health</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coursePerformance as $course)
                                        @php
                                            $avg = $course->avg_percentage;
                                            $healthClass = is_null($avg) ? 'secondary' : ($avg >= 80 ? 'success' : ($avg >= 60 ? 'warning text-dark' : 'danger'));
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $course->title }}</div>
                                                <small class="text-muted">{{ optional($course->subject)->name ?? 'General' }}</small>
                                            </td>
                                            <td><span class="badge text-bg-light">{{ $course->enrollments_count }}</span></td>
                                            <td>
                                                <span class="badge {{ $course->pending_grading_count > 0 ? 'text-bg-danger' : 'text-bg-success' }}">
                                                    {{ $course->pending_grading_count }}
                                                </span>
                                            </td>
                                            <td>
                                                @if(!is_null($avg))
                                                    <div class="fw-semibold">{{ $avg }}%</div>
                                                    <div class="progress mt-1" style="height: 6px;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ min(100, max(0, $avg)) }}%"></div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Not enough data</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <span class="badge bg-{{ $healthClass }}">
                                                    {{ is_null($avg) ? 'No Grades' : ($avg >= 80 ? 'Strong' : ($avg >= 60 ? 'Watch' : 'At Risk')) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        const densityKey = 'teacher_dashboard_density';
        const root = document.querySelector('.teacher-dashboard');
        const comfortableBtn = document.getElementById('densityComfortableBtn');
        const compactBtn = document.getElementById('densityCompactBtn');
        if (!root || !comfortableBtn || !compactBtn) return;

        const setDensity = (density) => {
            const isCompact = density === 'compact';
            root.classList.toggle('is-compact', isCompact);
            comfortableBtn.classList.toggle('active', !isCompact);
            compactBtn.classList.toggle('active', isCompact);
            try {
                localStorage.setItem(densityKey, density);
            } catch (e) {
                // Ignore localStorage restrictions.
            }
        };

        comfortableBtn.addEventListener('click', () => setDensity('comfortable'));
        compactBtn.addEventListener('click', () => setDensity('compact'));

        let initialDensity = 'comfortable';
        try {
            initialDensity = localStorage.getItem(densityKey) || 'comfortable';
        } catch (e) {
            initialDensity = 'comfortable';
        }

        setDensity(initialDensity === 'compact' ? 'compact' : 'comfortable');
    })();
</script>
@endsection
