@extends('layouts.parent.app')

@section('title', 'Dashboard - Parent Portal')

@php
    // Set page title and icon for header
    $icon = 'fa-tachometer-alt';
    $title = 'Parent Dashboard';
@endphp

@section('content')
<!-- Welcome Section -->
<div class="welcome-section">
    <div class="welcome-text">
        <h1>Welcome to Parent Portal, {{ Auth::user()->name }}!</h1>
        <p>Monitor your children's academic progress and stay connected with their school activities.</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    @forelse($childrenData as $data)
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $data['student']->user->name }}</h3>
            <p>{{ $data['student']->student_id }} | Class {{ $data['student']->class }}-{{ $data['student']->section }}</p>
            <div class="stat-change positive">
                <i class="fas fa-check-circle"></i> Attendance: {{ number_format($data['attendancePercentage'], 1) }}%
            </div>
            <div class="stat-change">
                <i class="fas fa-star"></i> Avg. Grade: {{ number_format($data['avgGrade'], 1) }}%
            </div>
        </div>
    </div>
    @empty
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #6b7280, #4b5563);">
            <i class="fas fa-info-circle"></i>
        </div>
        <div class="stat-info">
            <h3>No Children Found</h3>
            <p>No children are linked to your account yet.</p>
            <p class="text-muted">Please contact the school administration.</p>
        </div>
    </div>
    @endforelse
</div>

<!-- Children Details Section -->
<div class="section-header">
    <h2>
        <i class="fas fa-child"></i> 
        My Children (@if(isset($childrenData)){{ count($childrenData) }}@else 0 @endif)
    </h2>
    @if(isset($childrenData) && count($childrenData) > 0)
    <a href="{{ route('parent.children') }}" class="view-all-link">
        View All Details <i class="fas fa-arrow-right"></i>
    </a>
    @endif
</div>

