@extends('layouts.teacher.app')
@section('content')
    <div class="dashboard-title">
        <h1><i class="fas fa-tachometer-alt"></i> Teacher Dashboard</h1>
        <p>Welcome to your teaching dashboard - Manage classes, assignments, and student progress</p>
    </div>

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="welcome-banner-content">
            <h2>Welcome back, Ms. Johnson!</h2>
            <p>You have 3 classes today, 15 assignments to grade, and 2 meetings scheduled.</p>
        </div>
        <div class="quick-stats">
            <div class="quick-stat-item">
                <div class="quick-stat-value">3</div>
                <div class="quick-stat-label">Classes Today</div>
            </div>
            <div class="quick-stat-item">
                <div class="quick-stat-value">15</div>
                <div class="quick-stat-label">Assignments</div>
            </div>
            <div class="quick-stat-item">
                <div class="quick-stat-value">42</div>
                <div class="quick-stat-label">Students</div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--primary-color);">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-info">
                <h3>4</h3>
                <p>Active Classes</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 1 new this term
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--success-color);">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <h3>42</h3>
                <p>Total Students</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 3 new enrollments
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--warning-color);">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="stat-info">
                <h3>15</h3>
                <p>Pending Grading</p>
                <div class="stat-change negative">
                    <i class="fas fa-clock"></i> Due soon
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--info-color);">
                <i class="fas fa-percentage"></i>
            </div>
            <div class="stat-info">
                <h3>94%</h3>
                <p>Avg. Attendance</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 2% increase
                </div>
            </div>
        </div>
    </div>

    <!-- Core Features -->
    <div class="section-title">
        <h2><i class="fas fa-star"></i> Teaching Features</h2>
        <a href="#" class="view-all-link">
            View All Features <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    <div class="features-grid">
        <!-- My Classes Card -->
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <h3 class="feature-title">My Classes</h3>
                    <p class="feature-description">View and manage your assigned classes, schedules, and
                        class materials</p>
                </div>
            </div>
            <div class="feature-actions">
                <button class="btn btn-primary" data-page="myClasses">
                    <i class="fas fa-eye"></i> View Classes
                </button>
                <button class="btn btn-outline" id="viewScheduleBtn">
                    <i class="fas fa-calendar"></i> Schedule
                </button>
            </div>
        </div>

        <!-- Assignments Card -->
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div>
                    <h3 class="feature-title">Assignments</h3>
                    <p class="feature-description">Create, manage, and grade assignments for your students
                    </p>
                </div>
            </div>
            <div class="feature-actions">
                <button class="btn btn-primary" data-page="assignments">
                    <i class="fas fa-list"></i> View All
                </button>
                <button class="btn btn-success" id="createAssignmentBtn">
                    <i class="fas fa-plus"></i> Create New
                </button>
            </div>
        </div>

        <!-- Students Card -->
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <h3 class="feature-title">My Students</h3>
                    <p class="feature-description">View student profiles, track progress, and manage
                        student data</p>
                </div>
            </div>
            <div class="feature-actions">
                <button class="btn btn-primary" data-page="students">
                    <i class="fas fa-users"></i> View Students
                </button>
                <button class="btn btn-outline" id="studentReportsBtn">
                    <i class="fas fa-chart-line"></i> Progress
                </button>
            </div>
        </div>

        <!-- Attendance Card -->
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <h3 class="feature-title">Attendance</h3>
                    <p class="feature-description">Mark and track student attendance for your classes</p>
                </div>
            </div>
            <div class="feature-actions">
                <button class="btn btn-primary" data-page="attendance">
                    <i class="fas fa-check-circle"></i> Mark Attendance
                </button>
                <button class="btn btn-outline" id="attendanceReportBtn">
                    <i class="fas fa-chart-bar"></i> Reports
                </button>
            </div>
        </div>

        <!-- Grades Card -->
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <h3 class="feature-title">Grades & Results</h3>
                    <p class="feature-description">Enter grades, calculate results, and generate reports
                    </p>
                </div>
            </div>
            <div class="feature-actions">
                <button class="btn btn-primary" data-page="grades">
                    <i class="fas fa-edit"></i> Enter Grades
                </button>
                <button class="btn btn-outline" id="resultsReportBtn">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>

        <!-- Study Materials Card -->
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-video"></i>
                </div>
                <div>
                    <h3 class="feature-title">Study Materials</h3>
                    <p class="feature-description">Upload and manage study materials, notes, and resources
                    </p>
                </div>
            </div>
            <div class="feature-actions">
                <button class="btn btn-primary" data-page="studyMaterials">
                    <i class="fas fa-folder-open"></i> Browse
                </button>
                <button class="btn btn-success" id="uploadMaterialBtn">
                    <i class="fas fa-upload"></i> Upload
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="section-title">
        <h2><i class="fas fa-history"></i> Today's Schedule</h2>
    </div>

    <div class="chart-container">
        <h3>Class Performance Overview</h3>
        <div class="chart-wrapper">
            <canvas id="performanceChart"></canvas>
        </div>
    </div>
@endsection
