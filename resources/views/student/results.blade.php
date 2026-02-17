@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .results-shell {
        max-width: 1240px;
        margin: 0 auto;
    }

    .results-hero {
        background: linear-gradient(120deg, #0f766e 0%, #0369a1 100%);
        border-radius: 1rem;
    }

    .results-stat,
    .results-panel {
        border: 0;
        border-radius: .9rem;
    }

    .results-stat .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .results-stat .stat-icon.primary {
        background: #dbeafe;
        color: #2563eb;
    }

    .results-stat .stat-icon.success {
        background: #dcfce7;
        color: #16a34a;
    }

    .results-stat .stat-icon.warning {
        background: #fef3c7;
        color: #d97706;
    }

    .results-stat .stat-icon.info {
        background: #cffafe;
        color: #0891b2;
    }

    .result-grade-row:hover {
        background-color: #f8fafc;
    }

    .grade-pill {
        min-width: 52px;
        text-align: center;
    }

    .distribution-track {
        height: 8px;
        border-radius: 999px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .distribution-fill {
        height: 100%;
        background: linear-gradient(90deg, #0ea5e9, #10b981);
    }

    .results-filter .form-label {
        font-weight: 600;
        margin-bottom: .45rem;
    }

    .results-filter .form-select,
    .results-filter .btn {
        min-height: 44px;
    }

    .results-head-title {
        font-size: 1.1rem;
    }

    .type-pill.assignment {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .type-pill.exam {
        background: #fef3c7;
        color: #92400e;
    }

    .type-pill.other {
        background: #e2e8f0;
        color: #334155;
    }

    @media (max-width: 767.98px) {
        .page-pad {
            padding: 1rem !important;
        }

        .results-hero {
            border-radius: .75rem;
            padding: 1rem !important;
        }

        .results-hero h2 {
            font-size: 1.25rem;
        }

        .results-hero p {
            font-size: .86rem;
        }

        .results-shell {
            max-width: 100%;
        }
    }
</style>

<div class="container-fluid page-pad p-4">
    <div class="results-shell">
    <div class="results-hero text-white p-4 p-lg-5 mb-4 shadow-sm">
        <div class="row g-3 align-items-center">
            <div class="col-lg-8">
                <p class="text-uppercase small mb-2 opacity-75">Academic Performance</p>
                <h2 class="fw-bold mb-2">Results & Gradebook</h2>
                <p class="mb-0 opacity-75">
                    View your assignment and exam performance with detailed grade analytics.
                </p>
            </div>
            <div class="col-lg-4">
                <div class="row g-2">
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center">
                            <h4 class="mb-0">{{ number_format($averagePercentage, 1) }}%</h4>
                            <small>Average</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center">
                            <h4 class="mb-0">{{ number_format($passRate, 1) }}%</h4>
                            <small>Pass Rate</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center">
                            <h4 class="mb-0">{{ $totalSubjects }}</h4>
                            <small>Subjects</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center">
                            <h4 class="mb-0">{{ $grades->count() }}</h4>
                            <small>Assessments</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2 justify-content-end mb-4">
        <a href="{{ route('student.results.card', request()->query()) }}" target="_blank" class="btn btn-outline-primary">
            <i class="fas fa-id-card me-1"></i> View Result Card
        </a>
        <a href="{{ route('student.results.card.download', request()->query()) }}" class="btn btn-primary">
            <i class="fas fa-download me-1"></i> Download Result Card (PDF)
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card results-stat shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon primary">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Average Score</div>
                        <h5 class="mb-0">{{ number_format($averagePercentage, 1) }}%</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card results-stat shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon success">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Highest Score</div>
                        <h5 class="mb-0">{{ number_format($highestPercentage, 1) }}%</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card results-stat shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon warning">
                        <i class="fas fa-gauge-high"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Lowest Score</div>
                        <h5 class="mb-0">{{ number_format($lowestPercentage, 1) }}%</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card results-stat shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon info">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Total Graded</div>
                        <h5 class="mb-0">{{ $grades->count() }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card results-panel shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('student.results') }}" class="results-filter">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-5">
                        <label for="course_id" class="form-label">Course</label>
                        <select id="course_id" name="course_id" class="form-select">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ (int) $courseId === (int) $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="type" class="form-label">Assessment Type</label>
                        <select id="type" name="type" class="form-select">
                            <option value="">All Types</option>
                            <option value="assignment" {{ $type === 'assignment' ? 'selected' : '' }}>Assignment</option>
                            <option value="exam" {{ $type === 'exam' ? 'selected' : '' }}>Exam</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="row g-2">
                            <div class="col-6 col-md-12 col-lg-6">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-1"></i> Apply
                                </button>
                            </div>
                            <div class="col-6 col-md-12 col-lg-6">
                                <a href="{{ route('student.results') }}" class="btn btn-outline-secondary w-100">Reset</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card results-panel shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 results-head-title"><i class="fas fa-file-lines me-2"></i>Detailed Grade Report</h5>
                    <span class="badge rounded-pill text-bg-light">{{ $grades->count() }} records</span>
                </div>
                <div class="card-body">
                    @if($grades->count() > 0)
                        <div class="table-responsive d-none d-md-block">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Assessment</th>
                                        <th class="text-center">Marks</th>
                                        <th class="text-center">Percentage</th>
                                        <th class="text-center">Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grades as $grade)
                                        @php
                                            $isAssignment = !is_null($grade->assignment_id);
                                            $typeClass = $isAssignment ? 'assignment' : (!is_null($grade->exam_id) ? 'exam' : 'other');
                                            $typeLabel = $isAssignment ? 'Assignment' : (!is_null($grade->exam_id) ? 'Exam' : 'Other');
                                            $gradeClass = match($grade->grade) {
                                                'A+', 'A' => 'text-bg-success',
                                                'B+', 'B' => 'text-bg-primary',
                                                'C+', 'C' => 'text-bg-warning',
                                                'D', 'F' => 'text-bg-danger',
                                                default => 'text-bg-secondary'
                                            };
                                        @endphp
                                        <tr class="result-grade-row">
                                            <td>
                                                <div class="fw-semibold">{{ $grade->course->title ?? 'N/A' }}</div>
                                                <div class="small text-muted">{{ optional($grade->created_at)->format('M d, Y') ?? 'N/A' }}</div>
                                            </td>
                                            <td>
                                                <div class="mb-1">
                                                    <span class="badge rounded-pill type-pill {{ $typeClass }}">{{ $typeLabel }}</span>
                                                </div>
                                                <div class="small text-muted">
                                                    {{ $grade->assignment->title ?? $grade->exam->title ?? 'General Assessment' }}
                                                </div>
                                            </td>
                                            <td class="text-center fw-semibold">
                                                {{ $grade->marks_obtained }} / {{ $grade->total_marks }}
                                            </td>
                                            <td class="text-center fw-semibold">{{ number_format($grade->percentage, 1) }}%</td>
                                            <td class="text-center">
                                                <span class="badge grade-pill {{ $gradeClass }}">{{ $grade->grade }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-md-none">
                            <div class="row g-3">
                                @foreach($grades as $grade)
                                    @php
                                        $isAssignment = !is_null($grade->assignment_id);
                                        $typeClass = $isAssignment ? 'assignment' : (!is_null($grade->exam_id) ? 'exam' : 'other');
                                        $typeLabel = $isAssignment ? 'Assignment' : (!is_null($grade->exam_id) ? 'Exam' : 'Other');
                                        $gradeClass = match($grade->grade) {
                                            'A+', 'A' => 'text-bg-success',
                                            'B+', 'B' => 'text-bg-primary',
                                            'C+', 'C' => 'text-bg-warning',
                                            'D', 'F' => 'text-bg-danger',
                                            default => 'text-bg-secondary'
                                        };
                                    @endphp
                                    <div class="col-12">
                                        <div class="border rounded-3 p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-1">{{ $grade->course->title ?? 'N/A' }}</h6>
                                                    <div class="small text-muted">{{ optional($grade->created_at)->format('M d, Y') ?? 'N/A' }}</div>
                                                </div>
                                                <span class="badge grade-pill {{ $gradeClass }}">{{ $grade->grade }}</span>
                                            </div>
                                            <div class="mb-2">
                                                <span class="badge rounded-pill type-pill {{ $typeClass }}">{{ $typeLabel }}</span>
                                                <span class="small text-muted ms-1">
                                                    {{ $grade->assignment->title ?? $grade->exam->title ?? 'General Assessment' }}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between small">
                                                <span class="text-muted">Marks</span>
                                                <span class="fw-semibold">{{ $grade->marks_obtained }} / {{ $grade->total_marks }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between small">
                                                <span class="text-muted">Percentage</span>
                                                <span class="fw-semibold">{{ number_format($grade->percentage, 1) }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-square-poll-horizontal fa-3x text-muted mb-3"></i>
                            <h5 class="mb-2">No grades found</h5>
                            <p class="text-muted mb-0">No result records match the selected filters.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card results-panel shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 results-head-title"><i class="fas fa-chart-pie me-2"></i>Grade Distribution</h5>
                </div>
                <div class="card-body">
                    @php $totalGrades = max($grades->count(), 1); @endphp
                    @forelse($gradeDistribution as $label => $count)
                        @php $share = ($count / $totalGrades) * 100; @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="fw-semibold">{{ $label }}</span>
                                <span class="text-muted">{{ $count }} ({{ number_format($share, 0) }}%)</span>
                            </div>
                            <div class="distribution-track">
                                <div class="distribution-fill" style="width: {{ $share }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No distribution data available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
