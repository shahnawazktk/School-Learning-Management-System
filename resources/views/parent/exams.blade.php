@extends('layouts.parent.app')

@section('content')
<div class="page-header">
    <div class="header-title">
        <h1><i class="fas fa-clipboard-list"></i> Exams & Results</h1>
        <p>View exam schedules and results for {{ $student->user->name }}</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('parent.child.details', $student->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Details
        </a>
    </div>
</div>

<!-- Exam Stats -->
<div class="exam-stats">
    @php
        $totalExams = $exams->count();
        $upcomingExams = $exams->filter(function($e) { 
            return \Carbon\Carbon::parse($e->exam_date)->isFuture();
        })->count();
        $completedExams = $exams->filter(function($e) { 
            return \Carbon\Carbon::parse($e->exam_date)->isPast();
        })->count();
        $passedExams = $exams->filter(function($e) { 
            return $e->gradeScores->isNotEmpty() && $e->gradeScores->first()->percentage >= 60;
        })->count();
    @endphp

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
            <i class="fas fa-list"></i>
        </div>
        <div class="stat-info">
            <h3>Total Exams</h3>
            <p class="stat-value">{{ $totalExams }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <i class="fas fa-calendar-plus"></i>
        </div>
        <div class="stat-info">
            <h3>Upcoming</h3>
            <p class="stat-value">{{ $upcomingExams }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>Completed</h3>
            <p class="stat-value">{{ $completedExams }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
            <i class="fas fa-award"></i>
        </div>
        <div class="stat-info">
            <h3>Passed</h3>
            <p class="stat-value">{{ $passedExams }}</p>
        </div>
    </div>
</div>

<!-- Exams List -->
<div class="exams-section">
    <h2><i class="fas fa-calendar-alt"></i> All Exams</h2>
    
    @if($exams->count() > 0)
    <div class="exams-list">
        @foreach($exams as $exam)
        <div class="exam-card">
            <div class="exam-header">
                <div class="exam-info">
                    <h3>{{ $exam->title }}</h3>
                    <p class="course-name">
                        <i class="fas fa-book"></i>
                        {{ $exam->course->name ?? 'N/A' }}
                    </p>
                </div>
                <div class="exam-status">
                    @php
                        $isPast = \Carbon\Carbon::parse($exam->exam_date)->isPast();
                        $gradeScore = $exam->gradeScores->first();
                    @endphp
                    
                    @if($gradeScore)
                        <span class="status-badge {{ $gradeScore->percentage >= 60 ? 'passed' : 'failed' }}">
                            <i class="fas fa-{{ $gradeScore->percentage >= 60 ? 'check' : 'times' }}-circle"></i>
                            {{ $gradeScore->percentage >= 60 ? 'Passed' : 'Failed' }}
                        </span>
                    @elseif($isPast)
                        <span class="status-badge pending">
                            <i class="fas fa-hourglass-half"></i> Results Pending
                        </span>
                    @else
                        <span class="status-badge upcoming">
                            <i class="fas fa-clock"></i> Upcoming
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="exam-details">
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-calendar"></i> Exam Date</span>
                    <span class="detail-value {{ $isPast ? '' : 'upcoming' }}">
                        {{ \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y - l') }}
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-clock"></i> Time</span>
                    <span class="detail-value">
                        {{ \Carbon\Carbon::parse($exam->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($exam->end_time)->format('h:i A') }}
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Room</span>
                    <span class="detail-value">{{ $exam->room ?? 'Not assigned' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-star"></i> Total Marks</span>
                    <span class="detail-value">{{ $exam->total_marks }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-align-left"></i> Instructions</span>
                    <span class="detail-value">{{ Str::limit($exam->instructions, 80) }}</span>
                </div>
                
                @if($gradeScore)
                <div class="result-box">
                    <h4><i class="fas fa-chart-line"></i> Your Result</h4>
                    <div class="result-details">
                        <div class="result-item">
                            <span class="result-label">Marks Obtained</span>
                            <span class="result-value">{{ $gradeScore->score }}/{{ $gradeScore->total_score }}</span>
                        </div>
                        <div class="result-item">
                            <span class="result-label">Percentage</span>
                            <span class="result-value {{ $gradeScore->percentage >= 60 ? 'pass' : 'fail' }}">
                                {{ round($gradeScore->percentage, 1) }}%
                            </span>
                        </div>
                        <div class="result-item">
                            <span class="result-label">Grade</span>
                            <span class="result-value grade">
                                {{ $gradeScore->letter_grade ?? 'N/A' }}
                            </span>
                        </div>
                        @if($gradeScore->remarks)
                        <div class="result-item full-width">
                            <span class="result-label">Remarks</span>
                            <span class="result-value">{{ $gradeScore->remarks }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-clipboard-list"></i>
        </div>
        <h3>No Exams Scheduled</h3>
        <p>No exams have been scheduled yet.</p>
    </div>
    @endif
</div>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
    }
    .header-title h1 {
        font-size: 1.8rem;
        color: #1e293b;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .header-title h1 i {
        color: var(--primary-color);
    }
    .header-title p {
        color: #64748b;
    }
    .btn {
        padding: 0.6rem 1rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all var(--transition-speed);
    }
    .btn-secondary {
        background-color: #6b7280;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #4b5563;
        transform: translateY(-2px);
    }
    .exam-stats {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: var(--card-shadow);
        transition: all var(--transition-speed);
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-shadow-hover);
    }
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }
    .stat-info h3 {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 0.2rem;
    }
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
    }
    .exams-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
    }
    .exams-section h2 {
        font-size: 1.3rem;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .exams-section h2 i {
        color: var(--primary-color);
    }
    .exams-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .exam-card {
        background: #f8fafc;
        border-radius: 10px;
        padding: 1.5rem;
        border-left: 4px solid #8b5cf6;
        transition: all var(--transition-speed);
    }
    .exam-card:hover {
        box-shadow: var(--card-shadow);
    }
    .exam-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    .exam-info h3 {
        font-size: 1.2rem;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    .course-name {
        color: #64748b;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .status-badge.upcoming {
        background-color: #dbeafe;
        color: #2563eb;
    }
    .status-badge.pending {
        background-color: #fef3c7;
        color: #d97706;
    }
    .status-badge.passed {
        background-color: #d1fae5;
        color: #059669;
    }
    .status-badge.failed {
        background-color: #fee2e2;
        color: #dc2626;
    }
    .exam-details {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1rem;
    }
    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    .detail-label {
        font-size: 0.8rem;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .detail-value {
        font-weight: 500;
        color: #1e293b;
    }
    .detail-value.upcoming {
        color: #2563eb;
    }
    .result-box {
        grid-column: 1 / -1;
        background: white;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
    }
    .result-box h4 {
        font-size: 1rem;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .result-details {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    .result-item {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    .result-item.full-width {
        width: 100%;
    }
    .result-label {
        font-size: 0.8rem;
        color: #9ca3af;
    }
    .result-value {
        font-weight: 700;
        color: #1e293b;
    }
    .result-value.pass {
        color: #10b981;
    }
    .result-value.fail {
        color: #ef4444;
    }
    .result-value.grade {
        font-size: 1.2rem;
        color: #8b5cf6;
    }
    .empty-state {
        text-align: center;
        padding: 3rem;
        background: #f8fafc;
        border-radius: 12px;
    }
    .empty-icon {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    .empty-state h3 {
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    .empty-state p {
        color: #64748b;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
        }
        .exam-header {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
@endsection
