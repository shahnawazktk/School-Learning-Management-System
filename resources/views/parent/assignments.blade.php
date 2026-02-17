@extends('layouts.parent.app')

@section('content')
<div class="page-header">
    <div class="header-title">
        <h1><i class="fas fa-tasks"></i> Assignments</h1>
        <p>View all assignments for {{ $student->user->name }}</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('parent.child.details', $student->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Details
        </a>
    </div>
</div>

<!-- Assignment Stats -->
<div class="assignment-stats">
    @php
        $totalAssignments = $assignments->count();
        $pendingAssignments = $assignments->filter(function($a) { 
            return $a->submissions->isEmpty() || $a->submissions->first()->status == 'pending';
        })->count();
        $submittedAssignments = $assignments->filter(function($a) { 
            return $a->submissions->isNotEmpty() && $a->submissions->first()->status == 'submitted';
        })->count();
        $gradedAssignments = $assignments->filter(function($a) { 
            return $a->submissions->isNotEmpty() && $a->submissions->first()->status == 'graded';
        })->count();
    @endphp

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
            <i class="fas fa-list"></i>
        </div>
        <div class="stat-info">
            <h3>Total</h3>
            <p class="stat-value">{{ $totalAssignments }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>Pending</h3>
            <p class="stat-value">{{ $pendingAssignments }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
            <i class="fas fa-paper-plane"></i>
        </div>
        <div class="stat-info">
            <h3>Submitted</h3>
            <p class="stat-value">{{ $submittedAssignments }}</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>Graded</h3>
            <p class="stat-value">{{ $gradedAssignments }}</p>
        </div>
    </div>
</div>

<!-- Assignments List -->
<div class="assignments-section">
    <h2><i class="fas fa-clipboard-list"></i> All Assignments</h2>
    
    @if($assignments->count() > 0)
    <div class="assignments-list">
        @foreach($assignments as $assignment)
        <div class="assignment-card">
            <div class="assignment-header">
                <div class="assignment-info">
                    <h3>{{ $assignment->title }}</h3>
                    <p class="course-name">
                        <i class="fas fa-book"></i>
                        {{ $assignment->course->name ?? 'N/A' }}
                    </p>
                </div>
                <div class="assignment-status">
                    @php
                        $submission = $assignment->submissions->first();
                        $status = $submission ? $submission->status : 'pending';
                    @endphp
                    
                    @if($status == 'graded')
                        <span class="status-badge graded">
                            <i class="fas fa-check-circle"></i> Graded
                        </span>
                    @elseif($status == 'submitted')
                        <span class="status-badge submitted">
                            <i class="fas fa-paper-plane"></i> Submitted
                        </span>
                    @else
                        <span class="status-badge pending">
                            <i class="fas fa-clock"></i> Pending
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="assignment-details">
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-align-left"></i> Description</span>
                    <span class="detail-value">{{ Str::limit($assignment->description, 100) }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-calendar"></i> Due Date</span>
                    <span class="detail-value {{ \Carbon\Carbon::parse($assignment->due_date)->isPast() ? 'overdue' : '' }}">
                        {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y - h:i A') }}
                        @if(\Carbon\Carbon::parse($assignment->due_date)->isPast())
                            <span class="overdue-badge">Overdue</span>
                        @endif
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-star"></i> Points</span>
                    <span class="detail-value">{{ $assignment->points }}</span>
                </div>
                @if($submission)
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-comment"></i> Teacher Feedback</span>
                    <span class="detail-value">
                        {{ $submission->feedback ?? 'No feedback yet' }}
                    </span>
                </div>
                @if($submission->grade)
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-chart-line"></i> Score</span>
                    <span class="detail-value grade">
                        {{ $submission->grade }}/{{ $assignment->points }}
                        ({{ round(($submission->grade / $assignment->points) * 100) }}%)
                    </span>
                </div>
                @endif
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-tasks"></i>
        </div>
        <h3>No Assignments</h3>
        <p>No assignments have been assigned yet.</p>
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
    .assignment-stats {
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
    .assignments-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--card-shadow);
    }
    .assignments-section h2 {
        font-size: 1.3rem;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .assignments-section h2 i {
        color: var(--primary-color);
    }
    .assignments-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .assignment-card {
        background: #f8fafc;
        border-radius: 10px;
        padding: 1.5rem;
        border-left: 4px solid var(--primary-color);
        transition: all var(--transition-speed);
    }
    .assignment-card:hover {
        box-shadow: var(--card-shadow);
    }
    .assignment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    .assignment-info h3 {
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
    .status-badge.pending {
        background-color: #fef3c7;
        color: #d97706;
    }
    .status-badge.submitted {
        background-color: #ede9fe;
        color: #7c3aed;
    }
    .status-badge.graded {
        background-color: #d1fae5;
        color: #059669;
    }
    .assignment-details {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
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
    .detail-value.overdue {
        color: #dc2626;
    }
    .detail-value.grade {
        font-weight: 700;
        color: #10b981;
    }
    .overdue-badge {
        background-color: #fee2e2;
        color: #dc2626;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 0.5rem;
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
        .assignment-header {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
@endsection
