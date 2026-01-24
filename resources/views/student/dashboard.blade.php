@section('content')
    <div id="dashboardPage" class="page-content">
        <div class="welcome-banner">
            <div class="welcome-banner-content">
                <h2>Welcome back, John!</h2>
                <p>You have 3 pending assignments, 2 new study materials, and your attendance is 94%
                    this month.</p>
            </div>
            <div class="quick-stats">
                <div class="quick-stat-item">
                    <div class="quick-stat-value">94%</div>
                    <div class="quick-stat-label">Attendance</div>
                </div>
                <div class="quick-stat-item">
                    <div class="quick-stat-value">A-</div>
                    <div class="quick-stat-label">Avg. Grade</div>
                </div>
                <div class="quick-stat-item">
                    <div class="quick-stat-value">6</div>
                    <div class="quick-stat-label">Subjects</div>
                </div>
            </div>
        </div>
        =======
        @extends('layouts.student.app')

    @section('content')
        <div class="container-fluid">
            <!-- Welcome Banner -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card welcome-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <h2 class="welcome-title">Welcome back, {{ Auth::user()->name }}!</h2>
                                    <p class="welcome-text">
                                        You have {{ $pendingAssignments->count() }} pending assignments
                                        @if ($enrollments->count() > 0)
                                            and are enrolled in {{ $enrollments->count() }} subjects.
                                        @else
                                            and your attendance is {{ $attendancePercentage }}% this period.
                                        @endif
                                    </p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="quick-stats">
                                        <div class="quick-stat-item">
                                            <div class="quick-stat-value">{{ $attendancePercentage }}%</div>
                                            <div class="quick-stat-label">Attendance</div>
                                        </div>
                                        <div class="quick-stat-item">
                                            <div class="quick-stat-value">{{ number_format($averageGrade, 1) }}</div>
                                            <div class="quick-stat-label">Avg. Grade</div>
                                        </div>
                                        <div class="quick-stat-item">
                                            <div class="quick-stat-value">{{ $enrollments->count() }}</div>
                                            <div class="quick-stat-label">Subjects</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
