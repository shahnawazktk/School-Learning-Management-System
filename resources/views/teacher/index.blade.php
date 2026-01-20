@extends('layouts.teacher.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Welcome, Prof. John Smith! 👨‍🏫</h2>
            <p class="text-muted">Monday, December 16, 2024 | Today's Schedule</p>
        </div>
        <div>
            <button class="btn btn-primary shadow-sm me-2" data-bs-toggle="modal" data-bs-target="#createAssignmentModal">
                <i class="fas fa-plus-circle me-2"></i>New Assignment
            </button>
            <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#takeAttendanceModal">
                <i class="fas fa-clipboard-check me-2"></i>Take Attendance
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary-light text-primary me-3">
                        <i class="fas fa-chalkboard-teacher fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">6</h5>
                        <small class="text-muted">Classes Assigned</small>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-primary">
                        <i class="fas fa-arrow-up me-1"></i>This Week: 12
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success-light text-success me-3">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">180</h5>
                        <small class="text-muted">Total Students</small>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-success">
                        <i class="fas fa-user-check me-1"></i>Present Today: 165
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning-light text-warning me-3">
                        <i class="fas fa-tasks fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">8</h5>
                        <small class="text-muted">Pending Assessments</small>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-warning">
                        <i class="fas fa-clock me-1"></i>2 overdue
                    </small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-info-light text-info me-3">
                        <i class="fas fa-calendar-alt fa-lg"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">3</h5>
                        <small class="text-muted">Upcoming Events</small>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-info">
                        <i class="fas fa-bell me-1"></i>Next: Staff Meeting
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Column - Today's Schedule -->
        <div class="col-lg-8">
            <!-- Today's Timetable -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-calendar-day text-primary me-2"></i>Today's Schedule
                    </h5>
                    <div>
                        <span class="badge bg-light text-dark me-2">
                            <i class="fas fa-clock me-1"></i>10:30 AM
                        </span>
                        <a href="#" class="btn btn-sm btn-outline-primary">View Full Timetable</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Period</th>
                                    <th>Subject & Class</th>
                                    <th>Time</th>
                                    <th>Room</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">Period 1</div>
                                        <small>Regular</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">Mathematics</div>
                                        <small class="text-muted">Class 10A • Sec A</small>
                                    </td>
                                    <td>
                                        <div>08:00 AM - 09:00 AM</div>
                                        <small class="text-muted">Completed</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-door-open me-1"></i>Room 101
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Attendance Done
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary px-3" disabled>
                                            <i class="fas fa-check me-1"></i>Completed
                                        </button>
                                    </td>
                                </tr>
                                <tr class="table-primary">
                                    <td class="ps-4">
                                        <div class="fw-bold">Period 2</div>
                                        <small>Regular</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">Science</div>
                                        <small class="text-muted">Class 9B • Sec B</small>
                                    </td>
                                    <td>
                                        <div>09:15 AM - 10:15 AM</div>
                                        <small class="text-primary">In Progress</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-door-open me-1"></i>Room 205
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock me-1"></i>Pending
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success px-3 start-class-btn" data-period-id="2">
                                            <i class="fas fa-play-circle me-1"></i>Start Class
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">Period 3</div>
                                        <small>Lab</small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">Physics</div>
                                        <small class="text-muted">Class 11 • Sec C</small>
                                    </td>
                                    <td>
                                        <div>10:30 AM - 12:00 PM</div>
                                        <small class="text-muted">Upcoming</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <i class="fas fa-door-open me-1"></i>Lab 301
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock me-1"></i>Pending
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-light border px-3">
                                            <i class="fas fa-edit me-1"></i>Plan
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-bolt text-warning me-2"></i>Quick Actions
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="#" class="btn btn-action btn-outline-primary w-100 py-3">
                                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                                        <div>Create Assignment</div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-action btn-outline-success w-100 py-3">
                                        <i class="fas fa-clipboard-check fa-2x mb-2"></i>
                                        <div>Mark Attendance</div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-action btn-outline-info w-100 py-3">
                                        <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                                        <div>Enter Marks</div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-action btn-outline-warning w-100 py-3">
                                        <i class="fas fa-book-open fa-2x mb-2"></i>
                                        <div>Add Lesson Plan</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0 fw-bold">
                                <i class="fas fa-bell text-danger me-2"></i>Recent Notifications
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="notification-list">
                                <div class="d-flex align-items-start mb-3 pb-2 border-bottom">
                                    <div class="notification-icon me-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">New Assignment Submission</h6>
                                        <p class="text-muted small mb-0">Class 10A - Mathematics assignment submitted</p>
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>10 minutes ago
                                        </small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start mb-3 pb-2 border-bottom">
                                    <div class="notification-icon me-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-user-check text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Attendance Reminder</h6>
                                        <p class="text-muted small mb-0">Mark attendance for Period 2</p>
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>30 minutes ago
                                        </small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start mb-3 pb-2 border-bottom">
                                    <div class="notification-icon me-3">
                                        <div class="icon-circle bg-info">
                                            <i class="fas fa-users text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Staff Meeting Today</h6>
                                        <p class="text-muted small mb-0">Monthly staff meeting at 3:00 PM</p>
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>2 hours ago
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-secondary w-100 mt-2">
                                View All Notifications
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Pending Assessments -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-tasks text-danger me-2"></i>Pending Assessments
                    </h5>
                    <span class="badge bg-danger">3</span>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="subject-icon me-3">
                            <div class="rounded-circle bg-light p-2">
                                <i class="fas fa-calculator text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Algebra Test</h6>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">
                                    Class 10A • Mathematics
                                </small>
                                <small class="text-danger">
                                    <i class="far fa-clock me-1"></i>
                                    Due yesterday
                                </small>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-success" style="width: 60%"></div>
                            </div>
                            <small class="text-muted">
                                18/30 graded
                            </small>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-primary ms-2">
                            Grade
                        </a>
                    </div>
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="subject-icon me-3">
                            <div class="rounded-circle bg-light p-2">
                                <i class="fas fa-flask text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Science Project</h6>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">
                                    Class 9B • Science
                                </small>
                                <small class="text-warning">
                                    <i class="far fa-clock me-1"></i>
                                    Due tomorrow
                                </small>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-success" style="width: 30%"></div>
                            </div>
                            <small class="text-muted">
                                9/30 graded
                            </small>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-primary ms-2">
                            Grade
                        </a>
                    </div>
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="subject-icon me-3">
                            <div class="rounded-circle bg-light p-2">
                                <i class="fas fa-book text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">English Essay</h6>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">
                                    Class 11 • English
                                </small>
                                <small class="text-warning">
                                    <i class="far fa-clock me-1"></i>
                                    Due in 2 days
                                </small>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-success" style="width: 45%"></div>
                            </div>
                            <small class="text-muted">
                                13/29 graded
                            </small>
                        </div>
                        <a href="#" class="btn btn-sm btn-outline-primary ms-2">
                            Grade
                        </a>
                    </div>
                    <a href="#" class="btn btn-sm btn-outline-secondary w-100">
                        View All Assessments
                    </a>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-calendar-check text-info me-2"></i>Upcoming Events
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="event-date me-3 text-center">
                            <div class="bg-info text-white rounded-top p-1">
                                <small>Dec</small>
                            </div>
                            <div class="border p-2 rounded-bottom">
                                <h5 class="mb-0 fw-bold">16</h5>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Staff Meeting</h6>
                            <p class="text-muted small mb-1">
                                <i class="far fa-clock me-1"></i>
                                03:00 PM - 04:30 PM
                            </p>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                Conference Room
                            </p>
                            <span class="badge bg-info mt-1">
                                <i class="fas fa-users me-1"></i>Staff Meeting
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <div class="event-date me-3 text-center">
                            <div class="bg-info text-white rounded-top p-1">
                                <small>Dec</small>
                            </div>
                            <div class="border p-2 rounded-bottom">
                                <h5 class="mb-0 fw-bold">18</h5>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Parent-Teacher Meeting</h6>
                            <p class="text-muted small mb-1">
                                <i class="far fa-clock me-1"></i>
                                09:00 AM - 12:00 PM
                            </p>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                School Auditorium
                            </p>
                            <span class="badge bg-warning mt-1">
                                <i class="fas fa-handshake me-1"></i>Parent Meeting
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <div class="event-date me-3 text-center">
                            <div class="bg-info text-white rounded-top p-1">
                                <small>Dec</small>
                            </div>
                            <div class="border p-2 rounded-bottom">
                                <h5 class="mb-0 fw-bold">20</h5>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">Science Fair</h6>
                            <p class="text-muted small mb-1">
                                <i class="far fa-clock me-1"></i>
                                10:00 AM - 02:00 PM
                            </p>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                School Ground
                            </p>
                            <span class="badge bg-success mt-1">
                                <i class="fas fa-flask me-1"></i>School Event
                            </span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-sm btn-outline-info w-100">
                        View Calendar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="createAssignmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="quickAssignmentForm">
                    <div class="mb-3">
                        <label class="form-label">Select Class</label>
                        <select class="form-select" name="class_id" required>
                            <option value="">Choose class...</option>
                            <option value="1">Class 10A - Mathematics</option>
                            <option value="2">Class 9B - Science</option>
                            <option value="3">Class 11 - English</option>
                            <option value="4">Class 10B - Mathematics</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assignment Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter assignment title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="datetime-local" class="form-control" name="due_date" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="quickAssignmentForm" class="btn btn-primary">Create Assignment</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="takeAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Take Attendance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="quickAttendanceForm">
                    <div class="mb-3">
                        <label class="form-label">Select Class & Period</label>
                        <select class="form-select" name="period_id" required>
                            <option value="">Select period...</option>
                            <option value="2">Period 2: Science - Class 9B</option>
                            <option value="3">Period 3: Physics - Class 11</option>
                            <option value="4">Period 4: Mathematics - Class 10B</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        You can mark students as Present, Absent, or Late
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="quickAttendanceForm" class="btn btn-success">Take Attendance</button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-light { background-color: rgba(255, 193, 7, 0.1); }
    .bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
    .bg-danger-light { background-color: rgba(220, 53, 69, 0.1); }
    
    .icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-action {
        height: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .notification-list {
        max-height: 300px;
        overflow-y: auto;
    }
    
    .event-date {
        min-width: 50px;
    }
    
    .card {
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .subject-icon .rounded-circle {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .progress {
        border-radius: 10px;
    }
    
    .start-class-btn:hover {
        transform: scale(1.05);
        transition: transform 0.2s;
    }
    
    .table tbody tr {
        transition: background-color 0.2s;
    }
    
    .table tbody tr:hover {
        background-color: rgba(0,0,0,0.02);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Start Class Button
    document.querySelectorAll('.start-class-btn').forEach(button => {
        button.addEventListener('click', function() {
            const periodId = this.dataset.periodId;
            alert('Starting class for period ' + periodId);
            // In real implementation, this would redirect to class session page
            // window.location.href = `/teacher/class/${periodId}/start`;
        });
    });
    
    // Quick Assignment Form
    const assignmentForm = document.getElementById('quickAssignmentForm');
    if(assignmentForm) {
        assignmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Assignment created successfully!');
            $('#createAssignmentModal').modal('hide');
        });
    }
    
    // Quick Attendance Form
    const attendanceForm = document.getElementById('quickAttendanceForm');
    if(attendanceForm) {
        attendanceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Redirecting to attendance page...');
            // In real implementation, this would redirect to attendance page
            // window.location.href = `/teacher/attendance/take?period=${this.period_id.value}`;
        });
    }
});
</script>
@endsection