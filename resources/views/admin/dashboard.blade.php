@extends('layouts.admin.app')
@section('content')
    <div class="dashboard-title">
        <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
        <p>Real-time snapshot of school operations and academic activity.</p>
    </div>

    <div class="welcome-banner">
        <div class="welcome-banner-content">
            <h2>Welcome, {{ auth()->user()->name }}</h2>
            <p>{{ now()->format('l, d M Y') }} | Attendance Rate: {{ number_format($attendanceRate, 1) }}%</p>
        </div>
        <div class="quick-stats">
            <div class="quick-stat-item">
                <div class="quick-stat-value">{{ $courseCount }}</div>
                <div class="quick-stat-label">Courses</div>
            </div>
            <div class="quick-stat-item">
                <div class="quick-stat-value">{{ $enrollmentCount }}</div>
                <div class="quick-stat-label">Enrollments</div>
            </div>
            <div class="quick-stat-item">
                <div class="quick-stat-value">{{ $upcomingExams }}</div>
                <div class="quick-stat-label">Upcoming Exams</div>
            </div>
        </div>
    </div>

    <div class="stats-grid" id="people-overview">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--primary-color);">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $teacherCount }}</h3>
                <p>Total Teachers</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> {{ $newTeachersThisMonth }} new this month
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--success-color);">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $studentCount }}</h3>
                <p>Total Students</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> {{ $newStudentsThisMonth }} new this month
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--warning-color);">
                <i class="fas fa-school"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $classCount }}</h3>
                <p>Classes & Sections</p>
                <div class="stat-change">
                    <i class="fas fa-layer-group"></i> {{ $courseCount }} active courses
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--accent-color);">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $subjectCount }}</h3>
                <p>Subjects</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> {{ $newSubjectsThisMonth }} new this month
                </div>
            </div>
        </div>
    </div>

    <div class="section-title" id="academic-overview">
        <h2><i class="fas fa-star"></i> Administrative Actions</h2>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <h3 class="feature-title">School Profile</h3>
                    <p class="feature-description">Update school details, official contact info and profile configuration.</p>
                </div>
            </div>
            <div class="feature-actions">
                <a href="{{ route('admin.profile') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Manage Profile
                </a>
                <a href="{{ route('admin.settings') }}" class="btn btn-outline">
                    <i class="fas fa-cog"></i> Open Settings
                </a>
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div>
                    <h3 class="feature-title">User Access & Security</h3>
                    <p class="feature-description">Review account-level security and administrative controls.</p>
                </div>
            </div>
            <div class="feature-actions">
                <a href="{{ route('admin.users') }}" class="btn btn-primary">
                    <i class="fas fa-shield-alt"></i> Open Security
                </a>
                <a href="{{ route('admin.settings') }}" class="btn btn-outline">
                    <i class="fas fa-sliders-h"></i> System Controls
                </a>
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <h3 class="feature-title">Academic Operations</h3>
                    <p class="feature-description">Monitor assignments, pending grading workload and exam planning.</p>
                </div>
            </div>
            <div class="feature-actions">
                <span class="btn btn-outline"><i class="fas fa-book-open"></i> Assignments: {{ $assignmentCount }}</span>
                <span class="btn btn-warning"><i class="fas fa-hourglass-half"></i> Pending Grading: {{ $pendingSubmissions }}</span>
            </div>
        </div>
    </div>

    <div class="section-title" id="attendance-overview">
        <h2><i class="fas fa-history"></i> Recent Activity</h2>
    </div>

    <div class="feature-card" style="margin-bottom: 2rem;">
        @forelse($recentActivity as $activity)
            <div style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid #e2e8f0;">
                <div class="feature-icon" style="width:40px;height:40px;font-size:1rem;">
                    <i class="fas {{ $activity['icon'] }}"></i>
                </div>
                <div style="flex:1;">
                    <p style="font-weight:600;margin:0;">{{ $activity['title'] }}</p>
                    <p style="margin:2px 0 0;color:var(--gray-color);">{{ $activity['description'] }}</p>
                </div>
                <small style="color:var(--gray-color);white-space:nowrap;">{{ $activity['time']->diffForHumans() }}</small>
            </div>
        @empty
            <p style="margin:0;color:var(--gray-color);">No recent activity yet.</p>
        @endforelse
    </div>

    <div class="chart-container">
        <h3>Monthly Attendance Overview ({{ now()->year }})</h3>
        <div class="chart-wrapper">
            <canvas id="attendanceChart" data-labels='@json($monthlyAttendanceLabels)' data-values='@json($monthlyAttendanceData)'></canvas>
        </div>
    </div>
@endsection