<div class="features-grid">
    @forelse($childrenData as $data)
    @php $student = $data['student']; @endphp
    
    <!-- Child Overview Card -->
    <div class="feature-card">
        <div class="feature-header">
            <div class="feature-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <h3 class="feature-title">{{ $student->user->name }}</h3>
                <p class="feature-description">
                    <strong>ID:</strong> {{ $student->student_id }}<br>
                    <strong>Class:</strong> {{ $student->class }}-{{ $student->section }}<br>
                    <strong>Roll No:</strong> {{ $student->roll_number }}
                </p>
            </div>
        </div>
        <div class="feature-stats">
            <div class="stat-item">
                <span class="stat-label">Enrollments:</span>
                <span class="stat-value">{{ $data['enrollments'] }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Avg Grade:</span>
                <span class="stat-value">{{ number_format($data['avgGrade'], 1) }}%</span>
            </div>
        </div>
        <div class="feature-actions">
            <a href="{{ route('parent.child.attendance', $student->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-calendar-check"></i> Attendance
            </a>
            <a href="{{ route('parent.child.grades', $student->id) }}" class="btn btn-sm btn-success">
                <i class="fas fa-chart-line"></i> Grades
            </a>
        </div>
    </div>

    <!-- Attendance Card -->
    <div class="feature-card">
        <div class="feature-header">
            <div class="feature-icon bg-success">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <h3 class="feature-title">Attendance Overview</h3>
                <p class="feature-description">
                    <strong>{{ $student->user->name }}</strong><br>
                    Current Attendance: <span class="text-success fw-bold">{{ number_format($data['attendancePercentage'], 1) }}%</span>
                </p>
            </div>
        </div>
        <div class="feature-stats">
            <div class="progress mb-2" style="height: 8px;">
                <div class="progress-bar bg-success" role="progressbar" 
                     style="width: {{ $data['attendancePercentage'] }}%" 
                     aria-valuenow="{{ $data['attendancePercentage'] }}" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                </div>
            </div>
            <div class="d-flex justify-content-between small">
                <span>Present: {{ $data['attendanceStats']['present'] ?? 0 }}</span>
                <span>Absent: {{ $data['attendanceStats']['absent'] ?? 0 }}</span>
                <span>Late: {{ $data['attendanceStats']['late'] ?? 0 }}</span>
            </div>
        </div>
        <div class="feature-actions">
            <a href="{{ route('parent.child.attendance', $student->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-eye"></i> View Details
            </a>
        </div>
    </div>

    <!-- Assignments Card -->
    <div class="feature-card">
        <div class="feature-header">
            <div class="feature-icon bg-info">
                <i class="fas fa-tasks"></i>
            </div>
            <div>
                <h3 class="feature-title">Assignments</h3>
                <p class="feature-description">
                    <strong>{{ $student->user->name }}</strong><br>
                    Pending: {{ $data['pendingAssignments'] }} | Completed: {{ $data['completedAssignments'] ?? 0 }}
                </p>
            </div>
        </div>
        <div class="feature-stats">
            @if(($data['pendingAssignments'] ?? 0) > 0)
            <div class="alert alert-warning py-1 px-2 mb-0 small">
                <i class="fas fa-exclamation-triangle"></i> 
                {{ $data['pendingAssignments'] }} assignment(s) pending submission
            </div>
            @else
            <div class="alert alert-success py-1 px-2 mb-0 small">
                <i class="fas fa-check-circle"></i> All assignments completed
            </div>
            @endif
        </div>
        <div class="feature-actions">
            <a href="{{ route('parent.child.assignments', $student->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-list"></i> View All
            </a>
        </div>
    </div>

    <!-- Grades Card -->
    <div class="feature-card">
        <div class="feature-header">
            <div class="feature-icon bg-success">
                <i class="fas fa-chart-line"></i>
            </div>
            <div>
                <h3 class="feature-title">Academic Performance</h3>
                <p class="feature-description">
                    <strong>{{ $student->user->name }}</strong><br>
                    Average Grade: {{ number_format($data['avgGrade'], 1) }}%
                </p>
            </div>
        </div>
        <div class="feature-stats">
            @if(isset($data['recentGrades']) && count($data['recentGrades']) > 0)
            <div class="recent-grades">
                @foreach($data['recentGrades'] as $grade)
                <div class="grade-item d-flex justify-content-between small">
                    <span>{{ $grade->subject }}</span>
                    <span class="fw-bold">{{ $grade->grade }}%</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="feature-actions">
            <a href="{{ route('parent.child.grades', $student->id) }}" class="btn btn-sm btn-success">
                <i class="fas fa-chart-bar"></i> View All Grades
            </a>
        </div>
    </div>

    <!-- Exams Card -->
    <div class="feature-card">
        <div class="feature-header">
            <div class="feature-icon bg-warning">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div>
                <h3 class="feature-title">Exams & Results</h3>
                <p class="feature-description">
                    <strong>{{ $student->user->name }}</strong><br>
                    Upcoming Exams: {{ $data['upcomingExams'] ?? 0 }}
                </p>
            </div>
        </div>
        <div class="feature-stats">
            @if(($data['upcomingExams'] ?? 0) > 0)
            <div class="alert alert-info py-1 px-2 mb-0 small">
                <i class="fas fa-calendar"></i> {{ $data['upcomingExams'] }} exam(s) scheduled
            </div>
            @endif
        </div>
        <div class="feature-actions">
            <a href="{{ route('parent.child.exams', $student->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-file-alt"></i> View Exams
            </a>
        </div>
    </div>

    <!-- Quick Actions Card -->
    <div class="feature-card">
        <div class="feature-header">
            <div class="feature-icon bg-secondary">
                <i class="fas fa-bolt"></i>
            </div>
            <div>
                <h3 class="feature-title">Quick Actions</h3>
                <p class="feature-description">
                    <strong>{{ $student->user->name }}</strong>
                </p>
            </div>
        </div>
        <div class="feature-actions">
            <a href="{{ route('parent.child.details', $student->id) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-id-card"></i> Profile
            </a>
        </div>
    </div>

    @empty
    <!-- No Children Message -->
    <div class="col-12">
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-child"></i>
            </div>
            <h3>No Children Found</h3>
            <p class="text-muted">You don't have any children linked to your account yet.</p>
            <p class="text-muted small">Please contact the school administration to link your children.</p>
        </div>
    </div>
    @endforelse
</div>
@endsection

@section('scripts')
<script>
    // Dashboard specific scripts
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-refresh data every 5 minutes (300000 ms)
        if (document.getElementById('autoRefresh')) {
            setTimeout(function() {
                location.reload();
            }, 300000);
        }
        
        // Animate stats cards on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });
        
        document.querySelectorAll('.stat-card, .feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });
    });
