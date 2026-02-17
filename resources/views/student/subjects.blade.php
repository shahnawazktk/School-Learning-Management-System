@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .subjects-hero {
        background: linear-gradient(120deg, #0f766e 0%, #0369a1 100%);
        border-radius: 1rem;
    }

    .subject-card {
        border: 0;
        border-radius: 1rem;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .subject-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(2, 132, 199, .15);
    }

    .subject-progress {
        height: 10px;
        border-radius: 999px;
    }
</style>

<div class="container-fluid p-4">
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
                <div class="row g-2">
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center">
                            <h4 class="mb-0">{{ $stats['total_subjects'] }}</h4>
                            <small>Total</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center">
                            <h4 class="mb-0">{{ $stats['active_subjects'] }}</h4>
                            <small>Active</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center">
                            <h4 class="mb-0">{{ $stats['total_credits'] }}</h4>
                            <small>Credits</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center">
                            <h4 class="mb-0">{{ $stats['average_progress'] }}%</h4>
                            <small>Avg Progress</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('student.subjects') }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="q" class="form-label">Search Subject / Course</label>
                        <input type="text" id="q" name="q" value="{{ $search }}" class="form-control" placeholder="e.g. Mathematics, PHY101">
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Enrollment Status</label>
                        <select id="status" name="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="enrolled" {{ $status === 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                            <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="dropped" {{ $status === 'dropped' ? 'selected' : '' }}>Dropped</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-1"></i> Apply
                        </button>
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
            @endphp
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card subject-card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="mb-1">{{ $course->title ?? $subject->name ?? 'Untitled Subject' }}</h5>
                                <div class="text-muted small">
                                    {{ $subject->code ?? 'No code' }} | {{ $subject->credits ?? 0 }} Credits
                                </div>
                            </div>
                            <span class="badge rounded-pill {{ $statusClass }}">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </div>

                        <div class="mb-3 small">
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

                        <div class="p-3 rounded-3 bg-light mb-3 small">
                            @if($card['next_due'])
                                <div class="text-muted">Next Assignment Due</div>
                                <div class="fw-semibold">{{ $card['next_due']->title }}</div>
                                <div class="text-danger">
                                    <i class="fas fa-calendar-alt me-1"></i>{{ $card['next_due']->due_date->format('M d, Y h:i A') }}
                                </div>
                            @else
                                <div class="text-muted">No upcoming assignment deadlines</div>
                            @endif
                        </div>

                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('student.assignments') }}" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-tasks me-1"></i> Assignments
                            </a>
                            <a href="{{ route('student.resources') }}" class="btn btn-outline-secondary btn-sm w-100">
                                <i class="fas fa-folder-open me-1"></i> Resources
                            </a>
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
@endsection
