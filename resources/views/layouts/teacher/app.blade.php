<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher | Dashboard</title>
    <link rel="icon" href="{{ asset('img/smart-icon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #8b5cf6;
            --secondary-color: #7c3aed;
            --accent-color: #a78bfa;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --gray-color: #64748b;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
            --header-height: 70px;
            --border-radius: 10px;
            --box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: var(--dark-color);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ========== LAYOUT CONTAINER ========== */
        .layout-container {
            display: flex;
            min-height: 100vh;
            width: 100vw;
            position: relative;
            overflow: hidden;
        }

        /* ========== SIDEBAR FIXED STRUCTURE ========== */
        .sidebar {
            width: var(--sidebar-width);
            background-color: white;
            box-shadow: var(--box-shadow);
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
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 12px;
            height: var(--header-height);
            min-height: var(--header-height);
            flex-shrink: 0;
        }

        .logo-container {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .logo-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
        }

        .logo-img {
            width: 50px;
            /* 👈 yahan size control hota hai */
            height: auto;
        }

        .sidebar-header h2 {
            color: var(--primary-color);
            font-weight: 700;
            white-space: nowrap;
            font-size: 1.4rem;
            transition: var(--transition);
        }

        .teacher-profile-sidebar {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
        }

        .teacher-avatar {
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

        .teacher-info-sidebar h3 {
            font-size: 1.1rem;
            margin-bottom: 0.2rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .teacher-info-sidebar p {
            color: var(--gray-color);
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
            background-color: #cbd5e1;
            border-radius: 10px;
        }

        .menu-group {
            margin-bottom: 1rem;
            flex-shrink: 0;
        }

        .menu-group-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--gray-color);
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
            color: var(--gray-color);
            text-decoration: none;
            transition: var(--transition);
            gap: 12px;
            border-left: 4px solid transparent;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .menu-item:hover {
            background-color: #f8fafc;
            color: var(--primary-color);
        }

        .menu-item.active {
            background-color: #f5f3ff;
            color: var(--primary-color);
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
            border-top: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .logout-btn {
            width: 100%;
            padding: 0.8rem;
            background-color: #fef2f2;
            color: var(--danger-color);
            border: 1px solid #fecaca;
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
            background-color: #fee2e2;
        }

        /* Collapsed Sidebar */
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .sidebar-header h2,
        .sidebar.collapsed .teacher-info-sidebar,
        .sidebar.collapsed .menu-group-title {
            opacity: 0;
            width: 0;
            overflow: hidden;
            display: none;
        }

        .sidebar.collapsed .teacher-profile-sidebar {
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

        /* ========== MAIN CONTENT FIXED STRUCTURE ========== */
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
            margin-left: var(--sidebar-collapsed-width);
            width: calc(100vw - var(--sidebar-collapsed-width));
        }

        /* ========== HEADER FIXED STRUCTURE ========== */
        .header {
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

        .teacher-profile-header {
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

        .teacher-profile-header:hover {
            background-color: #f1f5f9;
        }

        .teacher-avatar-small {
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

        .teacher-info-header h4 {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .teacher-info-header p {
            font-size: 0.8rem;
            color: var(--gray-color);
        }

        /* ========== CONTENT AREA FIXED STRUCTURE ========== */
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
        .dashboard-title {
            margin-bottom: 1.5rem;
        }

        .dashboard-title h1 {
            font-size: 2rem;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dashboard-title p {
            color: var(--gray-color);
            font-size: 1rem;
        }

        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            box-shadow: var(--box-shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            width: 100%;
        }

        .welcome-banner-content h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            white-space: nowrap;
        }

        .welcome-banner-content p {
            opacity: 0.9;
            max-width: 600px;
        }

        .quick-stats {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .quick-stat-item {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.15);
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            backdrop-filter: blur(10px);
            flex-shrink: 0;
        }

        .quick-stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.2rem;
        }

        .quick-stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
            width: 100%;
        }

        .stat-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            flex-shrink: 0;
        }

        .stat-info {
            flex: 1;
            min-width: 0;
        }

        .stat-info h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
            line-height: 1;
        }

        .stat-info p {
            color: var(--gray-color);
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
        }

        .stat-change {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .positive {
            color: var(--success-color);
        }

        .negative {
            color: var(--danger-color);
        }

        /* Feature Cards */
        .section-title {
            margin: 2.5rem 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            width: 100%;
        }

        .section-title h2 {
            font-weight: 700;
            color: var(--dark-color);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .view-all-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
            white-space: nowrap;
        }

        .view-all-link:hover {
            text-decoration: underline;
            gap: 8px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
            width: 100%;
        }

        .feature-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            border: 1px solid transparent;
            display: flex;
            flex-direction: column;
            min-height: 220px;
        }

        .feature-card:hover {
            border-color: var(--accent-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .feature-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background-color: #f5f3ff;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .feature-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .feature-description {
            color: var(--gray-color);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            flex: 1;
        }

        .feature-actions {
            display: flex;
            gap: 0.8rem;
            flex-wrap: wrap;
        }

        /* ========== BUTTONS ========== */
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139, 92, 246, 0.3);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .btn-outline:hover {
            background-color: #f5f3ff;
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background-color: #059669;
            transform: translateY(-2px);
        }

        .btn-warning {
            background-color: var(--warning-color);
            color: white;
        }

        .btn-warning:hover {
            background-color: #eab308;
            transform: translateY(-2px);
        }

        /* ========== CHART SECTION ========== */
        .chart-container {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            margin-top: 2rem;
            width: 100%;
        }

        .chart-container h3 {
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            font-weight: 600;
            font-size: 1.2rem;
        }

        .chart-wrapper {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* ========== MODAL STYLES ========== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition);
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }

        .modal {
            background-color: white;
            border-radius: var(--border-radius);
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: modalSlideIn 0.3s ease;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.3rem;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--gray-color);
            cursor: pointer;
            padding: 0.3rem;
            border-radius: 5px;
            transition: var(--transition);
        }

        .modal-close:hover {
            background-color: #f1f5f9;
            color: var(--danger-color);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-body ul {
            margin: 1rem 0;
            padding-left: 1.5rem;
        }

        .modal-body li {
            margin-bottom: 0.5rem;
            color: var(--gray-color);
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========== RESPONSIVE DESIGN ========== */
        @media (max-width: 1200px) {
            .features-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
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

            .welcome-banner {
                flex-direction: column;
                align-items: flex-start;
            }

            .quick-stats {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 0 1rem;
            }

            .content {
                padding: 1.5rem;
                height: calc(100vh - var(--header-height) - 10px);
            }

            .stats-grid,
            .features-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .header-right {
                gap: 1rem;
            }

            .section-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
                margin: 2rem 0 1rem;
            }

            .feature-actions {
                flex-direction: column;
            }

            .feature-actions .btn {
                width: 100%;
            }

            .chart-wrapper {
                height: 250px;
            }
        }

        @media (max-width: 576px) {
            .welcome-banner h2 {
                font-size: 1.3rem;
            }

            .quick-stats {
                flex-direction: column;
                gap: 1rem;
                width: 100%;
            }

            .quick-stat-item {
                width: 100%;
            }

            .teacher-info-header {
                display: none;
            }

            .content {
                padding: 1rem;
                height: calc(100vh - var(--header-height) - 20px);
            }

            .page-title h1 {
                font-size: 1.3rem;
            }

            .section-title h2 {
                font-size: 1.3rem;
            }

            .header-right {
                gap: 0.5rem;
            }
        }

        /* ========== UTILITY CLASSES ========== */
        .mb-1 {
            margin-bottom: 0.5rem;
        }

        .mb-2 {
            margin-bottom: 1rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .mt-1 {
            margin-top: 0.5rem;
        }

        .mt-2 {
            margin-top: 1rem;
        }

        .mt-3 {
            margin-top: 1.5rem;
        }

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

        .badge {
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-primary {
            background-color: #ede9fe;
            color: var(--primary-color);
        }

        .badge-success {
            background-color: #d1fae5;
            color: var(--success-color);
        }

        .badge-danger {
            background-color: #fee2e2;
            color: var(--danger-color);
        }

        .badge-warning {
            background-color: #fef3c7;
            color: var(--warning-color);
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
    </style>
</head>

<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="layout-container">
        <!-- Sidebar -->
        @include('layouts.teacher.sidebar')

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Header -->
            @include('layouts.teacher.header')
            <!-- Content -->
            <div class="content">


                @yield('content')
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal-overlay" id="classScheduleModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-calendar"></i> Today's Schedule</h3>
                <button class="modal-close" id="closeScheduleModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Class schedule interface would appear here.</p>
                <p>This would include:</p>
                <ul>
                    <li>Today's classes with timings</li>
                    <li>Classroom locations</li>
                    <li>Subject details</li>
                    <li>Attendance status</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="createAssignmentModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-plus"></i> Create New Assignment</h3>
                <button class="modal-close" id="closeAssignmentModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Assignment creation interface would appear here.</p>
                <p>This would include fields for:</p>
                <ul>
                    <li>Assignment Title & Description</li>
                    <li>Select Class & Subject</li>
                    <li>Due Date & Time</li>
                    <li>Maximum Marks</li>
                    <li>Attachment upload</li>
                </ul>
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

        // Modal Elements
        const classScheduleModal = document.getElementById('classScheduleModal');
        const createAssignmentModal = document.getElementById('createAssignmentModal');
        const closeScheduleModal = document.getElementById('closeScheduleModal');
        const closeAssignmentModal = document.getElementById('closeAssignmentModal');

        // Button Elements
        const viewScheduleBtn = document.getElementById('viewScheduleBtn');
        const createAssignmentBtn = document.getElementById('createAssignmentBtn');
        const studentReportsBtn = document.getElementById('studentReportsBtn');
        const attendanceReportBtn = document.getElementById('attendanceReportBtn');
        const resultsReportBtn = document.getElementById('resultsReportBtn');
        const uploadMaterialBtn = document.getElementById('uploadMaterialBtn');

        // Teacher Data
        const teacherData = {
            name: "Ms. Sarah Johnson",
            id: "TEA2023001",
            subject: "Mathematics",
            avatar: "SJ",
            classes: 4,
            students: 42,
            pendingGrading: 15,
            avgAttendance: 94
        };

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Teacher Dashboard loaded successfully");

            // Initialize chart
            initializeChart();

            // Set up event listeners
            setupEventListeners();

            // Set initial sidebar state based on screen size
            updateSidebarState();

            // Update teacher info
            updateTeacherInfo();
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

        // Update teacher information
        function updateTeacherInfo() {
            document.querySelector('.teacher-info-sidebar h3').textContent = teacherData.name;
            document.querySelector('.teacher-info-header h4').textContent = teacherData.name;
        }

        // Initialize chart
        function initializeChart() {
            const ctx = document.getElementById('performanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Class 10A', 'Class 10B', 'Class 9A', 'Class 9B'],
                    datasets: [{
                            label: 'Average Grade',
                            data: [85, 78, 82, 88],
                            backgroundColor: 'rgba(139, 92, 246, 0.7)',
                            borderColor: 'rgba(139, 92, 246, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Attendance %',
                            data: [92, 88, 94, 96],
                            backgroundColor: 'rgba(16, 185, 129, 0.7)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + (this.scale.id === 'y' ? '%' : '');
                                }
                            }
                        }
                    }
                }
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

            // Menu navigation - FIXED VERSION
            menuItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all menu items
                    menuItems.forEach(i => i.classList.remove('active'));

                    // Add active class to clicked item
                    this.classList.add('active');

                    // Get the page to show
                    const page = this.getAttribute('data-page');

                    // Update page title - FIXED
                    const pageTitle = document.getElementById('pageTitle');
                    const menuText = this.querySelector('.menu-text').textContent;

                    // Get the icon element
                    const iconElement = this.querySelector('.menu-icon i');
                    let iconHTML = '<i class="fas fa-tachometer-alt"></i>'; // Default icon

                    if (iconElement) {
                        // Clone the icon element to avoid reference issues
                        iconHTML = iconElement.outerHTML;
                    }

                    pageTitle.innerHTML = `${iconHTML} ${menuText}`;

                    // Show notification for demo
                    if (page !== 'dashboard') {
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

            // Dashboard card buttons navigation
            document.querySelectorAll('.feature-card .btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const page = this.getAttribute('data-page');
                    if (page) {
                        // Find and click the corresponding menu item
                        const menuItem = document.querySelector(`.menu-item[data-page="${page}"]`);
                        if (menuItem) {
                            menuItem.click();
                        }
                    }
                });
            });

            // Notification button
            notificationBtn.addEventListener('click', function() {
                showNotification(
                    'You have 5 notifications:\n- 3 assignments submitted\n- 1 parent meeting request\n- 1 school announcement',
                    'info');
                this.querySelector('.notification-badge').style.display = 'none';
            });

            // Feature button click handlers
            viewScheduleBtn.addEventListener('click', function() {
                classScheduleModal.classList.add('active');
            });

            createAssignmentBtn.addEventListener('click', function() {
                createAssignmentModal.classList.add('active');
            });

            studentReportsBtn.addEventListener('click', function() {
                showNotification('Student progress reports would open here.', 'info');
            });

            attendanceReportBtn.addEventListener('click', function() {
                showNotification('Attendance reports would open here.', 'info');
            });

            resultsReportBtn.addEventListener('click', function() {
                showNotification('Results export feature would open here.', 'info');
            });

            uploadMaterialBtn.addEventListener('click', function() {
                showNotification('Material upload interface would open here.', 'info');
            });

            // Close modals
            closeScheduleModal.addEventListener('click', function() {
                classScheduleModal.classList.remove('active');
            });

            closeAssignmentModal.addEventListener('click', function() {
                createAssignmentModal.classList.remove('active');
            });

            // Close modals when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === classScheduleModal) {
                    classScheduleModal.classList.remove('active');
                }
                if (e.target === createAssignmentModal) {
                    createAssignmentModal.classList.remove('active');
                }
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
        `;

            // Set background color based on type
            if (type === 'success') {
                notification.style.backgroundColor = '#10b981';
            } else if (type === 'error') {
                notification.style.backgroundColor = '#ef4444';
            } else if (type === 'info') {
                notification.style.backgroundColor = '#3b82f6';
            } else {
                notification.style.backgroundColor = '#6b7280';
            }

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
