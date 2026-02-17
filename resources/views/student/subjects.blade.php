@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .subjects-shell {
        max-width: 1240px;
        margin: 0 auto;
    }

    .subjects-hero {
        background: linear-gradient(120deg, #0f766e 0%, #0369a1 100%);
        border-radius: 1rem;
    }

    .subject-card {
        border: 0;
        border-radius: 1rem;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        position: relative;
        overflow: hidden;
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
    }

    .subject-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #06b6d4 0%, #0ea5e9 50%, #2563eb 100%);
    }

    .subject-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 34px rgba(2, 132, 199, .18);
    }

    .subject-meta {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: .75rem;
        padding: .75rem;
    }

    .subject-deadline {
        border-left: 4px solid #ef4444;
    }

    .subject-card .progress {
        background: #dbeafe;
    }

    .subject-progress {
        height: 10px;
        border-radius: 999px;
    }

    .subject-card .progress-bar {
        background: linear-gradient(90deg, #0ea5e9, #2563eb);
    }

    .subject-actions .btn {
        min-height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        white-space: nowrap;
    }

    .subject-actions .btn i {
        margin-right: .35rem;
    }

    @media (max-width: 767.98px) {
        .page-pad {
            padding: 1rem !important;
        }

        .subject-actions .btn {
            min-height: 38px;
            font-size: .85rem;
        }
    }
</style>

<div class="container-fluid page-pad p-4">
    <div class="subjects-shell">
        <div class="subjects-hero text-white p-4 p-lg-5 mb-4 shadow-sm">
            <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                    <p class="text-uppercase small mb-2 opacity-75">Academic Overview</p>
                    <h2 class="fw-bold mb-2">My Subjects</h2>
                    <p class="mb-0 opacity-75">
                        Track enrolled subjects, assignment completion, and upcoming deadlines from one place.
                    </p>
                </div>
                <div class="col-lg-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('student.subjects.export', request()->query()) }}" class="btn btn-light btn-sm fw-semibold">
                            <i class="fas fa-file-csv me-1"></i> Export Progress (CSV)
                        </a>
                        <a href="{{ route('student.subjects.report.pdf', request()->query()) }}" class="btn btn-light btn-sm fw-semibold">
                            <i class="fas fa-file-pdf me-1"></i> Download Progress Report (PDF)
                        </a>
                        <a href="{{ route('student.assignments') }}" class="btn btn-outline-light btn-sm fw-semibold">
                            <i class="fas fa-tasks me-1"></i> Open Assignments
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-2">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="mb-1">{{ $stats['total_subjects'] }}</h5>
                        <small class="text-muted">Total</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="mb-1">{{ $stats['active_subjects'] }}</h5>
                        <small class="text-muted">Active</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="mb-1">{{ $stats['total_credits'] }}</h5>
                        <small class="text-muted">Credits</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="mb-1">{{ $stats['average_progress'] }}%</h5>
                        <small class="text-muted">Avg Progress</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="mb-1">{{ $stats['upcoming_deadlines'] }}</h5>
                        <small class="text-muted">Due in 7 Days</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="mb-1">{{ $stats['at_risk'] }}</h5>
                        <small class="text-muted">At Risk</small>
                    </div>
                </div>
            </div>
        </div>

        @if($stats['at_risk'] > 0)
            <div class="alert alert-warning border-0 shadow-sm mb-4">
                <i class="fas fa-triangle-exclamation me-2"></i>
                {{ $stats['at_risk'] }} subject(s) have low completion (&lt; 50%). Focus on pending assignments to improve progress.
            </div>
        @endif

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-column me-2"></i>Subject Performance Trend</h5>
                <span class="badge text-bg-light">{{ $subjectCards->count() }} subjects</span>
            </div>
            <div class="card-body">
                <div style="height: 340px;">
                    <canvas id="subjectsTrendChart"></canvas>
                </div>
                <p class="small text-muted mb-0 mt-3">
                    Progress (%) per subject with assignment submission context for planning.
                </p>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('student.subjects') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label for="q" class="form-label fw-semibold">Search Subject / Course</label>
                            <input type="text" id="q" name="q" value="{{ $search }}" class="form-control" placeholder="e.g. Mathematics, PHY101">
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="">All</option>
                                <option value="enrolled" {{ $status === 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="dropped" {{ $status === 'dropped' ? 'selected' : '' }}>Dropped</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label for="sort" class="form-label fw-semibold">Sort By</label>
                            <select id="sort" name="sort" class="form-select">
                                <option value="progress_desc" {{ $sort === 'progress_desc' ? 'selected' : '' }}>Progress (High to Low)</option>
                                <option value="progress_asc" {{ $sort === 'progress_asc' ? 'selected' : '' }}>Progress (Low to High)</option>
                                <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name (A to Z)</option>
                                <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Name (Z to A)</option>
                                <option value="next_due" {{ $sort === 'next_due' ? 'selected' : '' }}>Next Due Date</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-filter me-1"></i> Apply
                                    </button>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('student.subjects') }}" class="btn btn-outline-secondary w-100">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4">
            @forelse($subjectCards as $card)
                @php
                    $enrollment = $card['enrollment'];
                    $course = $card['course'];
                    $subject = $card['subject'];
                    $teacher = $card['teacher'];
                    $statusClass = match($enrollment->status) {
                        'completed' => 'bg-success-subtle text-success',
                        'dropped' => 'bg-danger-subtle text-danger',
                        default => 'bg-primary-subtle text-primary'
                    };
                    $courseTitle = $course->title ?? $subject->name ?? 'Untitled Subject';
                @endphp
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card subject-card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="mb-1">{{ $courseTitle }}</h5>
                                    <div class="text-muted small">
                                        {{ $subject->code ?? 'No code' }} | {{ $subject->credits ?? 0 }} Credits
                                    </div>
                                </div>
                                <span class="badge rounded-pill {{ $statusClass }}">
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </div>

                            <div class="mb-3 small subject-meta">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Instructor</span>
                                    <span class="fw-semibold">{{ $teacher->name ?? 'Not assigned' }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Assignments</span>
                                    <span class="fw-semibold">{{ $card['submitted_assignments'] }}/{{ $card['total_assignments'] }} Submitted</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Enrolled On</span>
                                    <span class="fw-semibold">{{ optional($enrollment->enrollment_date)->format('M d, Y') ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Progress</span>
                                    <span class="fw-semibold">{{ $card['completion'] }}%</span>
                                </div>
                                <div class="progress subject-progress">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $card['completion'] }}%" aria-valuenow="{{ $card['completion'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="p-3 rounded-3 bg-light mb-3 small subject-deadline">
                                @if($card['next_due'])
                                    <div class="text-muted">Next Assignment Due</div>
                                    <div class="fw-semibold">{{ $card['next_due']->title }}</div>
                                    <div class="text-danger">
                                        <i class="fas fa-calendar-alt me-1"></i>{{ $card['next_due']->due_date->format('M d, Y h:i A') }}
                                        @if(!is_null($card['days_left']))
                                            <span class="badge text-bg-danger ms-1">{{ $card['days_left'] }} day(s) left</span>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-muted">No upcoming assignment deadlines</div>
                                @endif
                            </div>

                            <div class="mt-auto row g-2 subject-actions">
                                <div class="col-6 d-grid">
                                    <a href="{{ route('student.assignments', ['course_id' => $course->id ?? null]) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-tasks"></i> Assignments
                                    </a>
                                </div>
                                <div class="col-6 d-grid">
                                    <a href="{{ route('student.resources') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-folder-open"></i> Resources
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <h5 class="mb-2">No subjects found</h5>
                            <p class="text-muted mb-3">Try changing filters or contact admin if enrollments are missing.</p>
                            <a href="{{ route('student.subjects') }}" class="btn btn-primary">
                                <i class="fas fa-rotate-right me-1"></i> Reset Filters
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    (() => {
        const canvas = document.getElementById('subjectsTrendChart');
        if (!canvas || typeof Chart === 'undefined') {
            return;
        }

        const labels = @json($chartLabels);
        const progressData = @json($chartProgress);
        const submittedData = @json($chartSubmitted);
        const totalAssignmentsData = @json($chartTotalAssignments);

        const maxAssignments = Math.max(1, ...totalAssignmentsData);

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels,
                datasets: [
                    {
                        type: 'bar',
                        label: 'Progress %',
                        data: progressData,
                        backgroundColor: 'rgba(14, 165, 233, 0.5)',
                        borderColor: 'rgba(3, 105, 161, 1)',
                        borderWidth: 1.2,
                        yAxisID: 'yProgress'
                    },
                    {
                        type: 'line',
                        label: 'Submitted Assignments',
                        data: submittedData,
                        borderColor: 'rgba(16, 185, 129, 1)',
                        backgroundColor: 'rgba(16, 185, 129, 0.15)',
                        tension: 0.25,
                        fill: false,
                        yAxisID: 'yAssignments'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    yProgress: {
                        position: 'left',
                        min: 0,
                        max: 100,
                        ticks: {
                            callback: (value) => value + '%'
                        }
                    },
                    yAssignments: {
                        position: 'right',
                        min: 0,
                        max: maxAssignments,
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
    })();
</script>
@endsection
