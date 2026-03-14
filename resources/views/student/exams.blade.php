@extends('layouts.student.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Fonts and Icons -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f3f4f6;
    }
    .exams-shell {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Premium Hero Section */
    .exams-hero {
        border-radius: 1.25rem;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.5);
        position: relative;
        overflow: hidden;
    }
    .exams-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        pointer-events: none;
    }
    .exams-hero .hero-title {
        font-weight: 800;
        letter-spacing: -0.025em;
    }

    /* Modern Stat Cards */
    .stat-card-glass {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stat-card-glass:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .icon-upcoming { background: #eff6ff; color: #3b82f6; }
    .icon-completed { background: #f0fdf4; color: #22c55e; }
    .icon-graded { background: #fffbeb; color: #f59e0b; }
    .icon-average { background: #fdf2f8; color: #ec4899; }

    /* Next Exam Alert */
    .next-exam-alert {
        background: white;
        border-left: 5px solid #3b82f6;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    /* Custom Table */
    .custom-table-card {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        background: #fff;
    }
    .table>thead {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    .table>thead th {
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 1rem;
    }
    .table>tbody>tr {
        transition: all 0.2s;
    }
    .table>tbody>tr:hover {
        background-color: #f8fafc;
        transform: scale(1.002);
    }
    .table>tbody td {
        padding: 1rem;
        color: #334155;
        vertical-align: middle;
    }

    /* Editable Field Styles */
    .editable-field {
        min-height: 40px;
        padding: 8px 12px;
        border: 2px dashed transparent;
        border-radius: 8px;
        background: #f1f5f9;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.875rem;
        color: #64748b;
        display: flex;
        align-items: center;
    }
    .editable-field:hover {
        background: #e2e8f0;
        border-color: #cbd5e1;
        color: #334155;
    }
    .editable-field:focus {
        outline: none;
        background: #fff;
        border: 2px solid #3b82f6;
        color: #0f172a;
        cursor: text;
    }
    .editable-field.has-content {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #1e293b;
    }

    /* Badges */
    .status-badge {
        padding: 0.4em 0.8em;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .type-badge {
        font-size: 0.7rem;
        padding: 0.2em 0.6em;
        border-radius: 6px;
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .mobile-card {
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            background: white;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }
        .page-pad { padding: 1rem !important; }
        .editable-field { min-height: 60px; }
    }
</style>

<div class="container-fluid page-pad p-4 pb-5">
    <div class="exams-shell">
        
        <!-- Hero Section -->
        <div class="exams-hero text-white p-4 p-lg-5 mb-5 shadow-lg position-relative">
            <div class="row g-4 align-items-center position-relative" style="z-index: 2;">
                <div class="col-lg-7">
                    <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill fw-bold shadow-sm">
                        <i class="fas fa-graduation-cap me-2"></i>Academic Planning
                    </span>
                    <h2 class="hero-title display-5 mb-3">Exam Center</h2>
                    <p class="mb-0 fs-5 opacity-75" style="max-width: 600px;">Plan your studies, keep track of upcoming exams, and write interactive preparation notes directly in your schedule.</p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-lg-end">
                        <a href="{{ route('student.exams.export', request()->query()) }}" class="btn btn-light btn-lg fw-semibold shadow-sm rounded-pill px-4" style="color: #1e3a8a;">
                            <i class="fas fa-file-csv me-2"></i> Export Schedule
                        </a>
                        <a href="{{ route('student.exams.calendar', request()->query()) }}" class="btn btn-outline-light btn-lg fw-semibold rounded-pill px-4" style="border-width: 2px;">
                            <i class="fas fa-calendar-plus me-2"></i> Sync to Calendar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="row g-4 mb-5">
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card-glass p-4 h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box icon-upcoming shadow-sm"><i class="fas fa-clock"></i></div>
                        <div>
                            <div class="text-muted fw-semibold small text-uppercase tracking-wider">Upcoming</div>
                            <h3 class="fw-bold mb-0 text-dark">{{ $upcomingCount ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card-glass p-4 h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box icon-completed shadow-sm"><i class="fas fa-check-double"></i></div>
                        <div>
                            <div class="text-muted fw-semibold small text-uppercase tracking-wider">Completed</div>
                            <h3 class="fw-bold mb-0 text-dark">{{ $completedCount ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card-glass p-4 h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box icon-graded shadow-sm"><i class="fas fa-award"></i></div>
                        <div>
                            <div class="text-muted fw-semibold small text-uppercase tracking-wider">Graded</div>
                            <h3 class="fw-bold mb-0 text-dark">{{ $gradedCount ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="stat-card-glass p-4 h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box icon-average shadow-sm"><i class="fas fa-chart-pie"></i></div>
                        <div>
                            <div class="text-muted fw-semibold small text-uppercase tracking-wider">Avg Score</div>
                            <h3 class="fw-bold mb-0 text-dark">{{ isset($avgScore) ? number_format($avgScore, 1) : 0 }}%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Exam Banner -->
        @if(isset($nextExam) && $nextExam)
            @php
                $daysLeft = now()->startOfDay()->diffInDays($nextExam->exam_date, false);
                $examTime = ($nextExam->start_time ? date('h:i A', strtotime($nextExam->start_time)) : 'TBD') . ' - ' . ($nextExam->end_time ? date('h:i A', strtotime($nextExam->end_time)) : 'TBD');
            @endphp
            <div class="next-exam-alert p-4 mb-5 d-flex flex-column flex-md-row justify-content-between align-items-center gap-4">
                <div class="d-flex align-items-center gap-4">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                        <i class="fas fa-exclamation-circle fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Your Next Exam is Approaching</h5>
                        <p class="mb-0 text-muted">Flashcards ready! You have <strong class="text-primary">{{ $nextExam->title }}</strong> ({{ $nextExam->course->title ?? 'N/A' }}) on <strong>{{ optional($nextExam->exam_date)->format('M d, Y') }}</strong> at {{ $examTime }}.</p>
                    </div>
                </div>
                <div class="text-center bg-primary text-white rounded-4 px-4 py-3 shadow-sm min-w-150">
                    <h3 class="fw-bold mb-0">{{ $daysLeft >= 0 ? $daysLeft : 0 }}</h3>
                    <div class="small fw-semibold text-uppercase opacity-75">Days Left</div>
                </div>
            </div>
        @endif

        <!-- Filter Card -->
        <div class="custom-table-card mb-5">
            <div class="card-body p-4 bg-white">
                <form method="GET" action="{{ route('student.exams') }}" id="filterForm">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label for="q" class="form-label text-muted fw-semibold small text-uppercase">Search Exams</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" id="q" name="q" value="{{ $q ?? '' }}" class="form-control border-start-0 bg-light" placeholder="Title, description, course...">
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="status" class="form-label text-muted fw-semibold small text-uppercase">Status</label>
                            <select id="status" name="status" class="form-select bg-light">
                                <option value="">All Statuses</option>
                                @if(isset($statusOptions))
                                    @foreach($statusOptions as $statusOption)
                                        <option value="{{ $statusOption }}" {{ (isset($status) && $status === $statusOption) ? 'selected' : '' }}>
                                            {{ ucfirst($statusOption) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="type" class="form-label text-muted fw-semibold small text-uppercase">Type</label>
                            <select id="type" name="type" class="form-select bg-light">
                                <option value="">All Types</option>
                                @if(isset($typeOptions))
                                    @foreach($typeOptions as $typeOption)
                                        <option value="{{ $typeOption }}" {{ (isset($type) && $type === $typeOption) ? 'selected' : '' }}>
                                            {{ ucfirst($typeOption) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <label for="sort" class="form-label text-muted fw-semibold small text-uppercase">Sort By</label>
                            <select id="sort" name="sort" class="form-select bg-light">
                                <option value="upcoming" {{ (isset($sort) && $sort === 'upcoming') ? 'selected' : '' }}>Upcoming First</option>
                                <option value="latest" {{ (isset($sort) && $sort === 'latest') ? 'selected' : '' }}>Latest First</option>
                                <option value="oldest" {{ (isset($sort) && $sort === 'oldest') ? 'selected' : '' }}>Oldest First</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-2">
                            <div class="d-flex gap-2 h-100">
                                <button class="btn btn-primary flex-grow-1" type="submit"><i class="fas fa-filter me-1"></i> Apply</button>
                                <a class="btn btn-light border" href="{{ route('student.exams') }}" title="Reset"><i class="fas fa-undo text-muted"></i></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Schedule Interactive Grid -->
        <div class="custom-table-card shadow-lg bg-white">
            <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-clipboard-list text-primary me-2"></i> Interactive Exam Schedule</h5>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-info-circle text-primary me-1"></i> Click on "Study Notes" to directly add your personal preparation plans!</span>
            </div>
            
            <div class="card-body p-0">
                @if(isset($exams) && $exams->count() > 0)
                    <!-- Desktop View -->
                    <div class="table-responsive d-none d-lg-block">
                        <table class="table align-middle mb-0 border-0 table-hover">
                            <thead>
                                <tr>
                                    <th width="25%">Exam Details</th>
                                    <th width="15%">Date & Time</th>
                                    <th width="25%">My Study Notes (Editable) <i class="fas fa-pencil-alt ms-1 text-primary"></i></th>
                                    <th width="15%">Result</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exams as $exam)
                                    @php
                                        $gradeScore = $exam->gradeScores->first();
                                        $statusClass = match($exam->status) {
                                            'scheduled' => 'bg-primary text-white',
                                            'ongoing' => 'bg-warning text-dark',
                                            'completed' => 'bg-success text-white',
                                            'cancelled' => 'bg-danger text-white',
                                            default => 'bg-secondary text-white'
                                        };
                                        $examUniqueId = 'exam_note_' . auth()->id() . '_' . $exam->id;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="d-flex align-items-center gap-2 mb-1">
                                                    <span class="fw-bold fs-6 text-dark">{{ $exam->title }}</span>
                                                    <span class="status-badge {{ $statusClass }} py-1 px-2">{{ ucfirst($exam->status ?? 'unknown') }}</span>
                                                </div>
                                                <div class="text-muted small mb-1"><i class="fas fa-book-open me-1 opacity-50"></i> {{ $exam->course->title ?? 'N/A' }}</div>
                                                <div><span class="type-badge">{{ ucfirst($exam->type ?? 'general') }}</span></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2 mb-1 text-dark fw-semibold">
                                                <i class="fas fa-calendar-alt text-muted"></i> {{ optional($exam->exam_date)->format('M d, Y') ?? 'N/A' }}
                                            </div>
                                            <div class="text-muted small d-flex align-items-center gap-2 mt-1">
                                                <i class="fas fa-clock text-muted"></i>
                                                {{ $exam->start_time ? date('h:i A', strtotime($exam->start_time)) : 'TBD' }} - {{ $exam->end_time ? date('h:i A', strtotime($exam->end_time)) : 'TBD' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="editable-field html-note" 
                                                 contenteditable="true" 
                                                 data-exam-id="{{ $examUniqueId }}"
                                                 data-placeholder="Click here to add notes (e.g. Focus on Chapter 3 & 4...)"></div>
                                        </td>
                                        <td>
                                            @if($gradeScore)
                                                <div class="fw-bold text-dark fs-6">{{ $gradeScore->marks_obtained }} <span class="text-muted small">/ {{ $gradeScore->total_marks }}</span></div>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle mt-1 rounded-pill"><i class="fas fa-star me-1"></i>{{ $gradeScore->grade }} ({{ number_format($gradeScore->percentage, 1) }}%)</span>
                                            @else
                                                <span class="badge bg-light text-muted border px-2 py-1"><i class="fas fa-hourglass-half me-1"></i>Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('student.exams.admit-card', $exam->id) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill mb-1 fw-bold px-3">
                                                <i class="fas fa-id-card"></i> Admit Card
                                            </a>
                                            <a href="{{ route('student.exams.admit-card.download', $exam->id) }}" class="btn btn-sm btn-primary rounded-pill mb-1 fw-bold">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile View -->
                    <div class="d-lg-none p-3 bg-light">
                        <div class="row g-3">
                            @foreach($exams as $exam)
                                @php
                                    $gradeScore = $exam->gradeScores->first();
                                    $statusClass = match($exam->status) {
                                        'scheduled' => 'bg-primary',
                                        'ongoing' => 'bg-warning text-dark',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                    $examUniqueId = 'exam_note_m_' . auth()->id() . '_' . $exam->id;
                                @endphp
                                <div class="col-12">
                                    <div class="mobile-card position-relative overflow-hidden">
                                        <div class="position-absolute top-0 start-0 w-100 h-1" style="background: var(--bs-primary); height: 4px;"></div>
                                        <div class="d-flex justify-content-between align-items-start mb-3 mt-2">
                                            <div>
                                                <h5 class="fw-bold text-dark mb-1">{{ $exam->title }}</h5>
                                                <div class="small text-muted mb-2"><i class="fas fa-book me-1"></i>{{ $exam->course->title ?? 'N/A' }}</div>
                                            </div>
                                            <span class="badge {{ $statusClass }} rounded-pill">{{ ucfirst($exam->status ?? 'unknown') }}</span>
                                        </div>
                                        
                                        <div class="bg-light rounded-3 p-3 mb-3 border">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <i class="fas fa-calendar-day text-primary"></i>
                                                <span class="fw-semibold">{{ optional($exam->exam_date)->format('M d, Y') ?? 'N/A' }}</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 small text-muted">
                                                <i class="fas fa-clock"></i>
                                                <span>{{ $exam->start_time ? date('h:i A', strtotime($exam->start_time)) : 'TBD' }} - {{ $exam->end_time ? date('h:i A', strtotime($exam->end_time)) : 'TBD' }}</span>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="small fw-bold text-muted text-uppercase tracking-wider mb-1"><i class="fas fa-pencil-alt me-1 text-primary"></i> My Study Notes</label>
                                            <div class="editable-field html-note" 
                                                 contenteditable="true" 
                                                 data-exam-id="{{ $examUniqueId }}"
                                                 data-placeholder="Jot down chapters or reminders here..."></div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                            @if($gradeScore)
                                                <div>
                                                    <div class="small text-muted d-block lh-1">Result</div>
                                                    <span class="fw-bold text-dark">{{ $gradeScore->marks_obtained }}/{{ $gradeScore->total_marks }}</span>
                                                    <span class="badge bg-success ms-1">{{ $gradeScore->grade }}</span>
                                                </div>
                                            @else
                                                <div class="small text-muted"><i class="fas fa-info-circle me-1"></i>Result pending</div>
                                            @endif
                                            
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('student.exams.admit-card', $exam->id) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle shadow-sm" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="fas fa-id-card"></i></a>
                                                <a href="{{ route('student.exams.admit-card.download', $exam->id) }}" class="btn btn-primary btn-sm rounded-circle shadow-sm" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="fas fa-download"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-5 px-3">
                        <div class="mb-4 d-inline-block p-4 rounded-circle" style="background: #f8fafc; border: 2px dashed #cbd5e1;">
                            <i class="fas fa-calendar-times fa-4x text-muted opacity-50"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">No Exams Found</h4>
                        <p class="text-muted mb-4 max-w-md mx-auto fs-5">There are no exams matching your current filters. Take a break or check back later!</p>
                        <a href="{{ route('student.exams') }}" class="btn btn-primary btn-lg rounded-pill px-4 shadow-sm"><i class="fas fa-sync-alt me-2"></i>Clear Filters</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const editableFields = document.querySelectorAll('.editable-field');
        
        // Setup placeholders and load saved data
        editableFields.forEach(field => {
            const examId = field.getAttribute('data-exam-id');
            const placeholder = field.getAttribute('data-placeholder');
            const rawId = examId.replace('_m_', '_'); // Map mobile and desktop to same key if needed

            // Load saved content
            const savedContent = localStorage.getItem(rawId);
            if (savedContent) {
                field.textContent = savedContent;
                field.classList.add('has-content');
            } else {
                field.textContent = placeholder;
                field.style.color = '#94a3b8';
            }

            // Focus events
            field.addEventListener('focus', function() {
                if (this.textContent === placeholder) {
                    this.textContent = '';
                }
                this.style.color = '#0f172a';
            });

            // Blur/Save events
            field.addEventListener('blur', function() {
                const currentText = this.textContent.trim();
                
                if (currentText === '' || currentText === placeholder) {
                    this.textContent = placeholder;
                    this.style.color = '#94a3b8';
                    this.classList.remove('has-content');
                    localStorage.removeItem(rawId);
                } else {
                    this.classList.add('has-content');
                    localStorage.setItem(rawId, currentText);
                    
                    // Show small toast that note was saved
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        background: '#10b981',
                        color: '#ffffff',
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    Toast.fire({
                        icon: 'success',
                        title: 'Study note saved!'
                    });
                }
                
                // Keep mobile and desktop versions in sync if they are on same page
                document.querySelectorAll(`[data-exam-id="${examId}"], [data-exam-id="${examId.replace('_m_', '_')}"], [data-exam-id="${examId.replace('_', '_m_')}"]`).forEach(syncBox => {
                    if (syncBox !== this) {
                        syncBox.textContent = currentText || placeholder;
                        syncBox.style.color = currentText ? '#0f172a' : '#94a3b8';
                        if(currentText) {
                            syncBox.classList.add('has-content');
                        } else {
                            syncBox.classList.remove('has-content');
                        }
                    }
                });
            });

            // Prevent enter creating lots of divs inside contenteditable
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
