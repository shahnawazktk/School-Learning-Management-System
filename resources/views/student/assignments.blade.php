@extends('layouts.student.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --primary: #4f46e5;     /* Indigo */
        --primary-light: #6366f1;
        --secondary: #0ea5e9;   /* Light Blue */
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #1e293b;
        --bg-gray: #f8fafc;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.5);
    }
    
    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-gray);
        color: #334155;
    }

    .assignment-shell {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Premium Hero Section */
    .assignment-hero {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        padding: 3.5rem 2.5rem;
        margin-bottom: 2.5rem;
    }
    
    .assignment-hero::before {
        content: '';
        position: absolute;
        top: -20%; right: -10%;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .assignment-hero::after {
        content: '';
        position: absolute;
        bottom: -30%; left: -5%;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(0,0,0,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .hero-btn {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        transition: all 0.3s ease;
        border-radius: 50rem;
    }
    .hero-btn:hover {
        background: white;
        color: var(--primary);
        transform: translateY(-2px);
    }

    /* Glassmorphic Stat Cards */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 1.25rem;
        padding: 1.5rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        border-color: var(--primary-light);
    }
    .stat-icon {
        position: absolute;
        top: -10px;
        right: -10px;
        font-size: 5rem;
        opacity: 0.04;
        color: var(--dark);
    }
    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark);
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Filters Section */
    .filter-section {
        background: white;
        border-radius: 1.25rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        margin-bottom: 2.5rem;
    }
    .form-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .custom-select, .custom-input {
        border-radius: 0.75rem;
        border: 1px solid #cbd5e1;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s;
    }
    .custom-select:focus, .custom-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }

    /* Assignment Cards */
    .assignment-card {
        background: white;
        border-radius: 1.25rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .assignment-card:hover {
        transform: translateY(-4px) scale(1.01);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        border-color: #cbd5e1;
    }

    .card-ribbon {
        height: 6px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        width: 100%;
    }

    .card-body-custom {
        padding: 1.75rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .meta-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.9rem;
        border-radius: 50rem;
        background: white;
        color: #475569;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        border: 1px solid #e2e8f0;
    }

    /* Editable Notes */
    .editable-note-wrapper {
        background: #fcfdfd;
        border: 1px dashed #cbd5e1;
        border-radius: 1rem;
        margin-top: 1.5rem;
        transition: all 0.2s;
    }
    .editable-note-wrapper:hover {
        border-color: var(--secondary);
        background: #f0f9ff;
    }
    .editable-note-header {
        padding: 0.75rem 1.25rem;
        border-bottom: 1px dashed #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255,255,255,0.5);
        border-radius: 1rem 1rem 0 0;
    }
    .editable-note-area {
        padding: 1.25rem;
        min-height: 80px;
        outline: none;
        color: #334155;
        font-size: 0.95rem;
        line-height: 1.5;
    }
    .editable-note-area[data-placeholder]:empty:before {
        content: attr(data-placeholder);
        color: #94a3b8;
        font-style: italic;
        pointer-events: none;
        display: block;
    }
    .editable-note-area:focus {
        background: white;
        border-radius: 0 0 1rem 1rem;
    }

    /* Next Deadline Alert */
    .next-deadline-alert {
        background: linear-gradient(to right, #ffffff, #f0f9ff);
        border: 1px solid #bae6fd;
        border-left: 5px solid var(--secondary);
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    
    /* Status Badges */
    .status-badge {
        padding: 0.5rem 1.25rem;
        border-radius: 50rem;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    /* Submissions Area */
    .submission-area {
        margin-top: 1.5rem;
    }

    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
        margin-bottom: 1rem;
    }
    .file-input-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        cursor: pointer;
        height: 100%;
    }
    .file-drop-area {
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 1rem;
        text-align: center;
        transition: all 0.2s;
    }
    .file-drop-area:hover, .file-input-wrapper:hover .file-drop-area {
        border-color: var(--primary);
        background: #eff6ff;
    }

    @media (max-width: 768px) {
        .assignment-hero { padding: 2rem 1.5rem; }
        .assignment-hero h2 { font-size: 1.75rem; }
        .card-body-custom { padding: 1.25rem; }
    }
</style>

<div class="container-fluid py-4">
    <div class="assignment-shell">
        
        <!-- Hero Section -->
        <div class="assignment-hero z-1">
            <div class="row align-items-center g-4 position-relative z-2">
                <div class="col-lg-7 text-white">
                    <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill fw-bold shadow-sm">
                        <i class="fas fa-graduation-cap me-2"></i>Coursework Center
                    </span>
                    <h2 class="fw-bold mb-3 display-5">My Assignments</h2>
                    <p class="fs-5 mb-0 text-white-50">Manage deadlines, submit coursework, and track your grades effortlessly.</p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                        <a href="{{ route('student.assignments.export', request()->query()) }}" class="btn hero-btn fw-semibold px-4 pb-2 pt-2">
                            <i class="fas fa-file-csv me-2"></i> Export CSV
                        </a>
                        <a href="{{ route('student.assignments.report.pdf', request()->query()) }}" class="btn hero-btn fw-semibold px-4 pb-2 pt-2">
                            <i class="fas fa-file-pdf me-2"></i> Report
                        </a>
                        
                        <div class="dropdown">
                            <button class="btn btn-warning rounded-pill fw-bold px-4 pb-2 pt-2 shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bell me-2"></i> Reminders
                            </button>
                            <form class="dropdown-menu p-3 shadow border-0 rounded-4" method="POST" action="{{ route('student.assignments.reminders.send') }}">
                                @csrf
                                <h6 class="dropdown-header px-0 text-dark fw-bold">Email Reminders</h6>
                                <select name="days" class="form-select custom-select mb-3">
                                    <option value="3">Next 3 Days</option>
                                    <option value="7">Next 7 Days</option>
                                </select>
                                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold">Send Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="stat-grid">
            <div class="stat-card">
                <i class="fas fa-tasks stat-icon"></i>
                <div class="stat-value text-primary">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Tasks</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-clock stat-icon" style="color: var(--secondary)"></i>
                <div class="stat-value" style="color: var(--secondary)">{{ $stats['pending'] }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-check-circle stat-icon" style="color: var(--success)"></i>
                <div class="stat-value" style="color: var(--success)">{{ $stats['submitted'] }}</div>
                <div class="stat-label">Submitted</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-exclamation-triangle stat-icon" style="color: var(--danger)"></i>
                <div class="stat-value" style="color: var(--danger)">{{ $stats['overdue'] }}</div>
                <div class="stat-label">Overdue</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-bolt stat-icon" style="color: var(--warning)"></i>
                <div class="stat-value" style="color: var(--warning)">{{ $stats['critical'] }}</div>
                <div class="stat-label">Critical (< 2 Days)</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-chart-line stat-icon" style="color: var(--primary)"></i>
                <div class="stat-value text-dark">{{ is_null($stats['avg_score']) ? '-' : number_format($stats['avg_score'], 1) }}</div>
                <div class="stat-label">Avg Score</div>
            </div>
        </div>

        <!-- Next Deadline Alert -->
        @if($nextDeadline)
            @php $nextAssignment = $nextDeadline['assignment']; @endphp
            <div class="next-deadline-alert mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px;">
                            <i class="fas fa-stopwatch fa-lg"></i>
                        </div>
                        <div>
                            <span class="text-uppercase text-primary fw-bold" style="font-size: 0.75rem; letter-spacing: 1px;">Next Deadline</span>
                            <h5 class="mb-0 fw-bold text-dark mt-1">{{ $nextAssignment->title }}</h5>
                            <div class="text-muted small mt-1">Course: {{ $nextAssignment->course->title ?? 'N/A' }} &bull; <i class="fas fa-calendar-alt ms-1 me-1"></i> {{ optional($nextAssignment->due_date)->format('l, M d, Y \a\t h:i A') ?? 'N/A' }}</div>
                        </div>
                    </div>
                    @if(!is_null($nextDeadline['days_left']))
                        <div class="text-md-end">
                            <span class="badge bg-danger shadow-sm fs-6 px-4 py-2 rounded-pill">
                                <i class="fas fa-fire me-2"></i> {{ $nextDeadline['days_left'] }} day(s) left
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger rounded-4 border-0 shadow-sm" role="alert">
                <strong class="d-block mb-2"><i class="fas fa-times-circle me-2"></i> Submission failed:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Filters Form -->
        <div class="filter-section">
            <form method="GET" action="{{ route('student.assignments') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-xl-5">
                        <label for="q" class="form-label">Search Assignments</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted rounded-start-4"><i class="fas fa-search"></i></span>
                            <input type="text" id="q" name="q" class="form-control custom-input border-start-0 rounded-end-4" value="{{ $search }}" placeholder="Keywords, title...">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        <label for="course_id" class="form-label">Course</label>
                        <select id="course_id" name="course_id" class="form-select custom-select">
                            <option value="">All Courses</option>
                            @foreach($courseOptions as $course)
                                <option value="{{ $course->id }}" {{ (string) $courseId === (string) $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-2">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select custom-select">
                            <option value="">All</option>
                            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="submitted" {{ $status === 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="overdue" {{ $status === 'overdue' ? 'selected' : '' }}>Overdue</option>
                            <option value="late" {{ $status === 'late' ? 'selected' : '' }}>Late</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4 col-xl-2">
                        <div class="d-flex gap-2 h-100">
                            <button type="submit" class="btn btn-primary rounded-3 flex-grow-1 shadow-sm fw-bold"><i class="fas fa-filter me-2"></i>Apply</button>
                            <a href="{{ route('student.assignments') }}" class="btn btn-light border rounded-3 text-muted"><i class="fas fa-undo"></i></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Assignments Grid -->
        <div class="row g-4 mb-5">
            @forelse($assignmentCards as $card)
                @php
                    $assignment = $card['assignment'];
                    $submission = $card['submission'];
                    $statusKey = $card['status_key'];
                    
                    $badgeArray = match($statusKey) {
                        'submitted' => ['bg' => 'bg-success', 'icon' => 'fa-check'],
                        'late' => ['bg' => 'bg-warning', 'icon' => 'fa-clock'],
                        'overdue' => ['bg' => 'bg-danger', 'icon' => 'fa-exclamation-circle'],
                        default => ['bg' => 'bg-primary', 'icon' => 'fa-hourglass-half']
                    };
                    $columnClass = $view === 'compact' ? 'col-12 col-xl-6' : 'col-12';
                @endphp
                <div class="{{ $columnClass }}">
                    <div class="assignment-card">
                        <div class="card-ribbon"></div>
                        <div class="card-body-custom">
                            <div class="row g-4 flex-grow-1">
                                
                                <!-- Left side: Assignment Info -->
                                <div class="col-lg-7 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <div class="badge bg-light text-primary border mb-2 px-2 py-1"><i class="fas fa-book me-1"></i> {{ $assignment->course->title ?? 'General' }}</div>
                                            <h4 class="fw-bold mb-0 text-dark">{{ $assignment->title }}</h4>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 mb-4">
                                        <span class="meta-chip"><i class="fas fa-list-ol text-muted"></i> {{ optional(optional($assignment->course)->subject)->code ?? 'No Code' }}</span>
                                        <span class="meta-chip border-warning"><i class="fas fa-star text-warning"></i> {{ $assignment->max_marks }} Marks</span>
                                        <span class="meta-chip border-primary"><i class="fas fa-calendar-times text-primary"></i> Due: {{ optional($assignment->due_date)->format('M d, y') ?? 'None' }}</span>
                                        
                                        @if($card['priority'] === 'high')
                                            <span class="meta-chip text-white bg-danger border-danger fw-bold shadow-sm animation-pulse"><i class="fas fa-fire"></i> High Priority</span>
                                        @endif
                                        
                                        @if (!is_null($card['days_left']) && in_array($statusKey, ['pending', 'overdue'], true))
                                            @if($card['days_left'] >= 0)
                                                <span class="meta-chip text-primary bg-primary bg-opacity-10 border-0 fw-bold"><i class="fas fa-clock"></i> {{ $card['days_left'] }} day(s) left</span>
                                            @else
                                                <span class="meta-chip text-danger bg-danger bg-opacity-10 border-0 fw-bold"><i class="fas fa-exclamation-triangle"></i> {{ abs($card['days_left']) }} day(s) late</span>
                                            @endif
                                        @endif
                                    </div>

                                    <p class="text-muted mb-4 lh-lg flex-grow-1">
                                        {{ $assignment->description ?: 'No detailed description provided by the instructor.' }}
                                    </p>

                                    <!-- Interactive Planner / Notes -->
                                    <div class="editable-note-wrapper mt-auto">
                                        <div class="editable-note-header">
                                            <span class="fw-bold text-dark fs-6"><i class="fas fa-pen-nib text-secondary me-2"></i>My Private Assignment Notes</span>
                                            <span class="badge bg-white text-muted border shadow-sm px-2 py-1"><i class="fas fa-save me-1"></i> Auto-Saves</span>
                                        </div>
                                        <div class="editable-note-area bg-white" 
                                             contenteditable="true" 
                                             id="note_assign_{{ auth()->id() }}_{{ $assignment->id }}"
                                             data-placeholder="Click to type a study plan, reminder, or draft outline for this assignment... It will save automatically to your browser."></div>
                                    </div>
                                </div>

                                <!-- Right side: Submission Area -->
                                <div class="col-lg-5 d-flex flex-column border-lg-start ps-lg-4">
                                    <div class="d-flex justify-content-end mb-4">
                                        <span class="status-badge {{ $badgeArray['bg'] }} text-white shadow-sm px-4">
                                            <i class="fas {{ $badgeArray['icon'] }} me-1"></i> {{ ucfirst(str_replace('_', ' ', $statusKey)) }}
                                        </span>
                                    </div>
                                    
                                    <div class="submission-area flex-grow-1 d-flex flex-column justify-content-center">
                                        @if($submission)
                                            <div class="bg-light p-4 rounded-4 border">
                                                <h6 class="fw-bold text-dark mb-4 border-bottom pb-2"><i class="fas fa-file-invoice-dollar me-2 text-primary"></i> Receipt</h6>
                                                
                                                <div class="mb-3">
                                                    <div class="small fw-bold text-uppercase text-muted" style="letter-spacing: 0.5px; font-size: 0.7rem;">Time Submitted</div>
                                                    <div class="fw-semibold text-dark mt-1">{{ optional($submission->submitted_at)->format('D, M d, Y \a\t h:i A') ?? 'N/A' }}</div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <div class="small fw-bold text-uppercase text-muted" style="letter-spacing: 0.5px; font-size: 0.7rem;">Grading Result</div>
                                                    <div class="fw-semibold text-dark mt-1 fs-5">
                                                        @if(is_null($submission->marks_obtained))
                                                            <span class="text-warning"><i class="fas fa-spinner fa-spin me-1"></i> Pending Grade</span>
                                                        @else
                                                            <span class="text-success"><i class="fas fa-award me-1"></i> {{ $submission->marks_obtained }}/{{ $assignment->max_marks }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                @if($submission->feedback)
                                                    <div>
                                                        <div class="small fw-bold text-uppercase text-muted" style="letter-spacing: 0.5px; font-size: 0.7rem;">Feedback</div>
                                                        <div class="bg-white p-3 border rounded-3 small fst-italic mt-2 text-dark shadow-sm lh-lg">
                                                            "{{ $submission->feedback }}"
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <h6 class="fw-bold text-dark mb-3"><i class="fas fa-cloud-upload-alt text-primary me-2"></i> Submit Your Work Now</h6>
                                            <form method="POST" action="{{ route('student.assignments.submit', $assignment->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="file-input-wrapper">
                                                    <div class="file-drop-area">
                                                        <i class="fas fa-file-upload fa-3x text-muted mb-3 opacity-50"></i>
                                                        <h6 class="fw-bold mb-1">Upload Work File</h6>
                                                        <p class="small text-muted mb-0">Drag and drop or click</p>
                                                    </div>
                                                    <input type="file" name="file" required onchange="this.previousElementSibling.innerHTML = '<i class=\'fas fa-file-circle-check fa-3x text-success mb-3\'></i><h6 class=\'fw-bold text-success mb-1\'>Ready!</h6><p class=\'small text-dark fw-bold mb-0\'>' + this.files[0].name + '</p>'">
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <textarea name="comments" rows="2" class="form-control custom-input" placeholder="Any comments for the teacher? (Optional)"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100 rounded-pill shadow fw-bold py-2 fs-6 mt-2">
                                                    <i class="fas fa-paper-plane me-2"></i> Confirm Submission
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                        <div class="card-body py-5">
                            <i class="fas fa-clipboard-check fa-4x text-muted mb-3 opacity-50"></i>
                            <h4 class="fw-bold text-dark">You're all caught up!</h4>
                            <p class="text-muted mb-4 fs-5">No assignments found matching your current filters.</p>
                            <a href="{{ route('student.assignments') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                                <i class="fas fa-undo me-2"></i> Clear Filters
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Handle LocalStorage for Private Notes
        const editableNotes = document.querySelectorAll('.editable-note-area');
        
        editableNotes.forEach(field => {
            const storageKey = field.id;
            const savedNote = localStorage.getItem(storageKey);

            if (savedNote) {
                field.textContent = savedNote;
            }

            field.addEventListener('blur', function() {
                const content = this.textContent.trim();
                const placeholder = this.getAttribute('data-placeholder');
                
                if (content && content !== placeholder) {
                    localStorage.setItem(storageKey, content);
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Locally Saved',
                        text: 'Your notes are saved in your browser.',
                        showConfirmButton: false,
                        timer: 2000,
                        background: '#10b981',
                        color: '#fff'
                    });
                } else {
                    localStorage.removeItem(storageKey);
                }
            });

            // Handle enter key to add lines correctly instead of div tags in all browsers
            field.addEventListener('keypress', (e) => {
                if(e.which === 13) {
                    e.preventDefault();
                    document.execCommand('insertLineBreak');
                }
            });
        });
    });
</script>
@endsection
