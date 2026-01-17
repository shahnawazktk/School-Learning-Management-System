@extends('layouts.student.app')
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

        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-book-open"></i> My Subjects
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
                <div class="card-content">
                    <p>You are currently enrolled in 6 subjects. View your subjects, teachers, and
                        access study materials.</p>
                </div>
                <div class="card-actions">
                    <button class="btn btn-primary" data-page="subjects">
                        <i class="fas fa-eye"></i> View Subjects
                    </button>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-tasks"></i> Pending Assignments
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <div class="card-content">
                    <p>You have 3 assignments pending submission. Check deadlines and submit your work.
                    </p>
                    <div class="mt-2">
                        <span class="badge badge-danger">2 overdue</span>
                        <span class="badge badge-warning">1 pending</span>
                    </div>
                </div>
                <div class="card-actions">
                    <button class="btn btn-primary" data-page="assignments">
                        <i class="fas fa-external-link-alt"></i> Go to Assignments
                    </button>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-chart-line"></i> Performance
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>
                <div class="card-content">
                    <p>View your attendance records, exam results, and performance analytics.</p>
                    <div class="mt-2">
                        <span class="badge badge-success">94% attendance</span>
                        <span class="badge badge-primary">A- average</span>
                    </div>
                </div>
                <div class="card-actions">
                    <button class="btn btn-primary" data-page="attendance">
                        <i class="fas fa-chart-pie"></i> View Reports
                    </button>
                </div>
            </div>
        </div>

        <div class="chart-card">
            <h3>Monthly Attendance Trend</h3>
            <div class="chart-wrapper">
                <canvas id="attendanceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Subjects Page (Hidden by default) -->
    <div id="subjectsPage" class="page-content" style="display: none;">
        <div class="page-header">
            <h1><i class="fas fa-book-open"></i> My Subjects</h1>
            <div class="filter-options">
                <select class="filter-select" id="subjectFilter">
                    <option value="all">All Subjects</option>
                    <option value="science">Science</option>
                    <option value="math">Mathematics</option>
                    <option value="language">Languages</option>
                    <option value="arts">Arts & Humanities</option>
                </select>
                <button class="btn btn-outline">
                    <i class="fas fa-download"></i> Export List
                </button>
            </div>
        </div>

        <div class="subjects-grid" id="subjectsContainer">
            <!-- Subjects will be loaded here dynamically -->
        </div>
    </div>
    <!-- Study Materials Page (Hidden by default) -->
    <div id="studyMaterialsPage" class="page-content" style="display: none;">
        <div class="page-header">
            <h1><i class="fas fa-video"></i> Study Materials</h1>
            <div class="filter-options">
                <select class="filter-select" id="materialFilter">
                    <option value="all">All Materials</option>
                    <option value="video">Videos</option>
                    <option value="notes">Notes</option>
                    <option value="presentation">Presentations</option>
                </select>
            </div>
        </div>

        <div class="subjects-grid" id="materialsContainer">
            <!-- Study materials will be loaded here dynamically -->
        </div>
    </div>

    <!-- Assignments Page (Hidden by default) -->
    <div id="assignmentsPage" class="page-content" style="display: none;">
        <div class="page-header">
            <h1><i class="fas fa-tasks"></i> My Assignments</h1>
            <div class="filter-options">
                <select class="filter-select" id="assignmentFilter">
                    <option value="all">All Assignments</option>
                    <option value="pending">Pending</option>
                    <option value="submitted">Submitted</option>
                    <option value="overdue">Overdue</option>
                </select>
                <button class="btn btn-primary" id="viewAssignmentCalendarBtn">
                    <i class="fas fa-calendar"></i> Calendar View
                </button>
            </div>
        </div>

        <div class="assignments-list" id="assignmentsContainer">
            <!-- Assignments will be loaded here dynamically -->
        </div>
    </div>

    <!-- Attendance Page (Hidden by default) -->
    <div id="attendancePage" class="page-content" style="display: none;">
        <div class="page-header">
            <h1><i class="fas fa-calendar-check"></i> Attendance</h1>
            <div class="filter-options">
                <select class="filter-select" id="attendancePeriod">
                    <option value="monthly">This Month</option>
                    <option value="semester">This Semester</option>
                    <option value="yearly">This Year</option>
                </select>
                <button class="btn btn-outline">
                    <i class="fas fa-print"></i> Print Report
                </button>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card attendance-stat">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>94%</h3>
                    <p>Overall Attendance</p>
                    <p class="text-success"><i class="fas fa-arrow-up"></i> 2% from last month</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>4</h3>
                    <p>Days Present This Month</p>
                    <p>Out of 4 school days</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                    <i class="fas fa-user-times"></i>
                </div>
                <div class="stat-info">
                    <h3>0</h3>
                    <p>Days Absent This Month</p>
                    <p>Perfect attendance!</p>
                </div>
            </div>
        </div>

        <div class="chart-card">
            <h3>Attendance by Subject</h3>
            <div class="chart-wrapper">
                <canvas id="attendanceBySubjectChart"></canvas>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3>Monthly Attendance Record</h3>
                <span>April 2024</span>
            </div>
            <div class="table-responsive">
                <table id="attendanceTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Status</th>
                            <th>Subject 1</th>
                            <th>Subject 2</th>
                            <th>Subject 3</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceTableBody">
                        <!-- Attendance data will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Results Page (Hidden by default) -->
    <div id="resultsPage" class="page-content" style="display: none;">
        <div class="page-header">
            <h1><i class="fas fa-chart-line"></i> Results & Grades</h1>
            <div class="filter-options">
                <select class="filter-select" id="resultsTerm">
                    <option value="term1">Term 1</option>
                    <option value="term2" selected>Term 2</option>
                    <option value="term3">Term 3</option>
                    <option value="final">Final Exam</option>
                </select>
                <button class="btn btn-outline">
                    <i class="fas fa-download"></i> Download Report
                </button>
            </div>
        </div>

        <div class="stats-container">
            <div class="stat-card result-stat">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                    <h3>A-</h3>
                    <p>Overall Grade</p>
                    <p class="text-success"><i class="fas fa-arrow-up"></i> Improved from B+</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="stat-info">
                    <h3>86%</h3>
                    <p>Average Percentage</p>
                    <p>Class Rank: 12/45</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="stat-info">
                    <h3>3</h3>
                    <p>Subjects with A Grade</p>
                    <p>Mathematics, Science, English</p>
                </div>
            </div>
        </div>

        <div class="chart-card">
            <h3>Subject-wise Performance</h3>
            <div class="chart-wrapper">
                <canvas id="resultsChart"></canvas>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3>Term 2 Examination Results</h3>
                <span>Published: April 15, 2024</span>
            </div>
            <div class="table-responsive">
                <table id="resultsTable">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Marks Obtained</th>
                            <th>Total Marks</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="resultsTableBody">
                        <!-- Results data will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Profile Page (Hidden by default) -->
    <div id="profilePage" class="page-content" style="display: none;">
        <div class="page-header">
            <h1><i class="fas fa-user"></i> My Profile</h1>
            <button class="btn btn-outline" id="editProfileBtn">
                <i class="fas fa-edit"></i> Edit Profile
            </button>
        </div>

        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-user-circle"></i> Personal Information
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                </div>
                <div class="card-content">
                    <div class="student-profile-details">
                        <div class="detail-item mb-2">
                            <div class="detail-label">Full Name</div>
                            <div class="detail-value">John Smith</div>
                        </div>
                        <div class="detail-item mb-2">
                            <div class="detail-label">Student ID</div>
                            <div class="detail-value">STU2023001</div>
                        </div>
                        <div class="detail-item mb-2">
                            <div class="detail-label">Date of Birth</div>
                            <div class="detail-value">June 15, 2008</div>
                        </div>
                        <div class="detail-item mb-2">
                            <div class="detail-label">Gender</div>
                            <div class="detail-value">Male</div>
                        </div>
                        <div class="detail-item mb-2">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">john.smith@school.edu</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value">+1 (555) 123-4567</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-school"></i> Academic Information
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
                <div class="card-content">
                    <div class="student-academic-details">
                        <div class="detail-item mb-2">
                            <div class="detail-label">Class & Section</div>
                            <div class="detail-value">Class 10 - Section A</div>
                        </div>
                        <div class="detail-item mb-2">
                            <div class="detail-label">Roll Number</div>
                            <div class="detail-value">15</div>
                        </div>
                        <div class="detail-item mb-2">
                            <div class="detail-label">Academic Year</div>
                            <div class="detail-value">2023-2024</div>
                        </div>
                        <div class="detail-item mb-2">
                            <div class="detail-label">Class Teacher</div>
                            <div class="detail-value">Ms. Sarah Johnson</div>
                        </div>
                        <div class="detail-item mb-2">
                            <div class="detail-label">Enrollment Date</div>
                            <div class="detail-value">August 1, 2023</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value"><span class="badge badge-success">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-home"></i> Address Information
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
                <div class="card-content">
                    <div class="student-address-details">
                        <div class="detail-item mb-2">
                            <div class="detail-label">Address</div>
                            <div class="detail-value">123 Main Street, Apt 4B</div>
                        </div>
                        <div class="detail-item mb-2">
                            <div class="detail-label">City</div>
                            <div class="detail-value">New York</div>
                        </div>
                        <div class="detail-item mb-2">
                            <div class="detail-label">State</div>
                            <div class="detail-value">NY</div>
                        </div>
                        <div class="detail-item mb-2">
                            <div class="detail-label">ZIP Code</div>
                            <div class="detail-value">10001</div>
                        </div>
                        <div class="detail-item mb-2">
                            <div class="detail-label">Country</div>
                            <div class="detail-value">United States</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Emergency Contact</div>
                            <div class="detail-value">Robert Smith (Father) - +1 (555) 987-6543</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
