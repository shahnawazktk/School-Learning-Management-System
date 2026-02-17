@extends('layouts.parent.app')

@section('content')
<div class="page-header">
    <div class="header-title">
        <h1><i class="fas fa-user-graduate"></i> {{ $student->user->name }}</h1>
        <p>Complete academic profile and progress</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('parent.children') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Children
        </a>
    </div>
</div>

<!-- Student Overview Cards -->
<div class="overview-grid">
    <div class="overview-card">
        <div class="overview-icon" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8);">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="overview-info">
            <h3>Attendance</h3>
            @php
                $totalAttendance = $student->attendances->count();
                $presentCount = $student->attendances->where('status', 'present')->count();
                $attendancePercent = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100) : 0;
            @endphp
            <p class="overview-value">{{ $attendancePercent }}%</p>
            <p class="overview-label">{{ $presentCount }}/{{ $totalAttendance }} Days</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="overview-info">
            <h3>Average Grade</h3>
            @php
                $avgGrade = $student->gradeScores->avg('percentage');
            @endphp
            <p class="overview-value">{{ round($avgGrade ?? 0, 1) }}%</p>
            <p class="overview-label">Overall Performance</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <i class="fas fa-tasks"></i>
        </div>
        <div class="overview-info">
            <h3>Assignments</h3>
            @php
                $totalAssignments = $student->submissions->count();
                $completedAssignments = $student->submissions->where('status', 'graded')->count();
            @endphp
            <p class="overview-value">{{ $completedAssignments }}/{{ $totalAssignments }}</p>
            <p class="overview-label">Completed</p>
        </div>
    </div>

    <div class="overview-card">
        <div class="overview-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
            <i class="fas fa-book"></i>
        </div>
        <div class="overview-info">
            <h3>Courses</h3>
            <p class="overview-value">{{ $student->enrollments->count() }}</p>
            <p class="overview-label">Enrolled Courses</p>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="quick-links">
    <h2><i class="fas fa-link"></i> Quick Access</h2>
    <div class="links-grid">
        <a href="{{ route('parent.child.attendance', $student->id) }}" class="quick-link-card">
            <div class="link-icon" style="background-color: #dbeafe; color: #2563eb;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <span>Attendance</span>
        </a>
        <a href="{{ route('parent.child.grades', $student->id) }}" class="quick-link-card">
            <div class="link-icon" style="background-color: #d1fae5; color: #059669;">
                <i class="fas fa-chart-line"></i>
            </div>
            <span>Grades</span>
        </a>
        <a href="{{ route('parent.child.assignments', $student->id) }}" class="quick-link-card">
            <div class="link-icon" style="background-color: #fef3c7; color: #d97706;">
                <i class="fas fa-tasks"></i>
            </div>
            <span>Assignments</span>
        </a>
        <a href="{{ route('parent.child.exams', $student->id) }}" class="quick-link-card">
            <div class="link-icon" style="background-color: #ede9fe; color: #7c3aed;">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <span>Exams</span>
        </a>
    </div>
</div>

<!-- Recent Grades -->
<div class="recent-section">
    <h2><i class="fas fa-star"></i> Recent Grades</h2>
    @if($recentGrades->count() > 0)
    <div class="grades-table">
        <table>
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Score</th>
                    <th>Grade</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentGrades as $grade)
                <tr>
                    <td>{{ $grade->course->name ?? 'N/A' }}</td>
                    <td>
                        @if($grade->assignment)
                            <span class="badge">{{ $grade->assignment->title }}</span>
                        @elseif($grade->exam)
                            <span class="badge badge-exam">{{ $grade->exam->title }}</span>
                        @else
                            <span class="badge">Other</span>
                        @endif
                    </td>
                    <td>{{ $grade->score }}/{{ $grade->total_score }}</td>
                    <td>
                        <span class="grade-badge {{ $grade->percentage >= 60 ? 'pass' : 'fail' }}">
                            {{ $grade->letter_grade ?? 'N/A' }}
                        </span>
                    </td>
                    <td>{{ $grade->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <p>No grades available yet.</p>
    </div>
    @endif
</div>

<!-- Student Information -->
<div class="info-section">
    <h2><i class="fas fa-info-circle"></i> Student Information</h2>
    <div class="info-grid">
        <div class="info-card">
            <div class="info-label">Student ID</div>
            <div class="info-value">{{ $student->student_id }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Class</div>
            <div class="info-value">{{ $student->class }} - {{ $student->section }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Roll Number</div>
            <div class="info-value">{{ $student->roll_number }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Date of Birth</div>
            <div class="info-value">{{ $student->date_of_birth ? date('M d, Y', strtotime($student->date_of_birth)) : 'Not set' }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Gender</div>
            <div class="info-value">{{ ucfirst($student->gender) ?? 'Not set' }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Email</div>
            <div class="info-value">{{ $student->user->email }}</div>
        </div>
    </div>
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
    .overview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .overview-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: var(--card-shadow);
        transition: all var(--transition-speed);
    }
    .overview-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-shadow-hover);
    }
    .overview-icon {
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
    .overview-info h3 {
        font-size: 0.9rem;
        color: #64748b;
        margin-bottom: 0.3rem;
    }
    .overview-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
    }
    .overview-label {
        font-size: 0.8rem;
        color: #9ca3af;
    }
    .quick-links {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
    }
    .quick-links h2 {
        font-size: 1.3rem;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .quick-links h2 i {
        color: var(--primary-color);
    }
    .links-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
    }
    .quick-link-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        transition: all var(--transition-speed);
        background: #f8fafc;
    }
    .quick-link-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--card-shadow);
    }
    .link-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 0.8rem;
    }
    .quick-link-card span {
        color: #1e293b;
        font-weight: 600;
    }
    .recent-section, .info-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
    }
    .recent-section h2, .info-section h2 {
        font-size: 1.3rem;
        color: #1e293b;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .recent-section h2 i, .info-section h2 i {
        color: var(--primary-color);
    }
    .grades-table {
        overflow-x: auto;
    }
    .grades-table table {
        width: 100%;
        border-collapse: collapse;
    }
    .grades-table th, .grades-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }
    .grades-table th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #64748b;
    }
    .grades-table tr:hover {
        background-color: #f8fafc;
    }
    .grade-badge {
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-weight: 600;
    }
    .grade-badge.pass {
        background-color: #d1fae5;
        color: #059669;
    }
    .grade-badge.fail {
        background-color: #fee2e2;
        color: #dc2626;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
    .info-card {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 8px;
    }
    .info-label {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 0.3rem;
    }
    .info-value {
        font-weight: 600;
        color: #1e293b;
    }
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #64748b;
    }
    .badge {
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-size: 0.8rem;
        background: #e2e8f0;
        color: #475569;
    }
    .badge-exam {
        background: #ede9fe;
        color: #7c3aed;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>
@endsection
