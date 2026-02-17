@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .assignment-hero {
        background: linear-gradient(130deg, #1e40af 0%, #0891b2 100%);
        border-radius: 1rem;
    }

    .assignment-card {
        border: 0;
        border-radius: 1rem;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .assignment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(37, 99, 235, .14);
    }
</style>

<div class="container-fluid p-4">
    <div class="assignment-hero text-white p-4 p-lg-5 mb-4 shadow-sm">
        <div class="row g-3 align-items-center">
            <div class="col-lg-8">
                <p class="text-uppercase small mb-2 opacity-75">Coursework Center</p>
                <h2 class="fw-bold mb-2">My Assignments</h2>
                <p class="mb-0 opacity-75">Track deadlines, submit files, and monitor grading progress.</p>
            </div>
            <div class="col-lg-4">
                <div class="row g-2 text-center">
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3">
                            <h4 class="mb-0">{{ $stats['total'] }}</h4>
                            <small>Total</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3">
                            <h4 class="mb-0">{{ $stats['pending'] }}</h4>
                            <small>Pending</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3">
                            <h4 class="mb-0">{{ $stats['submitted'] }}</h4>
                            <small>Submitted</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white bg-opacity-10 rounded-3 p-3">
                            <h4 class="mb-0">{{ is_null($stats['avg_score']) ? 'N/A' : number_format($stats['avg_score'], 1) }}</h4>
                            <small>Avg Score</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="q" class="form-label">Search</label>
                        <input type="text" id="q" name="q" class="form-control" value="{{ $search }}" placeholder="Title, description, course">
                    </div>
                    <div class="col-md-3">
                        <label for="course_id" class="form-label">Course</label>
                        <select id="course_id" name="course_id" class="form-select">
                            <option value="">All Courses</option>
                            @foreach($courseOptions as $course)
                                <option value="{{ $course->id }}" {{ (string) $courseId === (string) $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select">
                            <option value="">All</option>
                            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="submitted" {{ $status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="overdue" {{ $status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                            <option value="late" {{ $status === 'late' ? 'selected' : '' }}>Late Submit</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="sort" class="form-label">Sort</label>
                        <select id="sort" name="sort" class="form-select">
                            <option value="due_asc" {{ $sort === 'due_asc' ? 'selected' : '' }}>Due (Soon)</option>
                            <option value="due_desc" {{ $sort === 'due_desc' ? 'selected' : '' }}>Due (Latest)</option>
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </div>
            </form>
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
            @endphp
            <div class="col-12">
                <div class="card assignment-card shadow-sm">
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="mb-0">{{ $assignment->title }}</h5>
                                    <span class="badge rounded-pill {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $statusKey)) }}</span>
                                </div>
                                <p class="text-muted mb-3">{{ $assignment->description ?: 'No assignment description provided.' }}</p>

                                <div class="d-flex flex-wrap gap-3 small mb-3">
                                    <span><i class="fas fa-book me-1"></i>{{ $assignment->course->title ?? 'N/A' }}</span>
                                    <span><i class="fas fa-layer-group me-1"></i>{{ optional(optional($assignment->course)->subject)->code ?? 'N/A' }}</span>
                                    <span><i class="fas fa-star me-1"></i>{{ $assignment->max_marks }} Marks</span>
                                    <span><i class="fas fa-calendar-alt me-1"></i>Due: {{ optional($assignment->due_date)->format('M d, Y h:i A') ?? 'N/A' }}</span>
                                </div>

                                @if (!is_null($card['days_left']) && $statusKey === 'pending')
                                    <div class="alert alert-info py-2 mb-0">
                                        <strong>{{ $card['days_left'] >= 0 ? $card['days_left'] : abs($card['days_left']) }}</strong>
                                        {{ $card['days_left'] >= 0 ? 'day(s) left to submit.' : 'day(s) overdue.' }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-4">
                                @if($submission)
                                    <div class="border rounded-3 p-3 bg-light">
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
                                    <div class="border rounded-3 p-3 bg-light">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
