@extends('layouts.admin.app')
@section('content')
    <div class="dashboard-title">
        <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
        <p>School Management System - Manage classes, teachers, students, and more</p>
    </div>

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="welcome-banner-content">
            <h2>Welcome back, Admin User!</h2>
            <p>You are logged in as an Administrator. Last login: Today at 09:45 AM</p>
        </div>
        <div class="quick-stats">
            <div class="quick-stat-item">
                <div class="quick-stat-value">42</div>
                <div class="quick-stat-label">Teachers</div>
            </div>
            <div class="quick-stat-item">
                <div class="quick-stat-value">856</div>
                <div class="quick-stat-label">Students</div>
            </div>
            <div class="quick-stat-item">
                <div class="quick-stat-value">12</div>
                <div class="quick-stat-label">Classes</div>
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
                <h3>42</h3>
                <p>Total Teachers</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 5 new this month
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--success-color);">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <h3>856</h3>
                <p>Total Students</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 32 new this month
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--warning-color);">
                <i class="fas fa-school"></i>
            </div>
            <div class="stat-info">
                <h3>12</h3>
                <p>Classes</p>
                <div class="stat-change">
                    <i class="fas fa-minus"></i> No change
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--accent-color);">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-info">
                <h3>28</h3>
                <p>Subjects</p>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 2 new this month
                </div>
            </div>
        </div>
    </div>

    <!-- Core Features -->
    <div class="section-title">
        <h2><i class="fas fa-star"></i> Core Features (MVP)</h2>
        <a href="#" class="view-all-link">
            View All Features <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="features-grid">
        <!-- School Info Card -->
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <h3 class="feature-title">School Info / Settings</h3>
                    <p class="feature-description">Manage school details, contact information, and system
                        settings</p>
                </div>
            </div>
            <div class="feature-actions">
                <button class="btn btn-primary" id="editSchoolInfoBtn">
                    <i class="fas fa-edit"></i> Edit Info
                </button>
                <button class="btn btn-outline" id="viewSchoolSettingsBtn">
                    <i class="fas fa-cog"></i> Settings
                </button>
            </div>
        </div>

        <!-- Classes & Sections Card -->
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <h3 class="feature-title">Classes & Sections</h3>
                    <p class="feature-description">Manage classes (Class 1, 2, 3...) and sections within
                        each
                        class</p>
                </div>
            </div>
            <div class="feature-actions">
                <button class="btn btn-primary" id="addClassBtn">
                    <i class="fas fa-plus"></i> Add Class
                </button>
                <button class="btn btn-outline" id="viewClassesBtn">
                    <i class="fas fa-list"></i> View All
                </button>
            </div>
        </div>

        <!-- Subjects Management Card -->
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div>
                    <h3 class="feature-title">Subjects Management</h3>
                    <p class="feature-description">Add, edit, or remove subjects from the curriculum</p>
                </div>
            </div>
            <div class="feature-actions">
                <button class="btn btn-primary" id="addSubjectBtn">
                    <i class="fas fa-plus"></i> Add Subject
                </button>
                <button class="btn btn-outline" id="manageSubjectsBtn">
                    <i class="fas fa-list"></i> Manage
                </button>
            </div>
        </div>

        <!-- Teachers & Students CRUD Card -->
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h3 class="feature-title">Teachers & Students CRUD</h3>
                    <p class="feature-description">Create, read, update, and delete teacher and student
                        records
                    </p>
                </div>
            </div>
            <div class="feature-actions">
                <button class="btn btn-primary" id="addTeacherBtn">
                    <i class="fas fa-user-plus"></i> Add Teacher
                </button>
                <button class="btn btn-success" id="addStudentBtn">
                    <i class="fas fa-user-graduate"></i> Add Student
                </button>
            </div>
        </div>

        <!-- Assign Teacher to Class/Subject Card -->
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div>
                    <h3 class="feature-title">Assign Teacher to Class/Subject</h3>
                    <p class="feature-description">Assign teachers to specific classes and subjects they
                        teach
                    </p>
                </div>
            </div>
            <div class="feature-actions">
                <button class="btn btn-primary" id="assignTeacherBtn">
                    <i class="fas fa-link"></i> Assign
                </button>
                <button class="btn btn-outline" id="viewAssignmentsBtn">
                    <i class="fas fa-eye"></i> View Assignments
                </button>
            </div>
        </div>

        <!-- View Reports Card -->
        <div class="feature-card">
            <div class="feature-header">
                <div class="feature-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div>
                    <h3 class="feature-title">View Reports</h3>
                    <p class="feature-description">View attendance, results, and other analytical reports
                    </p>
                </div>
            </div>
            <div class="feature-actions">
                <button class="btn btn-primary" id="attendanceReportBtn">
                    <i class="fas fa-chart-line"></i> Attendance
                </button>
                <button class="btn btn-warning" id="resultsReportBtn">
                    <i class="fas fa-poll"></i> Results
                </button>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="section-title">
        <h2><i class="fas fa-history"></i> Recent Activity</h2>
    </div>

    <div class="chart-container">
        <h3>Monthly Attendance Overview</h3>
        <div class="chart-wrapper">
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>
@endsection
