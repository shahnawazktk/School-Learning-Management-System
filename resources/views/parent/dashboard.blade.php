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
            --sidebar-width: 280px;
            --sidebar-collapsed: 70px;
            --header-height: 70px;
            --border-radius: 10px;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
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
            overflow-x: hidden;
        }

        /* ========== LAYOUT ========== */
        .layout-container {
            display: flex;
            min-height: 100vh;
            width: 100vw;
            position: relative;
            overflow: hidden;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            transition: var(--transition);
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            height: var(--header-height);
            min-height: var(--header-height);
            flex-shrink: 0;
        }

        .sidebar-header h2 {
            color: white;
            font-weight: 700;
            white-space: nowrap;
            font-size: 1.4rem;
            transition: var(--transition);
        }

        .parent-profile-sidebar {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
        }

        .parent-avatar-sidebar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: bold;
            flex-shrink: 0;
        }

        .parent-info-sidebar h3 {
            font-size: 1.1rem;
            margin-bottom: 0.2rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: white;
        }

        .parent-info-sidebar p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-menu {
            padding: 1rem 0;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .menu-group {
            margin-bottom: 1rem;
            flex-shrink: 0;
        }

        .menu-group-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            padding: 0.5rem 1.5rem;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-top: 0.5rem;
            white-space: nowrap;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition);
            gap: 12px;
            border-left: 4px solid transparent;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: var(--primary-color);
            font-weight: 600;
        }

        .menu-icon {
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .menu-text {
            font-weight: 500;
            white-space: nowrap;
            transition: var(--transition);
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .logout-btn {
            width: 100%;
            padding: 0.8rem;
            background-color: rgba(239, 71, 111, 0.2);
            color: var(--danger-color);
            border: 1px solid rgba(239, 71, 111, 0.3);
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            white-space: nowrap;
        }

        .logout-btn:hover {
            background-color: rgba(239, 71, 111, 0.3);
        }

        /* Collapsed Sidebar */
        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .sidebar-header h2,
        .sidebar.collapsed .parent-info-sidebar,
        .sidebar.collapsed .menu-group-title {
            opacity: 0;
            width: 0;
            overflow: hidden;
            display: none;
        }

        .sidebar.collapsed .parent-profile-sidebar {
            justify-content: center;
            padding: 1rem;
        }

        /* Sidebar Overlay for Mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: var(--transition);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            width: calc(100vw - var(--sidebar-width));
            max-width: 100vw;
            overflow: hidden;
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
            width: calc(100vw - var(--sidebar-collapsed));
        }

        /* ========== HEADER ========== */
        .dashboard-header {
            height: var(--header-height);
            background-color: white;
            box-shadow: var(--box-shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 900;
            flex-shrink: 0;
            width: 100%;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--gray-color);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .toggle-sidebar:hover {
            background-color: #f1f5f9;
            color: var(--primary-color);
        }

        .page-title h1 {
            font-size: 1.5rem;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .notification-wrapper {
            position: relative;
        }

        .notification-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--gray-color);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border-radius: 5px;
            transition: var(--transition);
        }

        .notification-btn:hover {
            background-color: #f1f5f9;
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: var(--danger-color);
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .parent-profile-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.5rem 0.8rem;
            border-radius: 8px;
            background-color: #f8fafc;
            cursor: pointer;
            transition: var(--transition);
            white-space: nowrap;
        }

        .parent-profile-header:hover {
            background-color: #f1f5f9;
        }

        .parent-avatar-header {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .parent-info-header h4 {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .parent-info-header p {
            font-size: 0.8rem;
            color: var(--gray-color);
        }

        /* ========== CONTENT AREA ========== */
        .content {
            padding: 2rem;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            width: 100%;
            height: calc(100vh - var(--header-height));
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        .content::-webkit-scrollbar {
            width: 6px;
        }

        .content::-webkit-scrollbar-track {
            background: transparent;
        }

        .content::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }

        /* ========== DASHBOARD CONTENT ========== */
        .student-selector {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 20px;
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
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(131, 56, 236, 0.3);
        }

        .student-details h3 {
            color: var(--dark-color);
            margin-bottom: 5px;
            font-size: 1.4rem;
        }

        .student-details p {
            color: var(--gray-color);
            font-size: 0.95rem;
        }

        .student-switch {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .switch-btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .switch-btn.prev {
            background-color: #e9ecef;
            color: var(--dark-color);
        }

        .switch-btn.next {
            background-color: var(--primary-color);
            color: white;
        }

        .switch-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            padding: 25px;
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
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .card-header h3 {
            color: var(--dark-color);
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        /* Attendance Card */
        .attendance-card .card-icon {
            background: linear-gradient(135deg, var(--success-color), #0ca678);
        }

        .attendance-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .attendance-stat {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            background-color: #f8f9fa;
        }

        .attendance-stat h4 {
            font-size: 28px;
            color: var(--dark-color);
            margin-bottom: 5px;
        }

        .attendance-stat p {
            color: var(--gray-color);
            font-size: 0.85rem;
        }

        /* Grades Card */
        .grades-card .card-icon {
            background: linear-gradient(135deg, var(--primary-color), #2a75ff);
        }

        .grade-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .grade-item:last-child {
            border-bottom: none;
        }

        .grade-subject {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .grade-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .grade-A {
            background: linear-gradient(135deg, var(--success-color), #0ca678);
        }

        .grade-B {
            background: linear-gradient(135deg, #38b000, #2d8c00);
        }

        .grade-C {
            background: linear-gradient(135deg, var(--warning-color), #e6ac00);
        }

        .grade-D {
            background: linear-gradient(135deg, #fb8500, #e07a00);
        }

        .grade-F {
            background: linear-gradient(135deg, var(--danger-color), #d43c5f);
        }

        /* Schedule Card */
        .schedule-card .card-icon {
            background: linear-gradient(135deg, var(--secondary-color), #7229d9);
        }

        .schedule-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .schedule-time {
            width: 90px;
            font-weight: bold;
            color: var(--dark-color);
            font-size: 1.1rem;
        }

        .schedule-details {
            flex: 1;
        }

        .schedule-subject {
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .schedule-teacher {
            color: var(--gray-color);
            font-size: 0.9rem;
        }

        /* Notices Card */
        .notices-card .card-icon {
            background: linear-gradient(135deg, var(--warning-color), #e6ac00);
        }

        .notice-item {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .notice-item:last-child {
            border-bottom: none;
        }

        .notice-title {
            font-weight: bold;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notice-date {
            color: var(--gray-color);
            font-size: 0.85rem;
            background: #f8f9fa;
            padding: 3px 8px;
            border-radius: 4px;
        }

        .notice-content {
            color: var(--gray-color);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Upcoming Events */
        .events-card .card-icon {
            background: linear-gradient(135deg, var(--danger-color), #d43c5f);
        }

        .event-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .event-date {
            width: 70px;
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .event-day {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .event-month {
            font-size: 0.9rem;
            color: var(--gray-color);
            text-transform: uppercase;
        }

        .event-details h4 {
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .event-details p {
            color: var(--gray-color);
            font-size: 0.9rem;
        }

        /* Fee Status */
        .fees-card .card-icon {
            background: linear-gradient(135deg, #06d6a0, #0ca678);
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
            font-size: 28px;
            font-weight: bold;
            color: var(--dark-color);
        }

        .fee-date {
            color: var(--gray-color);
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .pay-btn {
            background: linear-gradient(135deg, var(--primary-color), #2a75ff);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pay-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(58, 134, 255, 0.3);
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
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: var(--box-shadow);
            text-decoration: none;
            color: var(--dark-color);
            transition: all 0.3s ease;
        }

        .link-card:hover {
            transform: translateY(-5px);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .link-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: linear-gradient(135deg, #f0f7ff, #e6f0ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .link-card:hover .link-icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .link-content h3 {
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .link-content p {
            color: var(--gray-color);
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .link-card:hover .link-content p {
            color: rgba(255, 255, 255, 0.8);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar.collapsed {
                width: var(--sidebar-width);
            }

            .main-content {
                margin-left: 0;
                width: 100vw;
            }

            .main-content.expanded {
                margin-left: 0;
                width: 100vw;
            }

            .toggle-sidebar {
                display: flex;
            }

            .quick-links {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .dashboard-header {
                padding: 0 1rem;
            }

            .content {
                padding: 1.5rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .header-right {
                gap: 1rem;
            }

            .student-selector {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .student-switch {
                align-self: stretch;
                justify-content: space-between;
            }

            .switch-btn {
                flex: 1;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .content {
                padding: 1rem;
            }

            .parent-info-header {
                display: none;
            }

            .quick-links {
                grid-template-columns: 1fr;
            }

            .page-title h1 {
                font-size: 1.3rem;
            }

            .header-right {
                gap: 0.5rem;
            }
        }

        /* ========== UTILITY CLASSES ========== */
        .text-center {
            text-align: center;
        }

        .text-success {
            color: var(--success-color);
        }

        .text-warning {
            color: var(--warning-color);
        }

        .text-danger {
            color: var(--danger-color);
        }

        .hidden {
            display: none !important;
        }

        .w-full {
            width: 100%;
        }

        .flex {
            display: flex;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .mb-1 {
            margin-bottom: 0.5rem;
        }

        .mb-2 {
            margin-bottom: 1rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="layout-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-graduation-cap" style="color: var(--primary-color); font-size: 1.8rem;"></i>
                <h2>Parent Portal</h2>
            </div>

            <div class="parent-profile-sidebar">
                <div class="parent-avatar-sidebar">JD</div>
                <div class="parent-info-sidebar">
                    <h3>John Doe</h3>
                    <p><i class="fas fa-user"></i> Parent Account</p>
                    <p><i class="fas fa-users"></i> 2 Children</p>
                </div>
            </div>

            <div class="sidebar-menu">
                <div class="menu-group">
                    <div class="menu-group-title">DASHBOARD</div>
                    <a href="#" class="menu-item active" data-page="dashboard">
                        <i class="fas fa-tachometer-alt menu-icon"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </div>

                <div class="menu-group">
                    <div class="menu-group-title">MY CHILDREN</div>
                    <a href="#" class="menu-item" data-page="children">
                        <i class="fas fa-child menu-icon"></i>
                        <span class="menu-text">Children Profile</span>
                    </a>
                    <a href="#" class="menu-item" data-page="attendance">
                        <i class="fas fa-calendar-check menu-icon"></i>
                        <span class="menu-text">Attendance</span>
                    </a>
                    <a href="#" class="menu-item" data-page="grades">
                        <i class="fas fa-chart-line menu-icon"></i>
                        <span class="menu-text">Grades & Reports</span>
                    </a>
                </div>

                <div class="menu-group">
                    <div class="menu-group-title">SCHOOL</div>
                    <a href="#" class="menu-item" data-page="schedule">
                        <i class="fas fa-clock menu-icon"></i>
                        <span class="menu-text">Class Schedule</span>
                    </a>
                    <a href="#" class="menu-item" data-page="homework">
                        <i class="fas fa-book menu-icon"></i>
                        <span class="menu-text">Homework</span>
                    </a>
                    <a href="#" class="menu-item" data-page="notices">
                        <i class="fas fa-bullhorn menu-icon"></i>
                        <span class="menu-text">Notices</span>
                    </a>
                </div>

                <div class="menu-group">
                    <div class="menu-group-title">FINANCE</div>
                    <a href="#" class="menu-item" data-page="fees">
                        <i class="fas fa-file-invoice-dollar menu-icon"></i>
                        <span class="menu-text">Fee Status</span>
                    </a>
                    <a href="#" class="menu-item" data-page="payments">
                        <i class="fas fa-credit-card menu-icon"></i>
                        <span class="menu-text">Payment History</span>
                    </a>
                </div>

                <div class="menu-group">
                    <div class="menu-group-title">COMMUNICATION</div>
                    <a href="#" class="menu-item" data-page="messages">
                        <i class="fas fa-comments menu-icon"></i>
                        <span class="menu-text">Messages</span>
                    </a>
                    <a href="#" class="menu-item" data-page="teachers">
                        <i class="fas fa-chalkboard-teacher menu-icon"></i>
                        <span class="menu-text">Teachers</span>
                    </a>
                </div>
            </div>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                </form>
                <button class="logout-btn"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Log Out</span>
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Header -->
            <header class="dashboard-header">
                <div class="header-left">
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="page-title">
                        <h1 id="pageTitle"><i class="fas fa-tachometer-alt"></i> Parent Dashboard</h1>
                    </div>
                </div>
                <div class="header-right">
                    <div class="notification-wrapper">
                        <button class="notification-btn" id="notificationBtn">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                    </div>
                    <div class="parent-profile-header">
                        <div class="parent-avatar-header">JD</div>
                        <div class="parent-info-header">
                            <h4>John Doe</h4>
                            <p>Parent Account</p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="content">
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
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const toggleSidebarBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        const menuItems = document.querySelectorAll('.menu-item');
        const notificationBtn = document.getElementById('notificationBtn');
        const prevStudentBtn = document.getElementById('prevStudent');
        const nextStudentBtn = document.getElementById('nextStudent');
        const payFeesBtn = document.getElementById('payFees');
        const pageTitle = document.getElementById('pageTitle');

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Parent Dashboard loaded successfully");

            // Set up event listeners
            setupEventListeners();

            // Set initial sidebar state based on screen size
            updateSidebarState();

            // Set up menu navigation
            setupMenuNavigation();
        });

        // Update sidebar state based on screen size
        function updateSidebarState() {
            if (window.innerWidth <= 1024) {
                sidebar.classList.remove('collapsed');
                sidebar.classList.remove('active');
                mainContent.classList.remove('expanded');
            } else {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        }

        // Set up menu navigation
        function setupMenuNavigation() {
            menuItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all menu items
                    menuItems.forEach(i => i.classList.remove('active'));

                    // Add active class to clicked item
                    this.classList.add('active');

                    // Update page title
                    const menuText = this.querySelector('.menu-text').textContent;
                    const iconHTML = this.querySelector('.menu-icon').outerHTML;
                    pageTitle.innerHTML = `${iconHTML} ${menuText}`;

                    // Show notification for demo
                    if (this.dataset.page !== 'dashboard') {
                        showNotification(`Opening ${menuText} page...`, 'info');
                    }

                    // Close sidebar on mobile after clicking
                    if (window.innerWidth <= 1024) {
                        sidebar.classList.remove('active');
                        sidebarOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            });
        }

        // Set up all event listeners
        function setupEventListeners() {
            // Toggle sidebar function
            const toggleSidebar = () => {
                const isMobile = window.innerWidth <= 1024;

                if (isMobile) {
                    sidebar.classList.toggle('active');
                    sidebarOverlay.classList.toggle('active');
                    document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
                } else {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                }
            };

            // Toggle sidebar button
            toggleSidebarBtn.addEventListener('click', toggleSidebar);

            // Close sidebar overlay click
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });

            // Notification button
            notificationBtn.addEventListener('click', function() {
                showNotification(
                    'You have 3 notifications:\n1. New homework assigned\n2. Report card available\n3. School event reminder',
                    'info');
                this.querySelector('.notification-badge').style.display = 'none';
            });

            // Student switching buttons
            prevStudentBtn.addEventListener('click', function() {
                showNotification('Switching to previous student: Alex Doe (Grade 6)', 'info');
            });

            nextStudentBtn.addEventListener('click', function() {
                showNotification('Switching to next student: Alex Doe (Grade 6)', 'info');
            });

            // Pay fees button
            payFeesBtn.addEventListener('click', function() {
                showNotification('Redirecting to secure payment portal...', 'success');
            });

            // Card links
            const viewAllLinks = document.querySelectorAll('.card-header a');
            viewAllLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const cardType = this.closest('.dashboard-card').querySelector('h3').textContent.trim();
                    showNotification(`Viewing all ${cardType} information...`, 'info');
                });
            });

            // Quick links
            const quickLinks = document.querySelectorAll('.link-card');
            quickLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const linkTitle = this.querySelector('h3').textContent;
                    showNotification(`Navigating to ${linkTitle} section...`, 'info');
                });
            });

            // Handle window resize
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    updateSidebarState();

                    // Close mobile sidebar if resizing to desktop
                    if (window.innerWidth > 1024) {
                        sidebar.classList.remove('active');
                        sidebarOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }, 250);
            });
        }

        // Show notification
        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                color: white;
                font-weight: 500;
                z-index: 9999;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                max-width: 350px;
                animation: slideIn 0.3s ease;
                word-break: break-word;
                background-color: ${type === 'success' ? '#06d6a0' : type === 'error' ? '#ef476f' : type === 'warning' ? '#ffbe0b' : '#3a86ff'};
            `;

            notification.innerHTML = `
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                    <div>${message}</div>
                </div>
            `;

            document.body.appendChild(notification);

            // Remove notification after 5 seconds
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 5000);

            // Add CSS for animations
            if (!document.getElementById('notification-styles')) {
                const style = document.createElement('style');
                style.id = 'notification-styles';
                style.textContent = `
                    @keyframes slideIn {
                        from { transform: translateX(100%); opacity: 0; }
                        to { transform: translateX(0); opacity: 1; }
                    }
                    @keyframes slideOut {
                        from { transform: translateX(0); opacity: 1; }
                        to { transform: translateX(100%); opacity: 0; }
                    }
                `;
                document.head.appendChild(style);
            }
        }
    </script>
</body>

</html>
