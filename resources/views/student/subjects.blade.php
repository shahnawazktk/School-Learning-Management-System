@extends('layouts.student.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    :root {
        --primary: #4f46e5;
        --secondary: #0ea5e9;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #0f172a;
        --bg: #f8fafc;
        --card-bg: #ffffff;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg);
        color: #334155;
    }

    .subjects-container {
        max-width: 1440px;
        margin: 0 auto;
        padding-bottom: 3rem;
    }

    /* Hero Section */
    .subjects-hero {
        background: linear-gradient(135deg, #1e1b4b 0%, var(--primary) 100%);
        border-radius: 1.5rem;
        padding: 3rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .subjects-hero::before {
        content: ''; position: absolute; top: -50%; right: -10%;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .stat-box-modern {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1.25rem;
        padding: 1.25rem;
        text-align: center;
        transition: transform 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .stat-box-modern:hover { transform: translateY(-5px); background: rgba(255, 255, 255, 0.15); }
    .stat-box-val { font-size: 1.75rem; font-weight: 800; line-height: 1; margin-bottom: 0.25rem; }
    .stat-box-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.9; font-weight: 600; }

    /* Modern Subject Cards */
    .subject-card {
        background: var(--card-bg);
        border-radius: 1.25rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        position: relative;
    }
    .subject-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 5px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
    }
    .subject-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 20px -5px rgba(0,0,0,0.1);
        border-color: #cbd5e1;
    }
    
    .subject-card-body { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; }
    
    .subject-header-icon {
        width: 48px; height: 48px;
        border-radius: 1rem;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; color: var(--primary);
        flex-shrink: 0;
    }

    .subject-meta-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1rem;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }

    .progress-custom {
        height: 8px;
        background-color: #e2e8f0;
        border-radius: 1rem;
        overflow: visible;
    }
    .progress-custom .progress-bar { border-radius: 1rem; position: relative; }
    .progress-custom .progress-bar::after {
        content: ''; position: absolute; right: 0; top: 50%;
        transform: translate(50%, -50%);
        width: 14px; height: 14px; background: white; border: 3px solid currentColor; border-radius: 50%;
    }

    .deadline-alert {
        background: #fee2e2; border-left: 4px solid #ef4444; border-radius: 0.5rem; padding: 0.75rem;
    }

    /* Filters Box */
    .filter-panel {
        background: white; border-radius: 1.25rem; padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;
        margin-bottom: 2rem;
    }

    /* Study Notes Sidebar */
    .study-notepad {
        background: #fffbeb; border: 1px solid #fde68a; border-radius: 1.25rem;
        height: 100%; display: flex; flex-direction: column;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
    }
    .study-notepad-header {
        padding: 1rem 1.5rem; border-bottom: 1px dashed #fcd34d;
        display: flex; justify-content: space-between; align-items: center;
        background: rgba(255,255,255,0.4); border-radius: 1.25rem 1.25rem 0 0;
    }
    .study-notepad-body {
        padding: 1.5rem; flex-grow: 1; outline: none;
        color: #78350f; font-size: 1rem; line-height: 1.6; min-height: 300px;
        background-image: linear-gradient(transparent 95%, #fde68a 95%);
        background-size: 100% 1.6rem; background-attachment: local;
    }
    .study-notepad-body[data-placeholder]:empty:before {
        content: attr(data-placeholder); color: #d97706; font-style: italic; pointer-events: none; display: block;
    }

    /* Sub-containers */
    .section-card {
        background: white; border-radius: 1.25rem; border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 2rem;
    }
    .section-header {
        padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9;
        display: flex; justify-content: space-between; align-items: center; bg-color: transparent;
    }
    
    @media (max-width: 992px) {
        .subjects-hero { padding: 2rem; }
        .stat-box-modern { padding: 1rem; }
    }
</style>

<div class="container-fluid py-4 subjects-container">

    <!-- Hero Overview -->
    <div class="subjects-hero">
        <div class="row align-items-center position-relative z-1 g-4">
            <div class="col-xl-6 text-center text-xl-start">
                <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-2 mb-3 fw-bold border border-white border-opacity-25 shadow-sm">
                    <i class="fas fa-graduation-cap me-2"></i> Academic Dashboard
                </span>
                <h1 class="display-5 fw-bold mb-3">My Enrolled Subjects</h1>
                <p class="fs-5 opacity-75 mb-0">Track your courses, overall progress, and assignment completion from one comprehensive dashboard.</p>
                <div class="d-flex flex-wrap gap-2 mt-4 justify-content-center justify-content-xl-start">
                    <a href="{{ route('student.subjects.export', request()->query()) }}" class="btn btn-light fw-bold rounded-pill shadow-sm px-4">
                        <i class="fas fa-file-csv me-1"></i> Export Data
                    </a>
                    <a href="{{ route('student.subjects.report.pdf', request()->query()) }}" class="btn btn-outline-light border-2 fw-bold rounded-pill px-4">
                        <i class="fas fa-file-pdf me-1"></i> Download PDF Report
                    </a>
                </div>
            </div>
            
            <div class="col-xl-6">
                <!-- Stats Grid inside Hero -->
                <div class="row g-2 g-md-3">
                    <div class="col-6 col-md-3">
                        <div class="stat-box-modern">
                            <div class="stat-box-val text-white">{{ $stats['active_subjects'] }}<span class="fs-6 opacity-50 fw-normal">/{{ $stats['total_subjects'] }}</span></div>
                            <div class="stat-box-label text-white">Active</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box-modern">
                            <div class="stat-box-val" style="color: #6ee7b7;">{{ $stats['average_progress'] }}%</div>
                            <div class="stat-box-label text-white">Avg Progress</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box-modern">
                            <div class="stat-box-val" style="color: #fca5a5;">{{ $stats['urgent_subjects'] }}</div>
                            <div class="stat-box-label text-white">Urgent Setup</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="stat-box-modern">
                            <div class="stat-box-val" style="color: #93c5fd;">{{ $stats['total_credits'] }}</div>
                            <div class="stat-box-label text-white">Credits</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if($stats['at_risk'] > 0 || $stats['urgent_subjects'] > 0)
    <div class="row g-3 mb-4">
        @if($stats['at_risk'] > 0)
        <div class="col-md-6">
            <div class="alert alert-warning border border-warning border-opacity-25 shadow-sm d-flex align-items-center rounded-4 m-0" role="alert">
                <div class="bg-warning text-dark rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fas fa-exclamation-triangle fa-lg"></i></div>
                <div>
                    <strong class="d-block">Attention Needed</strong>
                    <span class="small">{{ $stats['at_risk'] }} subject(s) have low completion (&lt; 50%). Focus on pending tasks.</span>
                </div>
            </div>
        </div>
        @endif
        @if($stats['urgent_subjects'] > 0)
        <div class="col-md-6">
            <div class="alert alert-danger border border-danger border-opacity-25 shadow-sm d-flex align-items-center rounded-4 m-0" role="alert">
                <div class="bg-danger text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fas fa-bell fa-lg"></i></div>
                <div>
                    <strong class="d-block">Urgent Deadlines</strong>
                    <span class="small">{{ $stats['urgent_subjects'] }} subject(s) need immediate attention due to upcoming deadlines.</span>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <div class="row g-4" style="align-items: stretch;">
        
        <!-- Left Column: Main Content Area -->
        <div class="col-xl-9 d-flex flex-column">

            <!-- Filter Panel -->
            <div class="filter-panel">
                <form method="GET" action="{{ route('student.subjects') }}" class="row g-3">
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-1"><i class="fas fa-search me-1"></i> Search Subject</label>
                        <div class="input-group input-group-sm rounded-3 shadow-sm overflow-hidden border">
                            <span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="q" value="{{ $search }}" class="form-control border-0 shadow-none" placeholder="e.g. Mathematics, ENG101">
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-1">Status</label>
                        <select name="status" class="form-select form-select-sm shadow-sm border-light bg-light">
                            <option value="">All</option>
                            <option value="enrolled" {{ $status === 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                            <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="dropped" {{ $status === 'dropped' ? 'selected' : '' }}>Dropped</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-1">Deadline</label>
                        <select name="deadline_window" class="form-select form-select-sm shadow-sm border-light bg-light">
                            <option value="">All Time</option>
                            <option value="today" {{ $deadlineWindow === 'today' ? 'selected' : '' }}>Due Today</option>
                            <option value="next_3" {{ $deadlineWindow === 'next_3' ? 'selected' : '' }}>Next 3 Days</option>
                            <option value="next_7" {{ $deadlineWindow === 'next_7' ? 'selected' : '' }}>Next 7 Days</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-1">Sort Rule</label>
                        <select name="sort" class="form-select form-select-sm shadow-sm border-light bg-light">
                            <option value="progress_desc" {{ $sort === 'progress_desc' ? 'selected' : '' }}>Progress: High-Low</option>
                            <option value="progress_asc" {{ $sort === 'progress_asc' ? 'selected' : '' }}>Progress: Low-High</option>
                            <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name: A-Z</option>
                            <option value="next_due" {{ $sort === 'next_due' ? 'selected' : '' }}>Next Due</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-2 d-flex align-items-end">
                        <div class="w-100 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm flex-grow-1 fw-bold rounded-pill shadow-sm"><i class="fas fa-filter"></i> Apply</button>
                            <a href="{{ route('student.subjects') }}" class="btn btn-light btn-sm fw-bold border rounded-pill" data-bs-toggle="tooltip" title="Reset Filters"><i class="fas fa-undo"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Subject Cards Grid -->
            <h4 class="fw-bold mb-3 d-flex align-items-center gap-2"><i class="fas fa-book-open text-primary"></i> Your Subjects <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill fs-6 px-3 shadow-sm">{{ $subjectCards->count() }} Available</span></h4>
            
            <div class="row g-4 flex-grow-1">
                @forelse($subjectCards as $card)
                    @php
                        $enrollment = $card['enrollment'];
                        $course = $card['course'];
                        $subject = $card['subject'];
                        $teacher = $card['teacher'];
                        $statusClass = match(strtolower($enrollment->status)) {
                            'completed' => 'success',
                            'dropped' => 'danger',
                            default => 'primary'
                        };
                        $courseTitle = $course->title ?? $subject->name ?? 'Untitled Subject';
                        
                        $riskColor = match($card['risk_level']) {
                            'high' => 'danger',
                            'medium' => 'warning',
                            default => 'success',
                        };
                    @endphp
                    
                    <div class="col-md-6 col-lg-6 col-xxl-4">
                        <div class="subject-card">
                            <div class="subject-card-body">
                                
                                <!-- Header row -->
                                <div class="d-flex justify-content-between align-items-start mb-3 border-bottom pb-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="subject-header-icon bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} border border-{{ $statusClass }} border-opacity-25">
                                            <i class="fas fa-laptop-code"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold text-dark m-0 pb-1" style="line-height: 1.2;">{{ Str::limit($courseTitle, 35) }}</h5>
                                            <span class="badge bg-light text-muted border text-uppercase" style="font-size: 0.65rem;">{{ $subject->code ?? 'No CODE' }} | {{ $subject->credits ?? 0 }} CR</span>
                                        </div>
                                    </div>
                                    <span class="badge bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} border border-{{ $statusClass }} border-opacity-25 rounded-pill shadow-sm">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between small fw-bold mb-1">
                                        <span class="text-muted text-uppercase" style="font-size:0.7rem;">Course Completion</span>
                                        <span class="text-{{ $statusClass }}">{{ $card['completion'] }}%</span>
                                    </div>
                                    <div class="progress-custom mb-1">
                                        <div class="progress-bar bg-{{ $statusClass }}" style="width: {{ $card['completion'] }}%; border-color: var(--{{ $statusClass }});"></div>
                                    </div>
                                </div>

                                <!-- Smart Metadata Box -->
                                <div class="subject-meta-box">
                                    <div class="row g-2 small">
                                        <div class="col-6">
                                            <div class="text-muted mb-1" style="font-size: 0.7rem; text-transform:uppercase; font-weight:700;"><i class="fas fa-chalkboard-teacher me-1"></i> Instructor</div>
                                            <div class="fw-bold text-dark text-truncate">{{ $teacher->name ?? 'TBA' }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted mb-1" style="font-size: 0.7rem; text-transform:uppercase; font-weight:700;"><i class="fas fa-tasks me-1"></i> Assignment Tasks</div>
                                            <div class="fw-bold text-dark">{{ $card['submitted_assignments'] }}/{{ $card['total_assignments'] }} Done <span class="text-danger">({{ $card['remaining_assignments'] }} Rem)</span></div>
                                        </div>
                                    </div>
                                    <hr class="my-2 opacity-10">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex gap-2">
                                            <span class="badge bg-{{$riskColor}} bg-opacity-10 text-{{$riskColor}} border border-{{$riskColor}} border-opacity-25" data-bs-toggle="tooltip" title="Risk Level"><i class="fas fa-shield-alt"></i> {{ ucfirst($card['risk_level']) }}</span>
                                            <span class="badge bg-light text-dark border"><i class="fas fa-clock text-muted"></i> {{ $card['recommended_hours'] }}h/wk</span>
                                        </div>
                                        <span class="small text-muted fw-bold">W-Score: {{ $card['workload_score'] }}</span>
                                    </div>
                                </div>

                                <!-- Assignment Deadline Alert if exists -->
                                @if($card['next_due'])
                                    <div class="deadline-alert mb-3 d-flex flex-column gap-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="small fw-bold text-danger text-uppercase" style="font-size:0.65rem;">Next Due Task</span>
                                            @if(!is_null($card['days_left']))
                                                <span class="badge bg-danger rounded-pill shadow-sm" style="font-size:0.65rem;">{{ $card['days_left'] == 0 ? 'Today!' : $card['days_left']." Days" }}</span>
                                            @endif
                                        </div>
                                        <div class="fw-bold text-dark small text-truncate">{{ $card['next_due']->title }}</div>
                                        <div class="small fw-semibold text-danger"><i class="fas fa-calendar-times me-1"></i> {{ $card['next_due']->due_date->format('M d, Y') }}</div>
                                    </div>
                                @else
                                    <div class="bg-light rounded-3 p-3 mb-3 text-center border">
                                        <i class="fas fa-check-circle text-success mb-1"></i>
                                        <div class="small fw-bold text-muted">No pending deadlines</div>
                                    </div>
                                @endif

                                <!-- Actions -->
                                <div class="mt-auto pt-2 row g-2">
                                    <div class="col-6">
                                        <a href="{{ route('student.assignments', ['course_id' => $course->id ?? null]) }}" class="btn btn-primary w-100 fw-bold rounded-pill shadow-sm py-2">
                                            <i class="fas fa-tasks me-1"></i> Tasks
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('student.resources') }}" class="btn btn-light border w-100 fw-bold text-secondary rounded-pill shadow-sm py-2">
                                            <i class="fas fa-archive me-1"></i> Material
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 text-center py-5 bg-white border">
                            <div class="d-inline-flex bg-light text-muted p-4 rounded-circle mb-3 border shadow-sm">
                                <i class="fas fa-book-open fa-3x opacity-50"></i>
                            </div>
                            <h5 class="fw-bold text-dark">No Subjects Found</h5>
                            <p class="text-muted mb-4">Try adjusting your filters or contact your admin if your enrollments seem missing.</p>
                            <a href="{{ route('student.subjects') }}" class="btn btn-primary rounded-pill fw-bold shadow-sm px-4">
                                <i class="fas fa-rotate-right me-1"></i> Reset Filters
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- Analytics Area Below Listing -->
            <div class="row g-4 mt-2">
                
                <!-- Smart Planner -->
                <div class="col-xl-6">
                    <div class="section-card h-100 mb-0">
                        <div class="section-header">
                            <h5 class="fw-bold m-0"><i class="fas fa-brain text-secondary me-2"></i>Smart Study Planner</h5>
                            <span class="badge bg-secondary rounded-pill px-3">{{ $studyPlanner->count() }} Focus Items</span>
                        </div>
                        <div class="card-body p-0">
                            @if($studyPlanner->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fas fa-check-double fa-2x text-success mb-2 opacity-75"></i>
                                    <p class="text-muted mb-0 small fw-bold">Your schedule looks clear!</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0 text-dark">
                                        <thead class="table-light text-uppercase small" style="font-size:0.75rem;">
                                            <tr>
                                                <th class="ps-4">Target Course</th>
                                                <th>Risk</th>
                                                <th>Load</th>
                                                <th class="pe-4">Next Due</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($studyPlanner as $plan)
                                                @php
                                                    $riskBadge = match($plan['risk_level']) {
                                                        'high' => 'bg-danger',
                                                        'medium' => 'bg-warning text-dark',
                                                        default => 'bg-success',
                                                    };
                                                    $plannerTitle = $plan['course']->title ?? $plan['subject']->name ?? 'Untitled';
                                                @endphp
                                                <tr>
                                                    <td class="ps-4 fw-bold small text-truncate" style="max-width: 150px;">{{ $plannerTitle }}</td>
                                                    <td><span class="badge {{ $riskBadge }} rounded-pill" style="font-size:0.65rem;">{{ ucfirst($plan['risk_level']) }}</span></td>
                                                    <td class="small fw-semibold text-muted">{{ $plan['workload_score'] }}/10</td>
                                                    <td class="pe-4 small">
                                                        @if($plan['next_due'])
                                                            <div class="fw-bold text-danger"><i class="fas fa-clock fs-8 me-1"></i>{{ $plan['next_due']->due_date->format('M d') }}</div>
                                                        @else
                                                            <span class="text-muted fst-italic">None</span>
                                                        @endif
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

                <!-- Subject Trend Chart -->
                <div class="col-xl-6">
                    <div class="section-card h-100 mb-0">
                        <div class="section-header">
                            <h5 class="fw-bold m-0"><i class="fas fa-chart-bar text-info me-2"></i>Performance Trend</h5>
                            <span class="badge bg-info text-dark rounded-pill shadow-sm"><i class="fas fa-eye me-1"></i> Visualizer</span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column justify-content-center">
                            <div style="height: 250px; width: 100%;">
                                <canvas id="subjectsTrendChart"></canvas>
                            </div>
                            <p class="small text-muted mb-0 mt-3 text-center fw-semibold">
                                Visual relationship between assignment submission count & overall subject progress percentage.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Right Column: Sidebar Notepad Area -->
        <div class="col-xl-3 d-flex flex-column gap-4 mt-4 mt-xl-0 border-start ps-xl-4 bg-white" style="border-radius:0 1.5rem 1.5rem 0;">
            <div class="sticky-top pt-xl-4 pb-4" style="top: 0; z-index: 10; height: 100vh;">
                <div class="study-notepad mb-0 h-100 border-0 shadow-none bg-transparent">
                    <div class="study-notepad-header bg-transparent px-0 border-bottom border-warning">
                        <h5 class="fw-bold m-0 text-warning" style="text-shadow: 1px 1px 0px rgba(0,0,0,0.1);"><i class="fas fa-sticky-note me-2"></i>My Term Goals</h5>
                        <span class="badge bg-warning bg-opacity-10 text-dark border border-warning px-2 py-1 shadow-sm"><i class="fas fa-save me-1"></i> Auto-saves locally</span>
                    </div>
                    <div class="study-notepad-body px-1 py-3" 
                         contenteditable="true" 
                         id="student_subjects_notes_{{ Auth::id() }}"
                         data-placeholder="Write down your overarching goals for the semester, target grades to hit, or major subjects you want to focus primarily on. This note stays strictly on your local browser area."></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // --- Chart Logic ---
        const canvas = document.getElementById('subjectsTrendChart');
        if (canvas && typeof Chart !== 'undefined') {
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
                            backgroundColor: 'rgba(79, 70, 229, 0.7)', // Primary
                            borderRadius: 6,
                            borderSkipped: false,
                            yAxisID: 'yProgress'
                        },
                        {
                            type: 'line',
                            label: 'Submitted Tasks',
                            data: submittedData,
                            borderColor: 'rgba(16, 185, 129, 1)', // Success
                            backgroundColor: 'rgba(16, 185, 129, 0.2)',
                            pointBackgroundColor: '#fff',
                            pointBorderColor: 'rgba(16, 185, 129, 1)',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            tension: 0.3,
                            fill: true,
                            yAxisID: 'yAssignments'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 10, font: {family: "'Inter', sans-serif"} } },
                        tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.9)', padding: 10, borderRadius: 8 }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        yProgress: {
                            position: 'left', min: 0, max: 100,
                            grid: { borderDash: [4, 4] },
                            ticks: { callback: (value) => value + '%', font: {family: "'Inter', sans-serif"} }
                        },
                        yAssignments: {
                            position: 'right', min: 0, max: maxAssignments,
                            grid: { drawOnChartArea: false },
                            ticks: { font: {family: "'Inter', sans-serif"} }
                        }
                    }
                }
            });
        }

        // --- Editable Notes Logic ---
        const notepad = document.getElementById('student_subjects_notes_{{ Auth::id() }}');
        if (notepad) {
            const storageKey = 'subjects_notepad_student_v2_{{ Auth::id() }}';
            const savedContent = localStorage.getItem(storageKey);

            if (savedContent) {
                notepad.innerHTML = savedContent;
            }

            notepad.addEventListener('blur', function() {
                const content = this.innerHTML.trim();
                
                if (content && content !== '<br>' && content !== '<div><br></div>') {
                    localStorage.setItem(storageKey, content);
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Goals Saved!',
                        showConfirmButton: false,
                        timer: 1500,
                        background: '#10b981',
                        color: '#fff'
                    });
                } else {
                    localStorage.removeItem(storageKey);
                }
            });

            // Format shortcuts
            notepad.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'b') { e.preventDefault(); document.execCommand('bold', false, null); }
                if ((e.ctrlKey || e.metaKey) && e.key === 'i') { e.preventDefault(); document.execCommand('italic', false, null); }
                if (e.key === 'Enter') { e.preventDefault(); document.execCommand('insertLineBreak'); }
            });
            
            // Enable tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        }
    });
</script>
@endsection
