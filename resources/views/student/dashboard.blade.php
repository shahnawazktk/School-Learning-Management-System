<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel | School Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #1d4ed8;
            --accent-color: #60a5fa;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
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

        /* ========== LOGIN PAGE ========== */
        .login-container {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 1rem;
        }

        .login-box {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .login-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
            background-color: #f9fafb;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            background-color: white;
        }

        .login-btn {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .login-footer {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
            color: var(--gray-color);
            font-size: 0.9rem;
        }

        /* ========== LAYOUT CONTAINER ========== */
        .layout-container {
            display: flex;
            min-height: 100vh;
            width: 100vw;
            position: relative;
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

        .sidebar-header h2 {
            color: var(--primary-color);
            font-weight: 700;
            white-space: nowrap;
            font-size: 1.4rem;
            transition: var(--transition);
        }

        .student-profile-sidebar {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
        }

        .student-avatar {
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

        .student-info-sidebar h3 {
            font-size: 1.1rem;
            margin-bottom: 0.2rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .student-info-sidebar p {
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
            background-color: #eff6ff;
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
        .sidebar.collapsed .student-info-sidebar {
            opacity: 0;
            width: 0;
            overflow: hidden;
            display: none;
        }

        .sidebar.collapsed .student-profile-sidebar {
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

        .student-profile-header {
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

        .student-profile-header:hover {
            background-color: #f1f5f9;
        }

        .student-avatar-small {
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

        .student-info-header h4 {
            font-size: 0.95rem;
            font-weight: 600;
        }

        .student-info-header p {
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
            max-height: calc(100vh - var(--header-height));
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
        .student-dashboard {
            display: none;
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

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
            width: 100%;
        }

        .dashboard-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-color);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background-color: #eff6ff;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .card-content {
            margin-bottom: 1.5rem;
        }

        .card-content p {
            color: var(--gray-color);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .card-actions {
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
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background-color: #059669;
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .btn-outline:hover {
            background-color: #eff6ff;
            transform: translateY(-2px);
        }

        /* ========== SUBJECTS PAGE ========== */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
            width: 100%;
        }

        .page-header h1 {
            font-size: 1.8rem;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .filter-options {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-select {
            padding: 0.6rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background-color: white;
            color: var(--dark-color);
            font-size: 0.9rem;
            min-width: 150px;
        }

        .subjects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
            width: 100%;
        }

        .subject-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            border: 1px solid transparent;
            display: flex;
            flex-direction: column;
            min-height: 280px;
        }

        .subject-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
        }

        .subject-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .subject-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            background-color: #eff6ff;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .subject-title {
            flex: 1;
            min-width: 0;
        }

        .subject-title h3 {
            font-size: 1.2rem;
            margin-bottom: 0.3rem;
            color: var(--dark-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .subject-title p {
            color: var(--gray-color);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .subject-teacher {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1rem;
            padding: 0.5rem;
            background-color: #f8fafc;
            border-radius: 6px;
        }

        .teacher-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--info-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
            flex-shrink: 0;
        }

        .subject-resources {
            margin-top: auto;
        }

        .resource-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .resource-item:last-child {
            border-bottom: none;
        }

        .resource-info {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .resource-icon {
            color: var(--primary-color);
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .resource-actions {
            display: flex;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        /* ========== ASSIGNMENTS PAGE ========== */
        .assignments-list {
            display: grid;
            gap: 1rem;
            margin-bottom: 2rem;
            width: 100%;
        }

        .assignment-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            border-left: 4px solid transparent;
            width: 100%;
        }

        .assignment-card:hover {
            transform: translateY(-3px);
        }

        .assignment-card.pending {
            border-left-color: var(--warning-color);
        }

        .assignment-card.submitted {
            border-left-color: var(--success-color);
        }

        .assignment-card.overdue {
            border-left-color: var(--danger-color);
        }

        .assignment-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .assignment-title h3 {
            font-size: 1.2rem;
            margin-bottom: 0.3rem;
        }

        .assignment-subject {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .assignment-status {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-submitted {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-overdue {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .assignment-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background-color: #f8fafc;
            border-radius: 8px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.85rem;
            color: var(--gray-color);
            margin-bottom: 0.3rem;
        }

        .detail-value {
            font-weight: 600;
            color: var(--dark-color);
            word-break: break-word;
        }

        .assignment-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        /* ========== ATTENDANCE & RESULTS PAGE ========== */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            flex-shrink: 0;
        }

        .attendance-stat .stat-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .result-stat .stat-icon {
            background: linear-gradient(135deg, var(--success-color), #059669);
        }

        .stat-info h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .stat-info p {
            color: var(--gray-color);
            font-size: 0.9rem;
        }

        .chart-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--box-shadow);
            margin-bottom: 2rem;
            width: 100%;
        }

        .chart-card h3 {
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            font-size: 1.2rem;
            font-weight: 600;
        }

        .chart-wrapper {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .table-container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            margin-bottom: 2rem;
            width: 100%;
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-header h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
        }

        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        thead {
            background-color: #f8fafc;
        }

        th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: var(--dark-color);
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            color: var(--dark-color);
        }

        tbody tr:hover {
            background-color: #f8fafc;
        }

        .grade-a {
            color: var(--success-color);
            font-weight: 700;
        }

        .grade-b {
            color: #3b82f6;
            font-weight: 700;
        }

        .grade-c {
            color: var(--warning-color);
            font-weight: 700;
        }

        .grade-d {
            color: var(--danger-color);
            font-weight: 700;
        }

        /* ========== MODAL STYLES ========== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            padding: 1rem;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(20px);
            transition: var(--transition);
        }

        .modal-overlay.active .modal {
            transform: translateY(0);
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3 {
            font-size: 1.3rem;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--gray-color);
            cursor: pointer;
            padding: 0.2rem;
            border-radius: 4px;
            transition: var(--transition);
        }

        .modal-close:hover {
            background-color: #f1f5f9;
            color: var(--danger-color);
        }

        .modal-body {
            padding: 1.5rem;
        }

        /* File Upload Styles */
        .file-upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 10px;
            padding: 3rem 2rem;
            text-align: center;
            background-color: #f9fafb;
            margin-bottom: 1.5rem;
            transition: var(--transition);
            cursor: pointer;
            width: 100%;
        }

        .file-upload-area:hover {
            border-color: var(--primary-color);
            background-color: #f0f9ff;
        }

        .file-upload-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .file-upload-text h4 {
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .file-upload-text p {
            color: var(--gray-color);
            margin-bottom: 1rem;
        }

        .file-input {
            display: none;
        }

        .selected-file {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background-color: #f0f9ff;
            border-radius: 8px;
            margin-top: 1rem;
            border: 1px solid var(--accent-color);
            width: 100%;
        }

        .file-info {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .file-icon {
            color: var(--primary-color);
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .remove-file {
            background: none;
            border: none;
            color: var(--danger-color);
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0.2rem;
            flex-shrink: 0;
        }

        /* ========== RESPONSIVE DESIGN ========== */
        @media (max-width: 1200px) {

            .subjects-grid,
            .dashboard-cards,
            .stats-container {
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
                max-height: calc(100vh - var(--header-height) - 20px);
            }

            .dashboard-cards,
            .subjects-grid,
            .stats-container {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .header-right {
                gap: 1rem;
            }

            .assignment-header,
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-options {
                width: 100%;
                flex-wrap: wrap;
            }

            .assignment-details {
                grid-template-columns: 1fr;
            }

            .modal {
                max-height: 95vh;
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

            .assignment-actions {
                flex-direction: column;
            }

            .assignment-actions .btn {
                width: 100%;
            }

            .card-actions {
                flex-direction: column;
            }

            .student-info-header {
                display: none;
            }

            .login-box {
                max-width: 100%;
            }

            .content {
                padding: 1rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
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
            background-color: #dbeafe;
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
    <!-- Login Page -->
    <div class="login-container" id="loginPage">
        <div class="login-box">
            <div class="login-header">
                <h1><i class="fas fa-graduation-cap"></i> Student Portal</h1>
                <p>Login to access your dashboard and learning resources</p>
            </div>
            <div class="login-body">
                <div class="form-group">
                    <label for="studentId">Student ID</label>
                    <input type="text" id="studentId" class="form-control" placeholder="Enter your student ID"
                        value="STU2023001">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Enter your password"
                        value="password123">
                </div>
                <button class="login-btn" id="loginBtn">
                    <i class="fas fa-sign-in-alt"></i> Login to Dashboard
                </button>
                <div class="login-footer">
                    <p>Need help? Contact your school administrator</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Dashboard (Initially Hidden) -->
    <div class="student-dashboard" id="studentDashboard">
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <div class="layout-container">
            <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <i class="fas fa-graduation-cap" style="color: var(--primary-color); font-size: 1.8rem;"></i>
                    <h2>Student Portal</h2>
                </div>

                <div class="student-profile-sidebar">
                    <div class="student-avatar">JS</div>
                    <div class="student-info-sidebar">
                        <h3>John Smith</h3>
                        <p><i class="fas fa-user-graduate"></i> Class 10 - Section A</p>
                        <p><i class="fas fa-id-card"></i> STU2023001</p>
                    </div>
                </div>

                <div class="sidebar-menu">
                    <a href="#" class="menu-item active" data-page="dashboard">
                        <i class="fas fa-tachometer-alt menu-icon"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <a href="#" class="menu-item" data-page="subjects">
                        <i class="fas fa-book-open menu-icon"></i>
                        <span class="menu-text">My Subjects</span>
                    </a>
                    <a href="#" class="menu-item" data-page="studyMaterials">
                        <i class="fas fa-video menu-icon"></i>
                        <span class="menu-text">Study Materials</span>
                    </a>
                    <a href="#" class="menu-item" data-page="assignments">
                        <i class="fas fa-tasks menu-icon"></i>
                        <span class="menu-text">Assignments</span>
                    </a>
                    <a href="#" class="menu-item" data-page="attendance">
                        <i class="fas fa-calendar-check menu-icon"></i>
                        <span class="menu-text">Attendance</span>
                    </a>
                    <a href="#" class="menu-item" data-page="results">
                        <i class="fas fa-chart-line menu-icon"></i>
                        <span class="menu-text">Results</span>
                    </a>
                    <a href="#" class="menu-item" data-page="profile">
                        <i class="fas fa-user menu-icon"></i>
                        <span class="menu-text">My Profile</span>
                    </a>
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
                <div class="header">
                    <div class="header-left">
                        <button class="toggle-sidebar" id="toggleSidebar">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="page-title">
                            <h1 id="pageTitle"><i class="fas fa-tachometer-alt"></i> Student Dashboard</h1>
                        </div>
                    </div>

                    <div class="header-right">
                        <div class="notification-wrapper">
                            <button class="notification-btn" id="notificationBtn">
                                <i class="fas fa-bell"></i>
                                <span class="notification-badge">5</span>
                            </button>
                        </div>

                        <div class="student-profile-header">
                            <div class="student-avatar-small">JS</div>
                            <div class="student-info-header">
                                <h4>John Smith</h4>
                                <p>Class 10 - A</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Area (Dynamic based on page) -->
                <div class="content" id="contentArea">
                    <!-- Dashboard Content (Default) -->
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
                </div>
            </div>
        </div>
    </div>

    <!-- Assignment Submission Modal -->
    <div class="modal-overlay" id="assignmentModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-upload"></i> Submit Assignment</h3>
                <button class="modal-close" id="closeAssignmentModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="assignment-details mb-3">
                    <h4 id="modalAssignmentTitle">Mathematics Assignment - Algebra Basics</h4>
                    <p id="modalAssignmentSubject" class="text-success">Subject: Mathematics</p>
                    <p id="modalAssignmentDeadline">Deadline: April 30, 2024</p>
                </div>

                <div class="file-upload-area" id="fileUploadArea">
                    <div class="file-upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="file-upload-text">
                        <h4>Upload Your Assignment</h4>
                        <p>Drag & drop files here or click to browse</p>
                        <p class="text-warning">Accepted formats: PDF, DOC, DOCX, PPT, JPEG, PNG (Max: 10MB)</p>
                    </div>
                    <input type="file" class="file-input" id="assignmentFileInput"
                        accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png">
                </div>

                <div id="selectedFileContainer" style="display: none;">
                    <div class="selected-file">
                        <div class="file-info">
                            <i class="fas fa-file-alt file-icon"></i>
                            <div>
                                <div id="selectedFileName">assignment.pdf</div>
                                <div id="selectedFileSize" class="text-muted">2.4 MB</div>
                            </div>
                        </div>
                        <button class="remove-file" id="removeFileBtn">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="assignmentComments">Additional Comments (Optional)</label>
                    <textarea id="assignmentComments" class="form-control" rows="3"
                        placeholder="Add any comments for your teacher..."></textarea>
                </div>

                <div class="modal-actions mt-3">
                    <button class="btn btn-primary" id="submitAssignmentBtn" style="width: 100%;">
                        <i class="fas fa-paper-plane"></i> Submit Assignment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Study Material Modal -->
    <div class="modal-overlay" id="materialModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-play-circle"></i> Study Material</h3>
                <button class="modal-close" id="closeMaterialModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="material-details mb-3">
                    <h4 id="modalMaterialTitle">Introduction to Algebra</h4>
                    <p id="modalMaterialSubject" class="text-success">Subject: Mathematics</p>
                    <p id="modalMaterialType">Type: Video Lesson</p>
                    <p id="modalMaterialDuration">Duration: 15 minutes</p>
                </div>

                <div class="video-player mb-3" id="videoPlayer" style="display: none;">
                    <div
                        style="background-color: #000; border-radius: 8px; padding: 56.25% 0 0 0; position: relative;">
                        <div
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; background-color: #1e293b;">
                            <i class="fas fa-play-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="document-viewer mb-3" id="documentViewer" style="display: none;">
                    <div style="background-color: #f8fafc; border-radius: 8px; padding: 2rem; text-align: center;">
                        <i class="fas fa-file-pdf" style="font-size: 4rem; color: #ef4444;"></i>
                        <h4 class="mt-2">PDF Document</h4>
                        <p>Click download to view this document</p>
                    </div>
                </div>

                <div class="material-actions mt-3">
                    <button class="btn btn-primary" id="playMaterialBtn" style="display: none;">
                        <i class="fas fa-play"></i> Play Video
                    </button>
                    <button class="btn btn-success" id="downloadMaterialBtn">
                        <i class="fas fa-download"></i> Download Material
                    </button>
                    <button class="btn btn-outline" id="closeMaterialBtn">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const loginPage = document.getElementById('loginPage');
        const studentDashboard = document.getElementById('studentDashboard');
        const loginBtn = document.getElementById('loginBtn');
        const toggleSidebarBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');
        const notificationBtn = document.getElementById('notificationBtn');

        // Page navigation elements
        const menuItems = document.querySelectorAll('.menu-item');
        const pageTitle = document.getElementById('pageTitle');
        const contentArea = document.getElementById('contentArea');
        const pageContents = document.querySelectorAll('.page-content');

        // Modal elements
        const assignmentModal = document.getElementById('assignmentModal');
        const materialModal = document.getElementById('materialModal');
        const closeAssignmentModal = document.getElementById('closeAssignmentModal');
        const closeMaterialModal = document.getElementById('closeMaterialModal');
        const fileUploadArea = document.getElementById('fileUploadArea');
        const assignmentFileInput = document.getElementById('assignmentFileInput');
        const selectedFileContainer = document.getElementById('selectedFileContainer');
        const submitAssignmentBtn = document.getElementById('submitAssignmentBtn');
        const playMaterialBtn = document.getElementById('playMaterialBtn');
        const downloadMaterialBtn = document.getElementById('downloadMaterialBtn');

        // Sample data
        const studentData = {
            name: "John Smith",
            id: "STU2023001",
            class: "Class 10 - Section A",
            avatar: "JS",
            attendance: 94,
            averageGrade: "A-",
            subjectsCount: 6
        };

        const subjectsData = [{
                id: 1,
                name: "Mathematics",
                code: "MATH101",
                teacher: "Mr. David Wilson",
                teacherAvatar: "DW",
                description: "Algebra, Geometry, Calculus",
                color: "#3b82f6",
                resources: [{
                        type: "video",
                        name: "Introduction to Algebra",
                        duration: "15 min"
                    },
                    {
                        type: "notes",
                        name: "Geometry Formulas",
                        pages: 12
                    },
                    {
                        type: "presentation",
                        name: "Calculus Basics",
                        slides: 25
                    }
                ]
            },
            {
                id: 2,
                name: "Science",
                code: "SCI201",
                teacher: "Ms. Sarah Johnson",
                teacherAvatar: "SJ",
                description: "Physics, Chemistry, Biology",
                color: "#10b981",
                resources: [{
                        type: "video",
                        name: "Chemical Reactions",
                        duration: "18 min"
                    },
                    {
                        type: "notes",
                        name: "Physics Laws",
                        pages: 15
                    },
                    {
                        type: "presentation",
                        name: "Human Anatomy",
                        slides: 30
                    }
                ]
            },
            {
                id: 3,
                name: "English Literature",
                code: "ENG301",
                teacher: "Mrs. Emily Brown",
                teacherAvatar: "EB",
                description: "Grammar, Composition, Literature",
                color: "#8b5cf6",
                resources: [{
                        type: "video",
                        name: "Shakespeare Analysis",
                        duration: "22 min"
                    },
                    {
                        type: "notes",
                        name: "Grammar Rules",
                        pages: 20
                    },
                    {
                        type: "presentation",
                        name: "Essay Writing",
                        slides: 18
                    }
                ]
            },
            {
                id: 4,
                name: "History",
                code: "HIS401",
                teacher: "Mr. Robert Miller",
                teacherAvatar: "RM",
                description: "World History, Civics",
                color: "#f59e0b",
                resources: [{
                        type: "video",
                        name: "World War II",
                        duration: "25 min"
                    },
                    {
                        type: "notes",
                        name: "Ancient Civilizations",
                        pages: 22
                    },
                    {
                        type: "presentation",
                        name: "Government Systems",
                        slides: 28
                    }
                ]
            },
            {
                id: 5,
                name: "Computer Science",
                code: "CS501",
                teacher: "Mr. Alex Chen",
                teacherAvatar: "AC",
                description: "Programming, Algorithms",
                color: "#ef4444",
                resources: [{
                        type: "video",
                        name: "Python Basics",
                        duration: "20 min"
                    },
                    {
                        type: "notes",
                        name: "Data Structures",
                        pages: 18
                    },
                    {
                        type: "presentation",
                        name: "Web Development",
                        slides: 35
                    }
                ]
            },
            {
                id: 6,
                name: "Physical Education",
                code: "PE601",
                teacher: "Coach Michael Davis",
                teacherAvatar: "MD",
                description: "Sports, Health, Fitness",
                color: "#06b6d4",
                resources: [{
                        type: "video",
                        name: "Basketball Techniques",
                        duration: "12 min"
                    },
                    {
                        type: "notes",
                        name: "Nutrition Guide",
                        pages: 10
                    },
                    {
                        type: "presentation",
                        name: "Exercise Routines",
                        slides: 22
                    }
                ]
            }
        ];

        const assignmentsData = [{
                id: 1,
                title: "Algebra Problem Set",
                subject: "Mathematics",
                subjectColor: "#3b82f6",
                description: "Solve the algebra problems from chapters 1-3",
                dueDate: "2024-04-30",
                status: "pending",
                submittedDate: null,
                marks: null,
                maxMarks: 20
            },
            {
                id: 2,
                title: "Science Project Report",
                subject: "Science",
                subjectColor: "#10b981",
                description: "Write a report on your science project experiment",
                dueDate: "2024-04-25",
                status: "overdue",
                submittedDate: null,
                marks: null,
                maxMarks: 25
            },
            {
                id: 3,
                title: "English Essay",
                subject: "English Literature",
                subjectColor: "#8b5cf6",
                description: "Write a 500-word essay on 'The Importance of Reading'",
                dueDate: "2024-05-05",
                status: "pending",
                submittedDate: null,
                marks: null,
                maxMarks: 15
            },
            {
                id: 4,
                title: "History Presentation",
                subject: "History",
                subjectColor: "#f59e0b",
                description: "Create a presentation on Ancient Egypt",
                dueDate: "2024-04-20",
                status: "submitted",
                submittedDate: "2024-04-19",
                marks: 18,
                maxMarks: 20
            },
            {
                id: 5,
                title: "Programming Assignment",
                subject: "Computer Science",
                subjectColor: "#ef4444",
                description: "Write a Python program to calculate Fibonacci series",
                dueDate: "2024-04-28",
                status: "submitted",
                submittedDate: "2024-04-27",
                marks: 22,
                maxMarks: 25
            }
        ];

        const attendanceData = [{
                date: "2024-04-01",
                day: "Monday",
                status: "present",
                subject1: "present",
                subject2: "present",
                subject3: "present",
                remarks: ""
            },
            {
                date: "2024-04-02",
                day: "Tuesday",
                status: "present",
                subject1: "present",
                subject2: "present",
                subject3: "present",
                remarks: ""
            },
            {
                date: "2024-04-03",
                day: "Wednesday",
                status: "present",
                subject1: "present",
                subject2: "present",
                subject3: "present",
                remarks: ""
            },
            {
                date: "2024-04-04",
                day: "Thursday",
                status: "present",
                subject1: "present",
                subject2: "present",
                subject3: "present",
                remarks: ""
            }
        ];

        const resultsData = [{
                subject: "Mathematics",
                teacher: "Mr. David Wilson",
                marks: 85,
                totalMarks: 100,
                percentage: 85,
                grade: "A",
                remarks: "Excellent work"
            },
            {
                subject: "Science",
                teacher: "Ms. Sarah Johnson",
                marks: 88,
                totalMarks: 100,
                percentage: 88,
                grade: "A",
                remarks: "Very good understanding"
            },
            {
                subject: "English Literature",
                teacher: "Mrs. Emily Brown",
                marks: 82,
                totalMarks: 100,
                percentage: 82,
                grade: "B+",
                remarks: "Good effort"
            },
            {
                subject: "History",
                teacher: "Mr. Robert Miller",
                marks: 78,
                totalMarks: 100,
                percentage: 78,
                grade: "B",
                remarks: "Satisfactory"
            },
            {
                subject: "Computer Science",
                teacher: "Mr. Alex Chen",
                marks: 92,
                totalMarks: 100,
                percentage: 92,
                grade: "A",
                remarks: "Outstanding"
            },
            {
                subject: "Physical Education",
                teacher: "Coach Michael Davis",
                marks: 95,
                totalMarks: 100,
                percentage: 95,
                grade: "A+",
                remarks: "Excellent performance"
            }
        ];

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Student Panel initialized with fixed layout");

            // Load sample data
            loadSubjects();
            loadAssignments();
            loadAttendanceTable();
            loadResultsTable();
            initializeCharts();

            // Set up event listeners
            setupEventListeners();

            // Set initial sidebar state based on screen size
            updateSidebarState();
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

        // Set up all event listeners
        function setupEventListeners() {
            // Login button
            loginBtn.addEventListener('click', function() {
                const studentId = document.getElementById('studentId').value;
                const password = document.getElementById('password').value;

                if (studentId && password) {
                    loginPage.style.display = 'none';
                    studentDashboard.style.display = 'block';

                    // Update student name in header
                    document.querySelector('.student-info-header h4').textContent = studentData.name;
                    document.querySelector('.student-info-sidebar h3').textContent = studentData.name;

                    showNotification('Login successful! Welcome to your student dashboard.', 'success');
                } else {
                    alert('Please enter both Student ID and Password');
                }
            });

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

            // Toggle sidebar buttons
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
                    'You have 5 notifications:\n- 2 new study materials\n- 1 assignment graded\n- 1 attendance update\n- 1 message from teacher',
                    'info');
                this.querySelector('.notification-badge').style.display = 'none';
            });

            // Menu navigation
            menuItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all menu items
                    menuItems.forEach(i => i.classList.remove('active'));

                    // Add active class to clicked item
                    this.classList.add('active');

                    // Get the page to show
                    const page = this.getAttribute('data-page');

                    // Show the corresponding page
                    showPage(page);

                    // Close sidebar on mobile after clicking
                    if (window.innerWidth <= 1024) {
                        sidebar.classList.remove('active');
                        sidebarOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            });

            // Dashboard card buttons navigation
            document.querySelectorAll('.dashboard-card .btn').forEach(btn => {
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

            // Close modals
            closeAssignmentModal.addEventListener('click', function() {
                assignmentModal.classList.remove('active');
            });

            closeMaterialModal.addEventListener('click', function() {
                materialModal.classList.remove('active');
            });

            // File upload handling
            fileUploadArea.addEventListener('click', function() {
                assignmentFileInput.click();
            });

            assignmentFileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    const fileName = file.name;
                    const fileSize = (file.size / (1024 * 1024)).toFixed(2); // Convert to MB

                    document.getElementById('selectedFileName').textContent = fileName;
                    document.getElementById('selectedFileSize').textContent = `${fileSize} MB`;
                    selectedFileContainer.style.display = 'block';

                    // Validate file size
                    if (file.size > 10 * 1024 * 1024) { // 10MB limit
                        showNotification('File size exceeds 10MB limit. Please choose a smaller file.', 'error');
                        this.value = '';
                        selectedFileContainer.style.display = 'none';
                    }
                }
            });

            // Remove selected file
            document.getElementById('removeFileBtn').addEventListener('click', function() {
                assignmentFileInput.value = '';
                selectedFileContainer.style.display = 'none';
            });

            // Submit assignment
            submitAssignmentBtn.addEventListener('click', function() {
                if (!assignmentFileInput.files.length) {
                    showNotification('Please select a file to upload.', 'error');
                    return;
                }

                // Simulate submission
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
                this.disabled = true;

                setTimeout(() => {
                    showNotification('Assignment submitted successfully!', 'success');
                    assignmentModal.classList.remove('active');
                    assignmentFileInput.value = '';
                    selectedFileContainer.style.display = 'none';
                    document.getElementById('assignmentComments').value = '';

                    this.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Assignment';
                    this.disabled = false;

                    // Update assignments list
                    loadAssignments();
                }, 1500);
            });

            // Play material button
            playMaterialBtn.addEventListener('click', function() {
                showNotification('Video playback started in fullscreen mode.', 'info');
            });

            // Download material button
            downloadMaterialBtn.addEventListener('click', function() {
                showNotification('Download started. The file will be saved to your device.', 'success');
            });

            // Close modals when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === assignmentModal) {
                    assignmentModal.classList.remove('active');
                }
                if (e.target === materialModal) {
                    materialModal.classList.remove('active');
                }
            });

            // Filter change listeners
            document.getElementById('subjectFilter').addEventListener('change', loadSubjects);
            document.getElementById('assignmentFilter').addEventListener('change', loadAssignments);
            document.getElementById('attendancePeriod').addEventListener('change', loadAttendanceTable);
            document.getElementById('resultsTerm').addEventListener('change', loadResultsTable);

            // Edit profile button
            document.getElementById('editProfileBtn').addEventListener('click', function() {
                showNotification('Profile editing feature would open here.', 'info');
            });

            // View assignment calendar button
            document.getElementById('viewAssignmentCalendarBtn').addEventListener('click', function() {
                showNotification('Calendar view would open here showing all assignment deadlines.', 'info');
            });

            // Close material button
            document.getElementById('closeMaterialBtn').addEventListener('click', function() {
                materialModal.classList.remove('active');
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

        // Show a specific page
        function showPage(page) {
            // Hide all page contents
            pageContents.forEach(content => {
                content.style.display = 'none';
            });

            // Show the selected page
            document.getElementById(`${page}Page`).style.display = 'block';

            // Update page title
            const pageTitles = {
                dashboard: '<i class="fas fa-tachometer-alt"></i> Student Dashboard',
                subjects: '<i class="fas fa-book-open"></i> My Subjects',
                studyMaterials: '<i class="fas fa-video"></i> Study Materials',
                assignments: '<i class="fas fa-tasks"></i> My Assignments',
                attendance: '<i class="fas fa-calendar-check"></i> Attendance',
                results: '<i class="fas fa-chart-line"></i> Results & Grades',
                profile: '<i class="fas fa-user"></i> My Profile'
            };

            pageTitle.innerHTML = pageTitles[page] || '<i class="fas fa-tachometer-alt"></i> Student Dashboard';

            // Update page title in document
            document.title = `${pageTitle.textContent} | School Management System`;
        }

        // Load subjects into the subjects page
        function loadSubjects() {
            const subjectsContainer = document.getElementById('subjectsContainer');
            const filter = document.getElementById('subjectFilter').value;

            // Clear container
            subjectsContainer.innerHTML = '';

            // Filter subjects if needed
            let filteredSubjects = subjectsData;

            // Add subjects to container
            filteredSubjects.forEach(subject => {
                const subjectCard = document.createElement('div');
                subjectCard.className = 'subject-card';
                subjectCard.innerHTML = `
                    <div class="subject-header">
                        <div class="subject-icon" style="background-color: ${subject.color}">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="subject-title">
                            <h3>${subject.name}</h3>
                            <p><i class="fas fa-code"></i> ${subject.code}</p>
                            <p><i class="fas fa-user-tie"></i> ${subject.teacher}</p>
                        </div>
                    </div>
                    <div class="subject-teacher">
                        <div class="teacher-avatar">${subject.teacherAvatar}</div>
                        <div>
                            <div><strong>${subject.teacher}</strong></div>
                            <div class="text-muted">Teacher</div>
                        </div>
                    </div>
                    <p class="mb-2">${subject.description}</p>
                    <div class="subject-resources">
                        <div class="resource-item">
                            <div class="resource-info">
                                <i class="fas fa-video resource-icon"></i>
                                <div>
                                    <div>${subject.resources[0].name}</div>
                                    <div class="text-muted">${subject.resources[0].duration}</div>
                                </div>
                            </div>
                            <div class="resource-actions">
                                <button class="btn btn-outline btn-sm view-material-btn" data-subject="${subject.name}" data-type="video" data-title="${subject.resources[0].name}">
                                    <i class="fas fa-play"></i> Watch
                                </button>
                            </div>
                        </div>
                        <div class="resource-item">
                            <div class="resource-info">
                                <i class="fas fa-file-alt resource-icon"></i>
                                <div>
                                    <div>${subject.resources[1].name}</div>
                                    <div class="text-muted">${subject.resources[1].pages} pages</div>
                                </div>
                            </div>
                            <div class="resource-actions">
                                <button class="btn btn-outline btn-sm view-material-btn" data-subject="${subject.name}" data-type="notes" data-title="${subject.resources[1].name}">
                                    <i class="fas fa-download"></i> Download
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                subjectsContainer.appendChild(subjectCard);
            });

            // Add event listeners to material buttons
            document.querySelectorAll('.view-material-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const subject = this.getAttribute('data-subject');
                    const type = this.getAttribute('data-type');
                    const title = this.getAttribute('data-title');

                    openMaterialModal(subject, type, title);
                });
            });
        }

        // Load assignments into the assignments page
        function loadAssignments() {
            const assignmentsContainer = document.getElementById('assignmentsContainer');
            const filter = document.getElementById('assignmentFilter').value;

            // Clear container
            assignmentsContainer.innerHTML = '';

            // Filter assignments
            let filteredAssignments = assignmentsData;
            if (filter !== 'all') {
                filteredAssignments = assignmentsData.filter(assignment => assignment.status === filter);
            }

            // Add assignments to container
            filteredAssignments.forEach(assignment => {
                // Format due date
                const dueDate = new Date(assignment.dueDate);
                const formattedDueDate = dueDate.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                // Calculate days remaining
                const today = new Date();
                const timeDiff = dueDate.getTime() - today.getTime();
                const daysRemaining = Math.ceil(timeDiff / (1000 * 3600 * 24));

                // Status badge
                let statusBadge = '';
                if (assignment.status === 'pending') {
                    statusBadge =
                        `<span class="assignment-status status-pending">Pending (${daysRemaining} days left)</span>`;
                } else if (assignment.status === 'submitted') {
                    statusBadge =
                        `<span class="assignment-status status-submitted">Submitted (${assignment.marks}/${assignment.maxMarks})</span>`;
                } else if (assignment.status === 'overdue') {
                    statusBadge =
                        `<span class="assignment-status status-overdue">Overdue (${Math.abs(daysRemaining)} days late)</span>`;
                }

                const assignmentCard = document.createElement('div');
                assignmentCard.className = `assignment-card ${assignment.status}`;
                assignmentCard.innerHTML = `
                    <div class="assignment-header">
                        <div class="assignment-title">
                            <h3>${assignment.title}</h3>
                            <div class="assignment-subject" style="color: ${assignment.subjectColor}">
                                <i class="fas fa-book"></i> ${assignment.subject}
                            </div>
                        </div>
                        ${statusBadge}
                    </div>
                    <p class="mb-2">${assignment.description}</p>
                    <div class="assignment-details">
                        <div class="detail-item">
                            <div class="detail-label">Due Date</div>
                            <div class="detail-value">${formattedDueDate}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Marks</div>
                            <div class="detail-value">${assignment.maxMarks}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" style="text-transform: capitalize;">${assignment.status}</div>
                        </div>
                        ${assignment.submittedDate ? `
                            <div class="detail-item">
                                <div class="detail-label">Submitted On</div>
                                <div class="detail-value">${new Date(assignment.submittedDate).toLocaleDateString()}</div>
                            </div>
                            ` : ''}
                    </div>
                    <div class="assignment-actions">
                        ${assignment.status === 'pending' || assignment.status === 'overdue' ? `
                            <button class="btn btn-primary submit-assignment-btn" data-id="${assignment.id}" data-title="${assignment.title}" data-subject="${assignment.subject}" data-duedate="${formattedDueDate}">
                                <i class="fas fa-upload"></i> Submit Assignment
                            </button>
                            ` : ''}
                        ${assignment.status === 'submitted' ? `
                            <button class="btn btn-outline">
                                <i class="fas fa-eye"></i> View Submission
                            </button>
                            ` : ''}
                        <button class="btn btn-outline">
                            <i class="fas fa-question-circle"></i> Ask for Help
                        </button>
                    </div>
                `;

                assignmentsContainer.appendChild(assignmentCard);
            });

            // Add event listeners to submit buttons
            document.querySelectorAll('.submit-assignment-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const title = this.getAttribute('data-title');
                    const subject = this.getAttribute('data-subject');
                    const dueDate = this.getAttribute('data-duedate');

                    openAssignmentModal(id, title, subject, dueDate);
                });
            });
        }

        // Load attendance table
        function loadAttendanceTable() {
            const tableBody = document.getElementById('attendanceTableBody');
            tableBody.innerHTML = '';

            attendanceData.forEach(record => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${new Date(record.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</td>
                    <td>${record.day}</td>
                    <td><span class="badge ${record.status === 'present' ? 'badge-success' : 'badge-danger'}">${record.status}</span></td>
                    <td><span class="badge ${record.subject1 === 'present' ? 'badge-success' : 'badge-danger'}">${record.subject1}</span></td>
                    <td><span class="badge ${record.subject2 === 'present' ? 'badge-success' : 'badge-danger'}">${record.subject2}</span></td>
                    <td><span class="badge ${record.subject3 === 'present' ? 'badge-success' : 'badge-danger'}">${record.subject3}</span></td>
                    <td>${record.remarks || '-'}</td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Load results table
        function loadResultsTable() {
            const tableBody = document.getElementById('resultsTableBody');
            tableBody.innerHTML = '';

            resultsData.forEach(result => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><strong>${result.subject}</strong></td>
                    <td>${result.teacher}</td>
                    <td>${result.marks}</td>
                    <td>${result.totalMarks}</td>
                    <td><strong>${result.percentage}%</strong></td>
                    <td><span class="grade-${result.grade.toLowerCase().charAt(0)}">${result.grade}</span></td>
                    <td>${result.remarks}</td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Initialize charts
        function initializeCharts() {
            // Dashboard attendance chart
            const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
            new Chart(attendanceCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Attendance %',
                        data: [92, 90, 91, 94, 93, 95, 92, 90, 94, 93, 95, 96],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 85,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    }
                }
            });

            // Attendance by subject chart
            const attendanceBySubjectCtx = document.getElementById('attendanceBySubjectChart').getContext('2d');
            new Chart(attendanceBySubjectCtx, {
                type: 'bar',
                data: {
                    labels: ['Mathematics', 'Science', 'English', 'History', 'Computer', 'PE'],
                    datasets: [{
                        label: 'Attendance %',
                        data: [96, 94, 92, 90, 98, 95],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(139, 92, 246, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(6, 182, 212, 0.8)'
                        ],
                        borderColor: [
                            '#3b82f6',
                            '#10b981',
                            '#8b5cf6',
                            '#f59e0b',
                            '#ef4444',
                            '#06b6d4'
                        ],
                        borderWidth: 1
                    }]
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
                                    return value + '%';
                                }
                            }
                        }
                    }
                }
            });

            // Results chart
            const resultsCtx = document.getElementById('resultsChart').getContext('2d');
            new Chart(resultsCtx, {
                type: 'radar',
                data: {
                    labels: ['Mathematics', 'Science', 'English', 'History', 'Computer', 'PE'],
                    datasets: [{
                            label: 'Your Scores',
                            data: [85, 88, 82, 78, 92, 95],
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: '#3b82f6',
                            borderWidth: 2,
                            pointBackgroundColor: '#3b82f6',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: '#3b82f6'
                        },
                        {
                            label: 'Class Average',
                            data: [78, 82, 80, 75, 85, 88],
                            backgroundColor: 'rgba(107, 114, 128, 0.2)',
                            borderColor: '#6b7280',
                            borderWidth: 2,
                            pointBackgroundColor: '#6b7280',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: '#6b7280'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            angleLines: {
                                display: true
                            },
                            suggestedMin: 50,
                            suggestedMax: 100
                        }
                    }
                }
            });
        }

        // Open assignment submission modal
        function openAssignmentModal(id, title, subject, dueDate) {
            document.getElementById('modalAssignmentTitle').textContent = title;
            document.getElementById('modalAssignmentSubject').textContent = `Subject: ${subject}`;
            document.getElementById('modalAssignmentDeadline').textContent = `Deadline: ${dueDate}`;

            assignmentModal.classList.add('active');
        }

        // Open study material modal
        function openMaterialModal(subject, type, title) {
            document.getElementById('modalMaterialTitle').textContent = title;
            document.getElementById('modalMaterialSubject').textContent = `Subject: ${subject}`;
            document.getElementById('modalMaterialType').textContent =
                `Type: ${type === 'video' ? 'Video Lesson' : 'Study Notes'}`;

            // Show appropriate content based on type
            if (type === 'video') {
                document.getElementById('videoPlayer').style.display = 'block';
                document.getElementById('documentViewer').style.display = 'none';
                document.getElementById('playMaterialBtn').style.display = 'inline-flex';
                document.getElementById('modalMaterialDuration').textContent = 'Duration: 15 minutes';
            } else {
                document.getElementById('videoPlayer').style.display = 'none';
                document.getElementById('documentViewer').style.display = 'block';
                document.getElementById('playMaterialBtn').style.display = 'none';
                document.getElementById('modalMaterialDuration').textContent = 'Pages: 12';
            }

            materialModal.classList.add('active');
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

        // Logout function
        function logout() {
            if (confirm('Are you sure you want to log out?')) {
                studentDashboard.style.display = 'none';
                loginPage.style.display = 'flex';

                // Reset form
                document.getElementById('studentId').value = '';
                document.getElementById('password').value = '';

                showNotification('You have been logged out successfully.', 'info');
            }
        }
    </script>
</body>

</html>
