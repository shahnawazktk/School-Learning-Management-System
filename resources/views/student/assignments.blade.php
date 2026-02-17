@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .assignment-shell {
        max-width: 1240px;
        margin: 0 auto;
    }

    .assignment-hero {
        background: linear-gradient(130deg, #1e3a8a 0%, #0e7490 100%);
        border-radius: 1rem;
    }

    .assignment-stat {
        border: 0;
        border-radius: .9rem;
    }

    .assignment-card {
        border: 0;
        border-radius: 1rem;
        transition: transform .2s ease, box-shadow .2s ease;
        position: relative;
        overflow: hidden;
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
    }

    .assignment-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #2563eb, #0891b2);
    }

    .assignment-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 30px rgba(37, 99, 235, .16);
    }

    .meta-chip {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .25rem .55rem;
        border-radius: 999px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: .78rem;
    }

    .assignment-insight {
        border-left: 4px solid #0ea5e9;
    }

    @media (max-width: 767.98px) {
        .page-pad {
            padding: 1rem !important;
        }

        .assignment-hero h2 {
            font-size: 1.3rem;
        }
    }
</style>

<div class="container-fluid page-pad p-4">
    <div class="assignment-shell">
        <div class="assignment-hero text-white p-4 p-lg-5 mb-4 shadow-sm">
            <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                    <p class="text-uppercase small mb-2 opacity-75">Coursework Center</p>
                    <h2 class="fw-bold mb-2">My Assignments</h2>
                    <p class="mb-0 opacity-75">Track deadlines, submit files, and monitor grading progress from one workspace.</p>
                </div>
                <div class="col-lg-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('student.assignments.export', request()->query()) }}" class="btn btn-light btn-sm fw-semibold">
                            <i class="fas fa-file-csv me-1"></i> Export Assignments (CSV)
                        </a>
                        <a href="{{ route('student.assignments.report.pdf', request()->query()) }}" class="btn btn-light btn-sm fw-semibold">
                            <i class="fas fa-file-pdf me-1"></i> Download Report (PDF)
                        </a>
                        <form method="POST" action="{{ route('student.assignments.reminders.send') }}">
                            @csrf
                            <div class="input-group input-group-sm">
                                <select name="days" class="form-select">
                                    <option value="3">Next 3 Days</option>
                                    <option value="7">Next 7 Days</option>
                                </select>
                                <button type="submit" class="btn btn-warning fw-semibold">
                                    <i class="fas fa-bell me-1"></i> Send
                                </button>
                            </div>
                        </form>
                        <a href="{{ route('student.subjects') }}" class="btn btn-outline-light btn-sm fw-semibold">
                            <i class="fas fa-book-open me-1"></i> Open Subjects
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-2">
                <div class="card assignment-stat shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="mb-1">{{ $stats['total'] }}</h5>
                        <small class="text-muted">Total</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="card assignment-stat shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="mb-1">{{ $stats['pending'] }}</h5>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="card assignment-stat shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="mb-1">{{ $stats['submitted'] }}</h5>
                        <small class="text-muted">Submitted</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="card assignment-stat shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="mb-1">{{ $stats['overdue'] }}</h5>
                        <small class="text-muted">Overdue</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="card assignment-stat shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="mb-1">{{ $stats['critical'] }}</h5>
                        <small class="text-muted">Critical (2 days)</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="card assignment-stat shadow-sm h-100 text-center">
                    <div class="card-body">
                        <h5 class="mb-1">{{ is_null($stats['avg_score']) ? 'N/A' : number_format($stats['avg_score'], 1) }}</h5>
                        <small class="text-muted">Avg Score</small>
                    </div>
                </div>
            </div>
        </div>

        @if($nextDeadline)
            @php $nextAssignment = $nextDeadline['assignment']; @endphp
            <div class="alert alert-info border-0 shadow-sm assignment-insight mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <strong>Next Deadline:</strong> {{ $nextAssignment->title }} ({{ $nextAssignment->course->title ?? 'N/A' }})
                        on {{ optional($nextAssignment->due_date)->format('M d, Y h:i A') ?? 'N/A' }}
                    </div>
                    @if(!is_null($nextDeadline['days_left']))
                        <span class="badge text-bg-primary">{{ $nextDeadline['days_left'] }} day(s) left</span>
                    @endif
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>Submission failed:</strong>
                <ul class="mb-0 mt-2 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('student.assignments') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label for="q" class="form-label fw-semibold">Search</label>
                            <input type="text" id="q" name="q" class="form-control" value="{{ $search }}" placeholder="Title, description, course">
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="course_id" class="form-label fw-semibold">Course</label>
                            <select id="course_id" name="course_id" class="form-select">
                                <option value="">All Courses</option>
                                @foreach($courseOptions as $course)
                                    <option value="{{ $course->id }}" {{ (string) $courseId === (string) $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="">All</option>
                                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="submitted" {{ $status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                                <option value="overdue" {{ $status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                                <option value="late" {{ $status === 'late' ? 'selected' : '' }}>Late Submit</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="due_window" class="form-label fw-semibold">Due Window</label>
                            <select id="due_window" name="due_window" class="form-select">
                                <option value="">All</option>
                                <option value="today" {{ $dueWindow === 'today' ? 'selected' : '' }}>Today</option>
                                <option value="next_7" {{ $dueWindow === 'next_7' ? 'selected' : '' }}>Next 7 Days</option>
                                <option value="next_30" {{ $dueWindow === 'next_30' ? 'selected' : '' }}>Next 30 Days</option>
                                <option value="overdue" {{ $dueWindow === 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="sort" class="form-label fw-semibold">Sort</label>
                            <select id="sort" name="sort" class="form-select">
                                <option value="due_asc" {{ $sort === 'due_asc' ? 'selected' : '' }}>Due (Soon)</option>
                                <option value="due_desc" {{ $sort === 'due_desc' ? 'selected' : '' }}>Due (Latest)</option>
                                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="view" class="form-label fw-semibold">View</label>
                            <select id="view" name="view" class="form-select">
                                <option value="list" {{ $view === 'list' ? 'selected' : '' }}>List</option>
                                <option value="compact" {{ $view === 'compact' ? 'selected' : '' }}>Compact Grid</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-2">
                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i></button>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('student.assignments') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-rotate-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Status Analytics</h5>
                <span class="badge text-bg-light">{{ $assignmentCards->count() }} records</span>
            </div>
            <div class="card-body">
                <div style="height: 280px;">
                    <canvas id="assignmentStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @forelse($assignmentCards as $card)
                @php
                    $assignment = $card['assignment'];
                    $submission = $card['submission'];
                    $statusKey = $card['status_key'];
                    $badgeClass = match($statusKey) {
                        'submitted' => 'bg-success-subtle text-success',
                        'late' => 'bg-warning-subtle text-warning',
                        'overdue' => 'bg-danger-subtle text-danger',
                        default => 'bg-primary-subtle text-primary'
                    };
                    $columnClass = $view === 'compact' ? 'col-12 col-xl-6' : 'col-12';
                @endphp
                <div class="{{ $columnClass }}">
                    <div class="card assignment-card shadow-sm h-100">
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-lg-8">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="mb-0">{{ $assignment->title }}</h5>
                                        <span class="badge rounded-pill {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $statusKey)) }}</span>
                                    </div>

                                    <p class="text-muted mb-3">{{ $assignment->description ?: 'No assignment description provided.' }}</p>

                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="meta-chip"><i class="fas fa-book"></i>{{ $assignment->course->title ?? 'N/A' }}</span>
                                        <span class="meta-chip"><i class="fas fa-layer-group"></i>{{ optional(optional($assignment->course)->subject)->code ?? 'N/A' }}</span>
                                        <span class="meta-chip"><i class="fas fa-star"></i>{{ $assignment->max_marks }} Marks</span>
                                        <span class="meta-chip"><i class="fas fa-calendar-alt"></i>Due: {{ optional($assignment->due_date)->format('M d, Y h:i A') ?? 'N/A' }}</span>
                                        @if($card['priority'] === 'high')
                                            <span class="meta-chip text-bg-danger border-0"><i class="fas fa-bolt"></i>High Priority</span>
                                        @endif
                                    </div>

                                    @if (!is_null($card['days_left']) && in_array($statusKey, ['pending', 'overdue'], true))
                                        <div class="alert {{ $card['days_left'] >= 0 ? 'alert-info' : 'alert-danger' }} py-2 mb-0">
                                            <strong>{{ $card['days_left'] >= 0 ? $card['days_left'] : abs($card['days_left']) }}</strong>
                                            {{ $card['days_left'] >= 0 ? 'day(s) left to submit.' : 'day(s) overdue.' }}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-lg-4">
                                    @if($submission)
                                        <div class="border rounded-3 p-3 bg-light h-100">
                                            <h6 class="mb-2">Submission Details</h6>
                                            <div class="small mb-1">
                                                <span class="text-muted">Submitted:</span>
                                                <strong>{{ optional($submission->submitted_at)->format('M d, Y h:i A') ?? 'N/A' }}</strong>
                                            </div>
                                            <div class="small mb-1">
                                                <span class="text-muted">Status:</span>
                                                <strong>{{ ucfirst($submission->status) }}</strong>
                                            </div>
                                            <div class="small mb-1">
                                                <span class="text-muted">Score:</span>
                                                <strong>
                                                    {{ is_null($submission->marks_obtained) ? 'Pending Review' : $submission->marks_obtained . '/' . $assignment->max_marks }}
                                                </strong>
                                            </div>
                                            @if($submission->feedback)
                                                <div class="small mt-2">
                                                    <span class="text-muted">Teacher Feedback:</span>
                                                    <div>{{ $submission->feedback }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="border rounded-3 p-3 bg-light h-100">
                                            <h6 class="mb-3">Submit Assignment</h6>
                                            <form method="POST" action="{{ route('student.assignments.submit', $assignment->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-2">
                                                    <label class="form-label small mb-1">Upload File</label>
                                                    <input type="file" name="file" class="form-control form-control-sm" required>
                                                    <div class="form-text">PDF, DOC, PPT, JPG, PNG, ZIP (max 10MB)</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small mb-1">Comments (Optional)</label>
                                                    <textarea name="comments" rows="2" class="form-control form-control-sm" placeholder="Add submission notes..."></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                                    <i class="fas fa-upload me-1"></i> Submit Now
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <h5 class="mb-2">No assignments found</h5>
                            <p class="text-muted mb-3">Try changing filters or check later for newly published tasks.</p>
                            <a href="{{ route('student.assignments') }}" class="btn btn-primary">
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
        const chartEl = document.getElementById('assignmentStatusChart');
        if (!chartEl || typeof Chart === 'undefined') {
            return;
        }

        const labels = @json($chartStatusLabels);
        const values = @json($chartStatusValues);

        new Chart(chartEl, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        'rgba(37, 99, 235, 0.85)',
                        'rgba(16, 185, 129, 0.85)',
                        'rgba(245, 158, 11, 0.85)',
                        'rgba(239, 68, 68, 0.85)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    })();
</script>
@endsection
