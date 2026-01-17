@extends('layouts.parent.app')
@section('content')
 <!-- Student Selector -->
                <div class="student-selector">
                    <div class="student-info">
                        <div class="student-avatar">ED</div>
                        <div class="student-details">
                            <h3>Emily Doe</h3>
                            <p>Grade 8 | Roll No: 24 | Age: 13</p>
                        </div>
                    </div>
                    <div class="student-switch">
                        <button class="switch-btn prev" id="prevStudent">
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                        <button class="switch-btn next" id="nextStudent">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Dashboard Grid -->
                <div class="dashboard-grid">
                    <!-- Attendance Card -->
                    <div class="dashboard-card attendance-card">
                        <div class="card-header">
                            <h3><span class="card-icon"><i class="fas fa-calendar-check"></i></span> Attendance</h3>
                            <span style="color: var(--success-color); font-weight: bold; font-size: 1.2rem;">95%</span>
                        </div>
                        <div class="attendance-stats">
                            <div class="attendance-stat">
                                <h4>182</h4>
                                <p>Days Present</p>
                            </div>
                            <div class="attendance-stat">
                                <h4>8</h4>
                                <p>Days Absent</p>
                            </div>
                            <div class="attendance-stat">
                                <h4>2</h4>
                                <p>Late Arrivals</p>
                            </div>
                        </div>
                        <p style="color: var(--gray-color); font-size: 0.9rem; margin-top: 10px;">
                            <i class="fas fa-info-circle"></i> Last absence: 15 Nov 2023 (Medical)
                        </p>
                    </div>

                    <!-- Grades Card -->
                    <div class="dashboard-card grades-card">
                        <div class="card-header">
                            <h3><span class="card-icon"><i class="fas fa-chart-line"></i></span> Recent Grades</h3>
                            <a href="#"
                                style="color: var(--primary-color); text-decoration: none; font-size: 0.9rem; font-weight: 600;">View
                                All</a>
                        </div>
                        <div class="grade-item">
                            <div class="grade-subject">
                                <div class="grade-circle grade-A">A</div>
                                <div>
                                    <h4>Mathematics</h4>
                                    <p style="color: var(--gray-color); font-size: 0.9rem;">Algebra Test</p>
                                </div>
                            </div>
                            <div style="font-weight: bold; font-size: 1.1rem;">92%</div>
                        </div>
                        <div class="grade-item">
                            <div class="grade-subject">
                                <div class="grade-circle grade-B">B</div>
                                <div>
                                    <h4>Science</h4>
                                    <p style="color: var(--gray-color); font-size: 0.9rem;">Physics Project</p>
                                </div>
                            </div>
                            <div style="font-weight: bold; font-size: 1.1rem;">85%</div>
                        </div>
                        <div class="grade-item">
                            <div class="grade-subject">
                                <div class="grade-circle grade-A">A</div>
                                <div>
                                    <h4>English</h4>
                                    <p style="color: var(--gray-color); font-size: 0.9rem;">Literature Essay</p>
                                </div>
                            </div>
                            <div style="font-weight: bold; font-size: 1.1rem;">94%</div>
                        </div>
                    </div>

                    <!-- Schedule Card -->
                    <div class="dashboard-card schedule-card">
                        <div class="card-header">
                            <h3><span class="card-icon"><i class="fas fa-clock"></i></span> Today's Schedule</h3>
                            <a href="#"
                                style="color: var(--primary-color); text-decoration: none; font-size: 0.9rem; font-weight: 600;">Full
                                Schedule</a>
                        </div>
                        <div class="schedule-item">
                            <div class="schedule-time">08:00 AM</div>
                            <div class="schedule-details">
                                <div class="schedule-subject">Mathematics</div>
                                <div class="schedule-teacher">Mr. Johnson | Room 204</div>
                            </div>
                        </div>
                        <div class="schedule-item">
                            <div class="schedule-time">09:30 AM</div>
                            <div class="schedule-details">
                                <div class="schedule-subject">Science Lab</div>
                                <div class="schedule-teacher">Dr. Williams | Lab 3</div>
                            </div>
                        </div>
                        <div class="schedule-item">
                            <div class="schedule-time">11:00 AM</div>
                            <div class="schedule-details">
                                <div class="schedule-subject">English</div>
                                <div class="schedule-teacher">Ms. Anderson | Room 108</div>
                            </div>
                        </div>
                    </div>

                    <!-- Notices Card -->
                    <div class="dashboard-card notices-card">
                        <div class="card-header">
                            <h3><span class="card-icon"><i class="fas fa-bullhorn"></i></span> School Notices</h3>
                            <div class="notification-badge">2</div>
                        </div>
                        <div class="notice-item">
                            <div class="notice-title">
                                <span>Parent-Teacher Meeting</span>
                                <span class="notice-date">Dec 15, 2023</span>
                            </div>
                            <div class="notice-content">Scheduled for Friday, 10 AM in the school auditorium. All
                                parents are requested to attend.</div>
                        </div>
                        <div class="notice-item">
                            <div class="notice-title">
                                <span>Science Fair Announcement</span>
                                <span class="notice-date">Dec 10, 2023</span>
                            </div>
                            <div class="notice-content">Annual Science Fair will be held on January 20, 2024. Students
                                can register by December 30.</div>
                        </div>
                    </div>

                    <!-- Upcoming Events -->
                    <div class="dashboard-card events-card">
                        <div class="card-header">
                            <h3><span class="card-icon"><i class="fas fa-calendar-day"></i></span> Upcoming Events
                            </h3>
                            <a href="#"
                                style="color: var(--primary-color); text-decoration: none; font-size: 0.9rem; font-weight: 600;">View
                                Calendar</a>
                        </div>
                        <div class="event-item">
                            <div class="event-date">
                                <div class="event-day">20</div>
                                <div class="event-month">Dec</div>
                            </div>
                            <div class="event-details">
                                <h4>Winter Concert</h4>
                                <p>School Auditorium | 6:00 PM</p>
                            </div>
                        </div>
                        <div class="event-item">
                            <div class="event-date">
                                <div class="event-day">25</div>
                                <div class="event-month">Dec</div>
                            </div>
                            <div class="event-details">
                                <h4>Winter Break Begins</h4>
                                <p>No classes until Jan 5</p>
                            </div>
                        </div>
                    </div>

                    <!-- Fee Status -->
                    <div class="dashboard-card fees-card">
                        <div class="card-header">
                            <h3><span class="card-icon"><i class="fas fa-file-invoice-dollar"></i></span> Fee Status
                            </h3>
                            <span
                                style="color: var(--success-color); font-weight: bold; font-size: 1.1rem;">Paid</span>
                        </div>
                        <div class="fee-status">
                            <div>
                                <div class="fee-due">$450.00</div>
                                <div class="fee-date">Next due: Jan 10, 2024</div>
                            </div>
                            <button class="pay-btn" id="payFees">
                                <i class="fas fa-credit-card"></i> Pay Now
                            </button>
                        </div>
                        <p style="color: var(--gray-color); font-size: 0.9rem; margin-top: 10px;">
                            <i class="fas fa-check-circle"></i> Last payment: $450 on Dec 5, 2023
                        </p>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="quick-links">
                    <a href="#" class="link-card">
                        <div class="link-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="link-content">
                            <h3>Homework</h3>
                            <p>View assignments & submissions</p>
                        </div>
                    </a>
                    <a href="#" class="link-card">
                        <div class="link-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="link-content">
                            <h3>Messages</h3>
                            <p>Contact teachers & staff</p>
                        </div>
                    </a>
                    <a href="#" class="link-card">
                        <div class="link-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="link-content">
                            <h3>Report Cards</h3>
                            <p>Download academic reports</p>
                        </div>
                    </a>
                    <a href="#" class="link-card">
                        <div class="link-icon">
                            <i class="fas fa-bus"></i>
                        </div>
                        <div class="link-content">
                            <h3>Transport</h3>
                            <p>Bus routes & tracking</p>
                        </div>
                    </a>
                </div>
@endsection