@extends('layouts.teacher.app')
@section('page_title', 'My Courses')

@section('content')
<div class="container-fluid p-1 p-lg-2">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(130deg, #0f172a 0%, #2563eb 55%, #0ea5e9 100%);">
                <div class="card-body p-4 p-lg-5 text-white">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                        <div>
                            <h2 class="fw-bold mb-2"><i class="fas fa-layer-group me-2"></i>Courses Hub</h2>
                            <p class="mb-0 opacity-75">Track teaching load, grading queue, and assignment flow across all your classes.</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('teacher.assignments') }}" class="btn btn-light btn-sm fw-semibold">
                                <i class="fas fa-clipboard-list me-1"></i>Assignments
                            </a>
                            <a href="{{ route('teacher.submissions') }}" class="btn btn-outline-light btn-sm fw-semibold">
                                <i class="fas fa-check-double me-1"></i>Grade Center
                            </a>
                        </div>
                    </div>
                    <div class="row g-3 mt-3">
                        <div class="col-6 col-lg-2">
                            <div class="bg-white bg-opacity-25 rounded-3 p-3 text-center h-100">
                                <div class="h4 mb-0 fw-bold">{{ $totalCourses }}</div>
                                <small>Courses</small>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="bg-white bg-opacity-25 rounded-3 p-3 text-center h-100">
                                <div class="h4 mb-0 fw-bold">{{ $totalStudents }}</div>
                                <small>Students</small>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="bg-white bg-opacity-25 rounded-3 p-3 text-center h-100">
                                <div class="h4 mb-0 fw-bold">{{ $totalAssignments }}</div>
                                <small>Assignments</small>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="bg-white bg-opacity-25 rounded-3 p-3 text-center h-100">
                                <div class="h4 mb-0 fw-bold">{{ $pendingReviews }}</div>
                                <small>Pending Reviews</small>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="bg-white bg-opacity-25 rounded-3 p-3 text-center h-100">
                                <div class="h4 mb-0 fw-bold">{{ $upcomingDeadlines }}</div>
                                <small>Due in 7 Days</small>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="bg-white bg-opacity-25 rounded-3 p-3 text-center h-100">
                                <div class="h4 mb-0 fw-bold">{{ (int) round($avgGradingCoverage) }}%</div>
                                <small>Grading Coverage</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($courses->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                        <h5 class="fw-semibold">No Courses Assigned Yet</h5>
                        <p class="text-muted mb-0">Once courses are assigned by admin, they will appear here with student and grading analytics.</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row mb-4">
            @foreach($courses as $course)
                @php
                    $coverage = data_get($course->grading_coverage, 'percent', 0);
                    $coverageClass = $coverage >= 75 ? 'success' : ($coverage >= 45 ? 'warning' : 'danger');
                @endphp
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold mb-0">{{ $course->title }}</h5>
                                <span class="badge text-bg-light">{{ $course->subject->name ?? 'General' }}</span>
                            </div>
                            <p class="text-muted small mb-3">Course ID #{{ $course->id }}</p>

                            <div class="row g-2 text-center mb-3">
                                <div class="col-4">
                                    <div class="border rounded-3 py-2">
                                        <div class="fw-bold">{{ $course->enrollments_count }}</div>
                                        <small class="text-muted">Students</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border rounded-3 py-2">
                                        <div class="fw-bold">{{ $course->assignments_count }}</div>
                                        <small class="text-muted">Tasks</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border rounded-3 py-2">
                                        <div class="fw-bold text-{{ $course->pending_reviews > 0 ? 'danger' : 'success' }}">{{ $course->pending_reviews }}</div>
                                        <small class="text-muted">Pending</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2 d-flex justify-content-between">
                                <small class="text-muted">Grading Coverage</small>
                                <small class="fw-semibold">{{ $coverage }}%</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-{{ $coverageClass }}" role="progressbar" style="width: {{ $coverage }}%"></div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-day me-1"></i>{{ $course->upcoming_deadlines }} due in 7 days
                                </small>
                                <a href="{{ route('teacher.assignments') }}" class="btn btn-sm btn-outline-primary">Open</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-table-list me-2 text-primary"></i>Course Operations</h5>
                        <span class="badge text-bg-secondary">{{ $atRiskCourses }} high-load course(s)</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Course</th>
                                    <th>Students</th>
                                    <th>Assignments</th>
                                    <th>Pending Reviews</th>
                                    <th>Upcoming (7d)</th>
                                    <th>Coverage</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                    @php
                                        $coverage = data_get($course->grading_coverage, 'percent', 0);
                                        $pendingClass = $course->pending_reviews >= 5 ? 'text-bg-danger' : ($course->pending_reviews > 0 ? 'text-bg-warning' : 'text-bg-success');
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $course->title }}</div>
                                            <small class="text-muted">{{ $course->subject->name ?? 'General' }}</small>
                                        </td>
                                        <td><span class="badge text-bg-light">{{ $course->enrollments_count }}</span></td>
                                        <td><span class="badge text-bg-light">{{ $course->assignments_count }}</span></td>
                                        <td><span class="badge {{ $pendingClass }}">{{ $course->pending_reviews }}</span></td>
                                        <td><span class="badge text-bg-info">{{ $course->upcoming_deadlines }}</span></td>
                                        <td>
                                            <div class="fw-semibold">{{ $coverage }}%</div>
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $coverage }}%"></div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('teacher.assignments') }}" class="btn btn-sm btn-outline-secondary me-1">Assignments</a>
                                            <a href="{{ route('teacher.submissions') }}" class="btn btn-sm btn-primary">Grade</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