</script>
@endsection

<style>
/* Dashboard-specific styles */
.welcome-section {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    box-shadow: var(--card-shadow);
}

.welcome-text h1 {
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.welcome-text p {
    opacity: 0.95;
    font-size: 1rem;
    margin-bottom: 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2.5rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: var(--card-shadow);
    display: flex;
    align-items: flex-start;
    gap: 1.2rem;
    transition: all var(--transition-speed);
    border: 1px solid rgba(0,0,0,0.05);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--card-shadow-hover);
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    flex-shrink: 0;
}

.stat-info {
    flex: 1;
    min-width: 0;
}

.stat-info h3 {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
    color: #1e293b;
}

.stat-info p {
    color: var(--secondary-color);
    font-size: 0.85rem;
    margin-bottom: 0.5rem;
}

.stat-change {
    font-size: 0.85rem;
    margin-top: 0.2rem;
}

.stat-change i {
    margin-right: 0.3rem;
}

.positive {
    color: var(--success-color);
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e2e8f0;
}

.section-header h2 {
    font-weight: 700;
    color: #1e293b;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-header h2 i {
    color: var(--primary-color);
}

.view-all-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all var(--transition-speed);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    background-color: var(--primary-light);
}

.view-all-link:hover {
    background-color: var(--primary-color);
    color: white;
    gap: 0.8rem;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.feature-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: var(--card-shadow);
    transition: all var(--transition-speed);
    border: 1px solid rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--card-shadow-hover);
}

.feature-header {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.feature-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background-color: var(--primary-light);
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}

.feature-icon.bg-success {
    background-color: #d1fae5;
    color: var(--success-color);
}

.feature-icon.bg-info {
    background-color: #dbeafe;
    color: var(--info-color);
}

.feature-icon.bg-warning {
    background-color: #fef3c7;
    color: var(--warning-color);
}

.feature-icon.bg-secondary {
    background-color: #f3f4f6;
    color: var(--secondary-color);
}

.feature-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.4rem;
    color: #1e293b;
}

.feature-description {
    color: var(--secondary-color);
    font-size: 0.85rem;
    line-height: 1.5;
    margin-bottom: 0;
}

.feature-stats {
    margin-bottom: 1rem;
    padding: 0.75rem;
    background-color: #f8fafc;
    border-radius: 8px;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.3rem;
    font-size: 0.9rem;
}

.stat-label {
    color: var(--secondary-color);
}

.stat-value {
    font-weight: 600;
    color: #1e293b;
}

.feature-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-top: auto;
}

.btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
    border-radius: 6px;
}

.btn-outline-primary {
    background-color: transparent;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
}

.btn-outline-primary:hover {
    background-color: var(--primary-color);
    color: white;
}

.btn-outline-info {
    background-color: transparent;
    color: var(--info-color);
    border: 1px solid var(--info-color);
}

.btn-outline-info:hover {
    background-color: var(--info-color);
    color: white;
}

.btn-outline-success {
    background-color: transparent;
    color: var(--success-color);
    border: 1px solid var(--success-color);
}

.btn-outline-success:hover {
    background-color: var(--success-color);
    color: white;
}

/* Progress Bar */
.progress {
    background-color: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    transition: width 0.6s ease;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    background: white;
    border-radius: 16px;
    box-shadow: var(--card-shadow);
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: var(--primary-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: var(--primary-color);
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-text h1 {
        font-size: 1.4rem;
    }
    
    .welcome-section {
        padding: 1.5rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .features-grid {
        grid-template-columns: 1fr;
    }

    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .view-all-link {
        align-self: flex-start;
    }
}

@media (max-width: 576px) {
    .welcome-text h1 {
        font-size: 1.2rem;
    }
    
    .stat-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .feature-actions {
        justify-content: center;
    }
}

/* Loading Animation */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.loading {
    animation: pulse 1.5s ease-in-out infinite;
}
</style>