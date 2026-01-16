<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard | School Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3a86ff;
            --secondary-color: #8338ec;
            --success-color: #06d6a0;
            --warning-color: #ffbe0b;
            --danger-color: #ef476f;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --border-radius: 10px;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header Styles */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eaeaea;
        }
        
        .header-left h1 {
            color: var(--primary-color);
            font-size: 28px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .parent-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .parent-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .notification-badge {
            position: relative;
            font-size: 24px;
            color: var(--gray-color);
            cursor: pointer;
        }
        
        .notification-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Student Selector */
        .student-selector {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 15px;
            margin-bottom: 25px;
            box-shadow: var(--box-shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .student-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        
        .student-details h3 {
            color: var(--dark-color);
            margin-bottom: 5px;
        }
        
        .student-details p {
            color: var(--gray-color);
            font-size: 14px;
        }
        
        .student-switch {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        /* Card Styles */
        .dashboard-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            transition: transform 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .card-header h3 {
            color: var(--dark-color);
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }
        
        /* Attendance Card */
        .attendance-card .card-icon {
            background-color: var(--success-color);
        }
        
        .attendance-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .attendance-stat {
            text-align: center;
        }
        
        .attendance-stat h4 {
            font-size: 24px;
            color: var(--dark-color);
        }
        
        .attendance-stat p {
            color: var(--gray-color);
            font-size: 14px;
        }
        
        /* Grades Card */
        .grades-card .card-icon {
            background-color: var(--primary-color);
        }
        
        .grade-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .grade-item:last-child {
            border-bottom: none;
        }
        
        .grade-subject {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .grade-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .grade-A { background-color: var(--success-color); }
        .grade-B { background-color: #38b000; }
        .grade-C { background-color: var(--warning-color); }
        .grade-D { background-color: #fb8500; }
        .grade-F { background-color: var(--danger-color); }
        
        /* Schedule Card */
        .schedule-card .card-icon {
            background-color: var(--secondary-color);
        }
        
        .schedule-item {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .schedule-time {
            width: 80px;
            font-weight: bold;
            color: var(--dark-color);
        }
        
        .schedule-details {
            flex: 1;
        }
        
        .schedule-subject {
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .schedule-teacher {
            color: var(--gray-color);
            font-size: 14px;
        }
        
        /* Notices Card */
        .notices-card .card-icon {
            background-color: var(--warning-color);
        }
        
        .notice-item {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .notice-item:last-child {
            border-bottom: none;
        }
        
        .notice-title {
            font-weight: bold;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
        }
        
        .notice-date {
            color: var(--gray-color);
            font-size: 12px;
        }
        
        .notice-content {
            color: var(--gray-color);
            font-size: 14px;
        }
        
        /* Upcoming Events */
        .events-card .card-icon {
            background-color: var(--danger-color);
        }
        
        .event-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .event-date {
            width: 60px;
            text-align: center;
            background-color: #f8f9fa;
            padding: 8px;
            border-radius: 6px;
        }
        
        .event-day {
            font-size: 20px;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .event-month {
            font-size: 12px;
            color: var(--gray-color);
            text-transform: uppercase;
        }
        
        .event-details h4 {
            margin-bottom: 3px;
        }
        
        /* Fee Status */
        .fees-card .card-icon {
            background-color: #06d6a0;
        }
        
        .fee-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .fee-due {
            font-size: 22px;
            font-weight: bold;
            color: var(--dark-color);
        }
        
        .fee-date {
            color: var(--gray-color);
            font-size: 14px;
        }
        
        .pay-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .pay-btn:hover {
            background-color: #2a75ff;
        }
        
        /* Quick Links */
        .quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .link-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: var(--box-shadow);
            text-decoration: none;
            color: var(--dark-color);
            transition: all 0.3s ease;
        }
        
        .link-card:hover {
            transform: translateY(-3px);
            background-color: var(--primary-color);
            color: white;
        }
        
        .link-icon {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background-color: #f0f7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .link-card:hover .link-icon {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        /* Responsive Design */
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .header-right {
                width: 100%;
                justify-content: space-between;
            }
            
            .student-selector {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .student-switch {
                align-self: flex-end;
            }
            
            .quick-links {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }
            
            .quick-links {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="dashboard-header">
             <form method="POST" action="{{ route('logout') }}" id="logout-form">
    @csrf
</form>

<a href="#" class="dropdown-item logout-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fas fa-sign-out-alt"></i>
    <span>{{ __('Log Out') }}</span>
</a>
            <div class="header-left">
                <h1><i class="fas fa-graduation-cap"></i> Parent Dashboard</h1>
            </div>
            <div class="header-right">
                <div class="parent-info">
                    <div class="parent-avatar">JD</div>
                    <div>
                        <h4>John Doe</h4>
                        <p>Parent of Emily & Alex</p>
                    </div>
                </div>
                <div class="notification-badge">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count">3</span>
                </div>
            </div>
        </header>
        
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
                <button class="pay-btn" style="background-color: #e9ecef; color: var(--dark-color);">
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <button class="pay-btn">
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
                    <span style="color: var(--success-color); font-weight: bold;">95%</span>
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
                <p style="color: var(--gray-color); font-size: 14px;">Last absence: 15 Nov 2023 (Medical)</p>
            </div>
            
            <!-- Grades Card -->
            <div class="dashboard-card grades-card">
                <div class="card-header">
                    <h3><span class="card-icon"><i class="fas fa-chart-line"></i></span> Recent Grades</h3>
                    <a href="#" style="color: var(--primary-color); text-decoration: none; font-size: 14px;">View All</a>
                </div>
                <div class="grade-item">
                    <div class="grade-subject">
                        <div class="grade-circle grade-A">A</div>
                        <div>
                            <h4>Mathematics</h4>
                            <p>Algebra Test</p>
                        </div>
                    </div>
                    <div>92%</div>
                </div>
                <div class="grade-item">
                    <div class="grade-subject">
                        <div class="grade-circle grade-B">B</div>
                        <div>
                            <h4>Science</h4>
                            <p>Physics Project</p>
                        </div>
                    </div>
                    <div>85%</div>
                </div>
                <div class="grade-item">
                    <div class="grade-subject">
                        <div class="grade-circle grade-A">A</div>
                        <div>
                            <h4>English</h4>
                            <p>Literature Essay</p>
                        </div>
                    </div>
                    <div>94%</div>
                </div>
            </div>
            
            <!-- Schedule Card -->
            <div class="dashboard-card schedule-card">
                <div class="card-header">
                    <h3><span class="card-icon"><i class="fas fa-clock"></i></span> Today's Schedule</h3>
                    <a href="#" style="color: var(--primary-color); text-decoration: none; font-size: 14px;">Full Schedule</a>
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
                    <div class="notification-count">2</div>
                </div>
                <div class="notice-item">
                    <div class="notice-title">
                        <span>Parent-Teacher Meeting</span>
                        <span class="notice-date">Dec 15, 2023</span>
                    </div>
                    <div class="notice-content">Scheduled for Friday, 10 AM in the school auditorium. All parents are requested to attend.</div>
                </div>
                <div class="notice-item">
                    <div class="notice-title">
                        <span>Science Fair Announcement</span>
                        <span class="notice-date">Dec 10, 2023</span>
                    </div>
                    <div class="notice-content">Annual Science Fair will be held on January 20, 2024. Students can register by December 30.</div>
                </div>
            </div>
            
            <!-- Upcoming Events -->
            <div class="dashboard-card events-card">
                <div class="card-header">
                    <h3><span class="card-icon"><i class="fas fa-calendar-day"></i></span> Upcoming Events</h3>
                    <a href="#" style="color: var(--primary-color); text-decoration: none; font-size: 14px;">View Calendar</a>
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
                    <h3><span class="card-icon"><i class="fas fa-file-invoice-dollar"></i></span> Fee Status</h3>
                    <span style="color: var(--success-color); font-weight: bold;">Paid</span>
                </div>
                <div class="fee-status">
                    <div>
                        <div class="fee-due">$450.00</div>
                        <div class="fee-date">Next due: Jan 10, 2024</div>
                    </div>
                    <button class="pay-btn">Pay Now</button>
                </div>
                <p style="color: var(--gray-color); font-size: 14px;">Last payment: $450 on Dec 5, 2023</p>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="quick-links">
            <a href="#" class="link-card">
                <div class="link-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div>
                    <h3>Homework</h3>
                    <p>View assignments & submissions</p>
                </div>
            </a>
            <a href="#" class="link-card">
                <div class="link-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div>
                    <h3>Messages</h3>
                    <p>Contact teachers & staff</p>
                </div>
            </a>
            <a href="#" class="link-card">
                <div class="link-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div>
                    <h3>Report Cards</h3>
                    <p>Download academic reports</p>
                </div>
            </a>
            <a href="#" class="link-card">
                <div class="link-icon">
                    <i class="fas fa-bus"></i>
                </div>
                <div>
                    <h3>Transport</h3>
                    <p>Bus routes & tracking</p>
                </div>
            </a>
        </div>
    </div>

    <script>
        // Simple interactive functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Notification badge click
            const notificationBadge = document.querySelector('.notification-badge');
            notificationBadge.addEventListener('click', function() {
                alert('You have 3 unread notifications:\n1. New homework assigned\n2. Report card available\n3. School event reminder');
                this.querySelector('.notification-count').style.display = 'none';
            });
            
            // Student switching buttons
            const prevBtn = document.querySelector('.student-switch button:first-child');
            const nextBtn = document.querySelector('.student-switch button:last-child');
            
            prevBtn.addEventListener('click', function() {
                alert('Switching to previous student: Alex Doe (Grade 6)');
            });
            
            nextBtn.addEventListener('click', function() {
                alert('Switching to next student: Alex Doe (Grade 6)');
            });
            
            // Pay button functionality
            const payBtn = document.querySelector('.fees-card .pay-btn');
            payBtn.addEventListener('click', function() {
                alert('Redirecting to secure payment portal...');
            });
            
            // Card links
            const viewAllLinks = document.querySelectorAll('a[href="#"]');
            viewAllLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const cardType = this.closest('.dashboard-card').querySelector('h3').textContent.trim();
                    alert(`Viewing all ${cardType} information...`);
                });
            });
            
            // Quick links
            const quickLinks = document.querySelectorAll('.link-card');
            quickLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const linkTitle = this.querySelector('h3').textContent;
                    alert(`Navigating to ${linkTitle} section...`);
                });
            });
        });
    </script>
</body>
</html>