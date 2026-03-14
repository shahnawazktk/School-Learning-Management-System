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

    .dashboard-container {
        max-width: 1440px;
        margin: 0 auto;
        padding-bottom: 3rem;
    }

    /* Hero Welcome Section */
    .welcome-hero {
        background: linear-gradient(135deg, #1e1b4b 0%, var(--primary) 100%);
        border-radius: 1.5rem;
        padding: 3rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .welcome-hero::before {
        content: ''; position: absolute; top: -50%; right: -10%;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .hero-stat-box {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1rem;
        padding: 1.25rem;
        text-align: center;
        transition: transform 0.3s;
    }
    .hero-stat-box:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.15);
    }
    .hero-stat-val { font-size: 2rem; font-weight: 800; line-height: 1; }
    .hero-stat-label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; margin-top: 5px; }

    /* Modern Cards */
    .modern-card {
        background: var(--card-bg);
        border-radius: 1.25rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .modern-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        border-color: #cbd5e1;
    }
    .card-header-styled {
        padding: 1.5rem 1.5rem 1rem 1.5rem;
        background: transparent;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-title-styled {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .card-body-styled { padding: 1.5rem; flex-grow: 1; }

    /* Quick Action Buttons */
    .quick-action-btn {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1rem;
        text-align: center;
        color: #475569;
        font-weight: 600;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        height: 100%;
        justify-content: center;
    }
    .quick-action-btn:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }
    .quick-action-btn:hover i { color: white !important; }
    .quick-action-btn i { font-size: 1.5rem; transition: color 0.3s; }

    /* Progress Indicators */
    .progress-custom {
        height: 8px;
        background-color: #e2e8f0;
        border-radius: 1rem;
        overflow: visible;
        margin-top: 10px;
    }
    .progress-custom .progress-bar {
        border-radius: 1rem;
        position: relative;
    }
    .progress-custom .progress-bar::after {
        content: '';
        position: absolute;
        right: 0; top: 50%;
        transform: translate(50%, -50%);
        width: 14px; height: 14px;
        background: white;
        border: 3px solid currentColor;
        border-radius: 50%;
    }

    /* List Items */
    .activity-item {
        padding: 1rem 0;
        border-bottom: 1px dashed #e2e8f0;
        display: flex;
        gap: 1rem;
        align-items: start;
    }
    .activity-item:last-child { border-bottom: none; padding-bottom: 0; }
    
    .activity-icon {
        width: 40px; height: 40px;
        border-radius: 0.75rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 1.2rem;
    }

    /* Editable Notepad section */
    .personal-notepad {
        background: #fffbeb; /* Light yellow tint */
        border: 1px solid #fde68a;
        border-radius: 1.25rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);
    }
    .notepad-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px dashed #fcd34d;
        display: flex; justify-content: space-between; align-items: center;
        background: rgba(255,255,255,0.4);
        border-radius: 1.25rem 1.25rem 0 0;
    }
    .notepad-body {
        padding: 1.5rem;
        flex-grow: 1;
        outline: none;
        color: #78350f;
        font-size: 1rem;
        line-height: 1.6;
        min-height: 200px;
        position: relative;
    }
    /* Ruled lines effect */
    .notepad-body {
        background-image: linear-gradient(transparent 95%, #fde68a 95%);
        background-size: 100% 1.6rem;
        background-attachment: local;
    }
    .notepad-body[data-placeholder]:empty:before {
        content: attr(data-placeholder);
        color: #d97706;
        font-style: italic;
        pointer-events: none;
        display: block;
    }

    @media (max-width: 992px) {
        .welcome-hero { padding: 2rem; }
    }
</style>

<div class="container-fluid py-4 dashboard-container">
    @php
        $totalSubjects = $enrollments->count();
        $pendingCount = $pendingAssignments->count();
        $recentSubmissionsCount = $recentSubmissions->count();
        $completionRate = $pendingCount + $recentSubmissionsCount > 0
            ? round(($recentSubmissionsCount / ($pendingCount + $recentSubmissionsCount)) * 100, 1)
            : 0;
    @endphp

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Welcome Hero -->
    <div class="welcome-hero">
        <div class="row align-items-center position-relative z-1">
            <div class="col-xl-6 mb-4 mb-xl-0 text-center text-xl-start">
                <span class="badge bg-white text-dark rounded-pill px-3 py-2 mb-3 fw-bold shadow-sm">
                    <i class="fas fa-calendar-alt text-primary me-2"></i> {{ now()->format('l, F j, Y') }}
                </span>
                <h1 class="display-5 fw-bold mb-2">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
                <p class="fs-5 opacity-75 mb-0">Here's your academic dashboard snapshot.</p>
            </div>
            <div class="col-xl-6">
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="hero-stat-box">
                            <div class="hero-stat-val text-info">{{ $attendancePercentage }}%</div>
                            <div class="hero-stat-label">Attendance</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="hero-stat-box">
                            <div class="hero-stat-val text-warning">{{ number_format($averageGrade, 1) }}%</div>
                            <div class="hero-stat-label">Avg Grade</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="hero-stat-box">
                            <div class="hero-stat-val text-success">{{ $recentSubmissionsCount }}</div>
                            <div class="hero-stat-label">Submitted</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="hero-stat-box">
                            <div class="hero-stat-val text-danger">{{ $pendingCount }}</div>
                            <div class="hero-stat-label">Pending</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('student.subjects') }}" class="quick-action-btn">
                <i class="fas fa-book-open text-primary mb-1"></i>
                <span>My Subjects</span>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('student.assignments') }}" class="quick-action-btn">
                <i class="fas fa-tasks text-success mb-1"></i>
                <span>Assignments</span>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('student.exams') }}" class="quick-action-btn">
                <i class="fas fa-file-signature text-danger mb-1"></i>
                <span>Examinations</span>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('student.resources') }}" class="quick-action-btn">
                <i class="fas fa-folder-open text-warning mb-1"></i>
                <span>Resources</span>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('student.fees') }}" class="quick-action-btn">
                <i class="fas fa-file-invoice-dollar text-info mb-1"></i>
                <span>Fee Panel</span>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('student.profile') }}" class="quick-action-btn">
                <i class="fas fa-user-circle text-secondary mb-1"></i>
                <span>My Profile</span>
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4" style="align-items: stretch;">
        <!-- Left Column: Finances & Progress -->
        <div class="col-xl-8 d-flex flex-column gap-4">
            
            <div class="row g-4 flex-grow-1">
                <!-- Financials Panel -->
                <div class="col-md-6 d-flex flex-column">
                    <div class="modern-card flex-grow-1">
                        <div class="card-header-styled">
                            <h2 class="card-title-styled"><i class="fas fa-wallet text-success"></i> Financial Status</h2>
                            <a href="{{ route('student.fees') }}" class="btn btn-sm btn-light border rounded-pill text-muted px-3 fw-bold shadow-sm">Pay Now</a>
                        </div>
                        <div class="card-body-styled d-flex flex-column justify-content-center">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted fw-bold text-uppercase" style="font-size: 0.75rem;">Outstanding Balance</span>
                            </div>
                            <h3 class="fw-bold text-dark mb-4 mt-1 display-6">Rs. {{ number_format($outstandingAmount, 2) }}</h3>
                            
                            <div class="d-flex justify-content-between small text-muted mb-2 fw-semibold">
                                <span>Total Billed: Rs. {{ number_format($totalFeeAmount, 2) }}</span>
                                <span>Paid: Rs. {{ number_format($totalPaidAmount, 2) }}</span>
                            </div>
                            
                            @php
                                $feeProgress = $totalFeeAmount > 0 ? ($totalPaidAmount / $totalFeeAmount) * 100 : 100;
                                $feeColor = $outstandingAmount > 0 ? '#ef4444' : '#10b981';
                            @endphp
                            <div class="progress-custom">
                                <div class="progress-bar" style="width: {{ $feeProgress }}%; background-color: {{ $feeColor }}; border-color: {{ $feeColor }};"></div>
                            </div>
                            
                            @if($dueFeesCount > 0)
                                <div class="mt-4 p-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-4 d-flex align-items-center gap-3">
                                    <div class="bg-danger text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="fas fa-exclamation"></i></div>
                                    <div class="small fw-bold text-danger">You have {{ $dueFeesCount }} pending fee invoice(s).</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Assignment Completion Rate -->
                <div class="col-md-6 d-flex flex-column">
                    <div class="modern-card flex-grow-1">
                        <div class="card-header-styled">
                            <h2 class="card-title-styled"><i class="fas fa-chart-line text-primary"></i> Task Tracker</h2>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 rounded-pill fw-bold">{{ $completionRate }}% Done</span>
                        </div>
                        <div class="card-body-styled d-flex flex-column justify-content-center">
                            
                            <!-- Donut Chart Canvas Container (Optional: can use Chart.js or just pure CSS if preferred. Using pure CSS here for cleaner UI matching the assignments page style) -->
                            <div class="d-flex flex-column align-items-center mb-4">
                                <!-- Circular progress -->
                                <div class="position-relative d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; border-radius: 50%; background: conic-gradient(var(--primary) {{ $completionRate }}%, #e2e8f0 0);">
                                    <div class="position-absolute bg-white rounded-circle d-flex align-items-center justify-content-center flex-column shadow-sm" style="width: 90px; height: 90px; inset: auto;">
                                        <span class="fs-4 fw-bold text-dark lh-1">{{ $completionRate }}%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row text-center mt-auto bg-light rounded-4 p-3 border">
                                <div class="col-6 border-end">
                                    <div class="fs-3 fw-bold text-success">{{ $recentSubmissionsCount }}</div>
                                    <div class="small text-muted text-uppercase fw-bold" style="font-size:0.65rem;">Completed</div>
                                </div>
                                <div class="col-6">
                                    <div class="fs-3 fw-bold text-danger">{{ $pendingCount }}</div>
                                    <div class="small text-muted text-uppercase fw-bold" style="font-size:0.65rem;">Todo</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Assignments List -->
            <div class="modern-card flex-grow-1">
                <div class="card-header-styled border-bottom bg-light bg-opacity-50">
                    <h2 class="card-title-styled"><i class="fas fa-fire text-danger"></i> Action Required: Assignments Due</h2>
                    <a href="{{ route('student.assignments') }}" class="btn btn-sm btn-white border px-3 fw-bold text-primary rounded-pill shadow-sm">Open Hub</a>
                </div>
                <div class="card-body-styled p-0">
                    @if($pendingCount > 0)
                        <div class="px-4 py-2">
                            @foreach($pendingAssignments as $assignment)
                                @php
                                    $dueDate = $assignment->due_date;
                                    $daysLeft = $dueDate ? now()->diffInDays($dueDate, false) : null;
                                @endphp
                                <div class="activity-item py-3">
                                    <div class="activity-icon bg-warning bg-opacity-10 text-warning shadow-sm border border-warning border-opacity-25">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="mb-0 fw-bold text-dark">{{ $assignment->title }}</h6>
                                            @if(!is_null($daysLeft))
                                                <span class="badge {{ $daysLeft < 0 ? 'bg-danger text-white' : ($daysLeft <= 2 ? 'bg-warning text-dark border border-warning' : 'bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25') }} rounded-pill px-3 shadow-sm">
                                                    {{ $daysLeft < 0 ? 'Overdue' : ($daysLeft === 0 ? 'Due Today' : $daysLeft . ' Days Rem') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="small fw-semibold text-muted mb-1">{{ $assignment->course->title ?? 'N/A' }}</div>
                                        <div class="small fw-bold text-primary"><i class="fas fa-clock me-1"></i> Ends: {{ $dueDate ? $dueDate->format('M d, y') : 'No Date' }}</div>
                                    </div>
                                    <div class="ms-3 align-self-center">
                                        <a href="{{ route('student.assignments.submit', $assignment->id) }}" class="btn btn-sm btn-primary rounded-pill fw-bold shadow-sm px-3">Start</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="d-inline-flex bg-success bg-opacity-10 text-success p-4 rounded-circle mb-3 shadow-sm border border-success border-opacity-25">
                                <i class="fas fa-glass-cheers fa-3x"></i>
                            </div>
                            <h5 class="fw-bold text-dark">You're completely caught up!</h5>
                            <p class="text-muted mb-0 fs-6">No pending assignments at the moment. Take a break.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar -->
        <div class="col-xl-4 d-flex flex-column gap-4">
            
            <!-- Editable Notepad -->
            <div class="flex-grow-1" style="min-height: 250px;">
                <div class="personal-notepad shadow-sm h-100">
                    <div class="notepad-header">
                        <h2 class="card-title-styled m-0 text-warning" style="text-shadow: 1px 1px 0px rgba(255,255,255,0.8);"><i class="fas fa-pen-nib me-2"></i>My Study Notes</h2>
                        <span class="badge bg-white text-muted border border-warning px-2 py-1 shadow-sm"><i class="fas fa-cloud-arrow-up me-1"></i> Auto-saves</span>
                    </div>
                    <div class="notepad-body p-4" 
                         contenteditable="true" 
                         id="student_dash_notes_{{ Auth::id() }}"
                         data-placeholder="Start typing... Use this space for quick reminders, daily study goals, or to-do lists. Text saves securely in your local browser automatically."></div>
                </div>
            </div>

            <!-- Recent Activity / Submissions -->
            <div class="modern-card flex-grow-1">
                <div class="card-header-styled bg-light bg-opacity-50 border-bottom">
                    <h2 class="card-title-styled"><i class="fas fa-history text-secondary"></i> Last Submissions</h2>
                </div>
                <div class="card-body-styled p-0" style="max-height: 400px; overflow-y: auto;">
                    @if($recentSubmissionsCount > 0)
                        <div class="px-4 py-2">
                            @foreach($recentSubmissions as $submission)
                                <div class="activity-item py-3">
                                    <div class="activity-icon bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2 overflow-hidden">
                                        <h6 class="mb-1 fw-bold text-dark text-truncate">{{ $submission->assignment->title ?? 'N/A' }}</h6>
                                        <div class="small fw-semibold text-muted mb-2"><i class="fas fa-calendar-check me-1"></i> {{ optional($submission->submitted_at ?? $submission->created_at)->format('M d, y') ?? 'N/A' }}</div>
                                        
                                        @if(!is_null($submission->marks_obtained))
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 shadow-sm fw-bold"><i class="fas fa-award me-1"></i> Result: {{ $submission->marks_obtained }}/{{ $submission->assignment->max_marks ?? 100 }}</span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1 shadow-sm fw-bold"><i class="fas fa-search me-1"></i> Under Review</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3 opacity-25"></i>
                            <p class="text-muted small mb-0 fw-bold">No recent submissions found.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <!-- Enrolled Subjects Strip -->
    <div class="row mt-2">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header-styled bg-light bg-opacity-50">
                    <h2 class="card-title-styled"><i class="fas fa-graduation-cap text-primary"></i> Current Enrollments</h2>
                    <a href="{{ route('student.subjects') }}" class="btn btn-sm btn-primary rounded-pill px-4 fw-bold shadow-sm">Manage</a>
                </div>
                <div class="card-body-styled p-4">
                    @if($totalSubjects > 0)
                        <div class="row g-4">
                            @foreach($enrollments as $enrollment)
                                <div class="col-md-4 col-xl-3">
                                    @php
                                        $status = strtolower((string) $enrollment->status);
                                        $badgeClass = $status === 'completed' ? 'bg-success' : ($status === 'dropped' ? 'bg-danger' : 'bg-primary');
                                    @endphp
                                    <div class="card bg-white border border-light shadow-sm h-100 rounded-4 text-center p-4" style="transition: transform 0.2s;">
                                        <div class="mb-3">
                                            <div class="d-inline-flex bg-primary bg-opacity-10 text-primary p-3 rounded-circle border border-primary border-opacity-25 shadow-sm">
                                                <i class="fas fa-laptop-code fa-lg"></i>
                                            </div>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1 fs-5">{{ $enrollment->course->title ?? $enrollment->subject->name ?? 'N/A' }}</h6>
                                        <div class="text-muted small mb-4 fw-bold">ID: <span class="text-primary">{{ optional($enrollment->subject)->code ?? 'GEN-100' }}</span></div>
                                        <div class="mt-auto">
                                            <span class="badge {{ $badgeClass }} bg-opacity-10 text-{{ str_replace('bg-', '', $badgeClass) }} border border-{{ str_replace('bg-', '', $badgeClass) }} w-100 py-2 fs-6 rounded-pill">
                                                {{ ucfirst($enrollment->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted fw-bold mb-0">You are not currently enrolled in any subjects.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Editable Dashboard Notepad Logic
        const notepad = document.getElementById('student_dash_notes_{{ Auth::id() }}');
        if (notepad) {
            const storageKey = 'dash_notepad_student_v2_{{ Auth::id() }}';
            const savedContent = localStorage.getItem(storageKey);

            if (savedContent) {
                notepad.innerHTML = savedContent;
            }

            notepad.addEventListener('blur', function() {
                const content = this.innerHTML.trim();
                
                if (content && content !== '<br>') {
                    localStorage.setItem(storageKey, content);
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: 'success',
                        title: 'Notes Saved!',
                        showConfirmButton: false,
                        timer: 1500,
                        background: '#10b981',
                        color: '#fff'
                    });
                } else {
                    localStorage.removeItem(storageKey);
                }
            });
            
            // Format shortcuts for the notepad
            notepad.addEventListener('keydown', function(e) {
                // Command/Ctrl + B for Bold
                if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                    e.preventDefault();
                    document.execCommand('bold', false, null);
                }
                // Command/Ctrl + I for Italic
                if ((e.ctrlKey || e.metaKey) && e.key === 'i') {
                    e.preventDefault();
                    document.execCommand('italic', false, null);
                }
                // Enter behavior for clean lines
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.execCommand('insertLineBreak');
                }
            });
        }
    });
</script>
@endsection
