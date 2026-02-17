@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .exams-shell {
        max-width: 1240px;
        margin: 0 auto;
    }

    .exams-hero {
        border-radius: 1rem;
        background: linear-gradient(120deg, #0f766e 0%, #075985 100%);
    }

    .exam-stat-card {
        border: 0;
        border-radius: .9rem;
    }

    .exam-stat-card .icon-box {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .icon-upcoming { background: #dbeafe; color: #1d4ed8; }
    .icon-completed { background: #dcfce7; color: #15803d; }
    .icon-graded { background: #fef3c7; color: #a16207; }
    .icon-average { background: #cffafe; color: #0e7490; }

    .exam-row:hover {
        background: #f8fafc;
    }

    @media (max-width: 767.98px) {
        .page-pad {
            padding: 1rem !important;
        }

        .exams-hero {
            border-radius: .75rem;
        }

        .exams-hero h2 {
            font-size: 1.35rem;
        }
    }
</style>

<div class="container-fluid page-pad p-4">
    <div class="exams-shell">
        <div class="exams-hero text-white p-4 p-lg-5 mb-4 shadow-sm">
            <div class="row g-3 align-items-center">
                <div class="col-lg-8">
                    <p class="text-uppercase small mb-2 opacity-75">Academic Planning</p>
                    <h2 class="fw-bold mb-2">Exam Center</h2>
                    <p class="mb-0 opacity-75">Track upcoming exams, monitor results, and keep your schedule organized.</p>
                </div>
                <div class="col-lg-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('student.exams.export', request()->query()) }}" class="btn btn-light btn-sm fw-semibold">
                            <i class="fas fa-file-csv me-1"></i> Export Schedule (CSV)
                        </a>
                        <a href="{{ route('student.exams.calendar', request()->query()) }}" class="btn btn-light btn-sm fw-semibold">
                            <i class="fas fa-calendar-plus me-1"></i> Download Calendar (.ics)
                        </a>
                        <a href="{{ route('student.results') }}" class="btn btn-outline-light btn-sm fw-semibold">
                            <i class="fas fa-chart-line me-1"></i> Open Results
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="card exam-stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon-box icon-upcoming"><i class="fas fa-calendar-day"></i></div>
                        <div>
                            <div class="small text-muted">Upcoming</div>
                            <h5 class="mb-0">{{ $upcomingCount }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card exam-stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon-box icon-completed"><i class="fas fa-circle-check"></i></div>
                        <div>
                            <div class="small text-muted">Completed</div>
                            <h5 class="mb-0">{{ $completedCount }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card exam-stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon-box icon-graded"><i class="fas fa-award"></i></div>
                        <div>
                            <div class="small text-muted">Graded</div>
                            <h5 class="mb-0">{{ $gradedCount }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card exam-stat-card shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="icon-box icon-average"><i class="fas fa-percent"></i></div>
                        <div>
                            <div class="small text-muted">Average Score</div>
                            <h5 class="mb-0">{{ number_format($avgScore, 1) }}%</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($nextExam)
            @php
                $daysLeft = now()->startOfDay()->diffInDays($nextExam->exam_date, false);
                $examTime = ($nextExam->start_time ? date('h:i A', strtotime($nextExam->start_time)) : 'TBD') . ' - ' . ($nextExam->end_time ? date('h:i A', strtotime($nextExam->end_time)) : 'TBD');
            @endphp
            <div class="alert alert-info border-0 shadow-sm mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <strong>Next Exam:</strong> {{ $nextExam->title }} ({{ $nextExam->course->title ?? 'N/A' }}) on {{ optional($nextExam->exam_date)->format('M d, Y') }} at {{ $examTime }}
                    </div>
                    <span class="badge text-bg-primary">{{ $daysLeft >= 0 ? $daysLeft . ' day(s) left' : 'Started' }}</span>
                </div>
            </div>
        @endif

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('student.exams') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label for="q" class="form-label fw-semibold">Search</label>
                            <input type="text" id="q" name="q" value="{{ $q }}" class="form-control" placeholder="Title, description, course">
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="">All</option>
                                @foreach($statusOptions as $statusOption)
                                    <option value="{{ $statusOption }}" {{ $status === $statusOption ? 'selected' : '' }}>
                                        {{ ucfirst($statusOption) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="type" class="form-label fw-semibold">Type</label>
                            <select id="type" name="type" class="form-select">
                                <option value="">All</option>
                                @foreach($typeOptions as $typeOption)
                                    <option value="{{ $typeOption }}" {{ $type === $typeOption ? 'selected' : '' }}>
                                        {{ ucfirst($typeOption) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="sort" class="form-label fw-semibold">Sort</label>
                            <select id="sort" name="sort" class="form-select">
                                <option value="upcoming" {{ $sort === 'upcoming' ? 'selected' : '' }}>Upcoming First</option>
                                <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Latest First</option>
                                <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-filter me-1"></i>Apply</button>
                                <a class="btn btn-outline-secondary" href="{{ route('student.exams') }}">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Exam Schedule</h5>
                <span class="badge text-bg-light">{{ $exams->count() }} records</span>
            </div>
            <div class="card-body">
                @if($exams->count() > 0)
                    <div class="table-responsive d-none d-md-block">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Exam</th>
                                    <th>Course</th>
                                    <th>Date & Time</th>
                                    <th class="text-center">Marks</th>
                                    <th>Status</th>
                                    <th>Result</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exams as $exam)
                                    @php
                                        $gradeScore = $exam->gradeScores->first();
                                        $statusClass = match($exam->status) {
                                            'scheduled' => 'text-bg-primary',
                                            'ongoing' => 'text-bg-warning',
                                            'completed' => 'text-bg-success',
                                            'cancelled' => 'text-bg-danger',
                                            default => 'text-bg-secondary'
                                        };
                                    @endphp
                                    <tr class="exam-row">
                                        <td>
                                            <div class="fw-semibold">{{ $exam->title }}</div>
                                            <div class="small text-muted">{{ \Illuminate\Support\Str::limit((string) $exam->description, 62) ?: 'No description' }}</div>
                                            <span class="badge bg-info-subtle text-info mt-1">{{ ucfirst($exam->type ?? 'general') }}</span>
                                        </td>
                                        <td>{{ $exam->course->title ?? 'N/A' }}</td>
                                        <td>
                                            <div class="fw-semibold">{{ optional($exam->exam_date)->format('M d, Y') ?? 'N/A' }}</div>
                                            <div class="small text-muted">
                                                {{ $exam->start_time ? date('h:i A', strtotime($exam->start_time)) : 'TBD' }}
                                                -
                                                {{ $exam->end_time ? date('h:i A', strtotime($exam->end_time)) : 'TBD' }}
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $exam->total_marks ?? 'N/A' }}</td>
                                        <td><span class="badge {{ $statusClass }}">{{ ucfirst($exam->status ?? 'unknown') }}</span></td>
                                        <td>
                                            @if($gradeScore)
                                                <div class="fw-semibold">{{ $gradeScore->marks_obtained }}/{{ $gradeScore->total_marks }}</div>
                                                <span class="badge text-bg-success">{{ $gradeScore->grade }} ({{ number_format($gradeScore->percentage, 1) }}%)</span>
                                            @else
                                                <span class="text-muted">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ route('student.exams.admit-card', $exam->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-id-card me-1"></i>View
                                                </a>
                                                <a href="{{ route('student.exams.admit-card.download', $exam->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-download me-1"></i>PDF
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-md-none">
                        <div class="row g-3">
                            @foreach($exams as $exam)
                                @php
                                    $gradeScore = $exam->gradeScores->first();
                                    $statusClass = match($exam->status) {
                                        'scheduled' => 'text-bg-primary',
                                        'ongoing' => 'text-bg-warning',
                                        'completed' => 'text-bg-success',
                                        'cancelled' => 'text-bg-danger',
                                        default => 'text-bg-secondary'
                                    };
                                @endphp
                                <div class="col-12">
                                    <div class="border rounded-3 p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">{{ $exam->title }}</h6>
                                                <div class="small text-muted">{{ $exam->course->title ?? 'N/A' }}</div>
                                            </div>
                                            <span class="badge {{ $statusClass }}">{{ ucfirst($exam->status ?? 'unknown') }}</span>
                                        </div>
                                        <div class="small mb-1">
                                            <span class="text-muted">Date:</span>
                                            <span class="fw-semibold">{{ optional($exam->exam_date)->format('M d, Y') ?? 'N/A' }}</span>
                                        </div>
                                        <div class="small mb-1">
                                            <span class="text-muted">Time:</span>
                                            <span class="fw-semibold">
                                                {{ $exam->start_time ? date('h:i A', strtotime($exam->start_time)) : 'TBD' }} - {{ $exam->end_time ? date('h:i A', strtotime($exam->end_time)) : 'TBD' }}
                                            </span>
                                        </div>
                                        <div class="small mb-2">
                                            <span class="text-muted">Type:</span>
                                            <span class="fw-semibold">{{ ucfirst($exam->type ?? 'general') }}</span>
                                        </div>
                                        @if($gradeScore)
                                            <div class="small">
                                                <span class="text-muted">Result:</span>
                                                <span class="fw-semibold">{{ $gradeScore->marks_obtained }}/{{ $gradeScore->total_marks }}</span>
                                                <span class="badge text-bg-success ms-1">{{ $gradeScore->grade }}</span>
                                            </div>
                                        @else
                                            <div class="small text-muted">Result not published yet.</div>
                                        @endif
                                        <div class="d-flex gap-2 mt-3">
                                            <a href="{{ route('student.exams.admit-card', $exam->id) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                                <i class="fas fa-id-card me-1"></i>Admit Card
                                            </a>
                                            <a href="{{ route('student.exams.admit-card.download', $exam->id) }}" class="btn btn-sm btn-primary w-100">
                                                <i class="fas fa-download me-1"></i>PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <h5 class="mb-2">No exams found</h5>
                        <p class="text-muted mb-3">No exams match the selected filters.</p>
                        <a href="{{ route('student.exams') }}" class="btn btn-primary">Reset Filters</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
