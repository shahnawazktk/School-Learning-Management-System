<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --success-color: #4ade80;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-color: #f8f9fa;
            --dark-color: #1e293b;
            --gray-color: #64748b;
            --sidebar-width: 260px;
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

        /* ========== MAIN LAYOUT CONTAINER ========== */
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
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            transition: var(--transition);
            z-index: 1000;
            overflow: hidden;
        }

        /* Sidebar Header */
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

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
        }

        .logo-icon {
            color: var(--primary-color);
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        /* Sidebar Menu */
        .sidebar-menu {
            padding: 1rem 0;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
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
            margin: 0.1rem 0;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .menu-item:hover {
            background-color: #f8fafc;
            color: var(--primary-color);
        }

        .menu-item.active {
            background-color: #eef2ff;
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
            transition: var(--transition);
            white-space: nowrap;
            font-size: 0.95rem;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: auto;
            flex-shrink: 0;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }

        .user-info {
            min-width: 0;
            flex: 1;
        }

        .user-info h4 {
            font-size: 0.9rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-info p {
            font-size: 0.8rem;
            color: var(--gray-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Collapsed Sidebar State */
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .sidebar-header h2,
        .sidebar.collapsed .user-info,
        .sidebar.collapsed .menu-group-title {
            opacity: 0;
            width: 0;
            overflow: hidden;
            display: none;
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

        /* Header Structure */
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

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--dark-color);
            font-weight: 500;
            white-space: nowrap;
        }

        .breadcrumb-separator {
            color: var(--gray-color);
            font-size: 0.8rem;
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

        /* Content Area */
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

        /* ========== DASHBOARD CONTENT STRUCTURE ========== */
        .dashboard-title {
            margin-bottom: 1.5rem;
            width: 100%;
        }

        .dashboard-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            white-space: nowrap;
        }

        .dashboard-title p {
            color: var(--gray-color);
            font-size: 1rem;
            max-width: 800px;
        }

        /* Welcome Banner */
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

        .welcome-banner h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            white-space: nowrap;
        }

        .welcome-banner-content {
            flex: 1;
            min-width: 250px;
        }

        .quick-stats {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .quick-stat-item {
            text-align: center;
            min-width: 80px;
            flex-shrink: 0;
        }

        .quick-stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
        }

        .quick-stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 0.3rem;
            white-space: nowrap;
        }

        /* Stats Grid */
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
            min-height: 120px;
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

        /* Section Titles */
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

        /* Features Grid */
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
            min-height: 200px;
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
            background-color: #eef2ff;
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

        /* Buttons */
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
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .btn-outline:hover {
            background-color: #eef2ff;
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background-color: #22c55e;
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

        /* Chart Section */
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

        /* ========== USER DROPDOWN STRUCTURE ========== */
        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            background: none;
            border: 1px solid #e2e8f0;
            border-radius: var(--border-radius);
            padding: 8px 12px;
            cursor: pointer;
            transition: var(--transition);
            background-color: white;
            white-space: nowrap;
        }

        .user-dropdown-toggle:hover {
            border-color: var(--primary-color);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .user-avatar-small {
            width: 32px;
            height: 32px;
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

        .user-name {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.9rem;
        }

        .dropdown-icon {
            font-size: 0.8rem;
            color: var(--gray-color);
            transition: transform 0.3s ease;
        }

        .user-dropdown.active .dropdown-icon {
            transform: rotate(180deg);
        }

        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 240px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            z-index: 1000;
        }

        .user-dropdown.active .user-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header {
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar-medium {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .dropdown-divider {
            height: 1px;
            background-color: #e2e8f0;
            margin: 0.5rem 0;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.8rem 1rem;
            text-decoration: none;
            color: var(--dark-color);
            transition: background-color 0.2s;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .dropdown-item:hover {
            background-color: #f8fafc;
            color: var(--primary-color);
        }

        .dropdown-item i {
            width: 20px;
            color: var(--gray-color);
        }

        .dropdown-item:hover i {
            color: var(--primary-color);
        }

        .logout-item {
            color: var(--danger-color);
        }

        .logout-item i {
            color: var(--danger-color);
        }

        .logout-item:hover {
            background-color: #fef2f2;
        }

        /* ========== MODAL STRUCTURE ========== */
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
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            max-width: 600px;
            width: 90%;
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

        .modal-body ul {
            padding-left: 1.5rem;
            margin: 1rem 0;
        }

        .modal-body li {
            margin-bottom: 0.5rem;
        }

        /* ========== RESPONSIVE DESIGN ========== */
        @media (max-width: 1200px) {
            .features-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
            }

            .sidebar .menu-text,
            .sidebar .sidebar-header h2,
            .sidebar .user-info,
            .sidebar .menu-group-title {
                opacity: 0;
                width: 0;
                overflow: hidden;
                display: none;
            }

            .main-content {
                margin-left: var(--sidebar-collapsed-width);
                width: calc(100vw - var(--sidebar-collapsed-width));
            }

            .main-content.expanded {
                margin-left: 0;
                width: 100vw;
            }

            .sidebar.expanded {
                width: var(--sidebar-width);
                z-index: 1001;
            }

            .sidebar.expanded .menu-text,
            .sidebar.expanded .sidebar-header h2,
            .sidebar.expanded .user-info,
            .sidebar.expanded .menu-group-title {
                opacity: 1;
                width: auto;
                display: block;
            }

            .dashboard-title h1 {
                font-size: 1.6rem;
            }

            .welcome-banner h2 {
                font-size: 1.3rem;
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

            .stats-grid,
            .features-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .header-right {
                gap: 1rem;
            }

            .welcome-banner {
                flex-direction: column;
                align-items: flex-start;
                padding: 1.2rem;
            }

            .quick-stats {
                width: 100%;
                justify-content: space-between;
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
            .sidebar {
                width: 0;
                overflow: hidden;
                z-index: 1100;
            }

            .sidebar.expanded {
                width: 100%;
            }

            .main-content {
                margin-left: 0;
                width: 100vw;
            }

            .welcome-banner h2 {
                font-size: 1.2rem;
            }

            .user-name {
                display: none;
            }

            .user-dropdown-toggle {
                padding: 6px 8px;
            }

            .user-dropdown-menu {
                position: fixed;
                top: var(--header-height);
                left: 0;
                right: 0;
                width: auto;
                margin: 0 1rem;
            }

            .modal {
                width: 95%;
                margin: 1rem;
            }

            .content {
                padding: 1rem;
            }

            .dashboard-title h1 {
                font-size: 1.4rem;
                flex-wrap: wrap;
            }

            .dashboard-title p {
                font-size: 0.9rem;
            }

            .quick-stats {
                gap: 1rem;
            }

            .quick-stat-item {
                min-width: 70px;
            }

            .quick-stat-value {
                font-size: 1.5rem;
            }

            .section-title h2 {
                font-size: 1.3rem;
            }
        }

        /* ========== UTILITY CLASSES ========== */
        .text-center {
            text-align: center;
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

        .mt-1 {
            margin-top: 0.5rem;
        }

        .mt-2 {
            margin-top: 1rem;
        }

        .mt-3 {
            margin-top: 1.5rem;
        }

        .hidden {
            display: none !important;
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

        .w-full {
            width: 100%;
        }

        .h-full {
            height: 100%;
        }

        /* Mobile Sidebar Overlay */
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
    </style>
</head>

<body>
    <div class="layout-container">
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- ========== SIDEBAR ========== -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo-container">
                    <i class="fas fa-school logo-icon"></i>
                    <h2>Smart School</h2>
                </div>
            </div>

            <div class="sidebar-menu">
                <div class="menu-group">
                    <div class="menu-group-title">MAIN NAVIGATION</div>
                    <a href="{{ route('admin.dashboard') }}" class="menu-item active">
                        <i class="fas fa-tachometer-alt menu-icon"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </div>

                <div class="menu-group">
                    <div class="menu-group-title">SCHOOL MANAGEMENT</div>
                    <a href="#" class="menu-item" id="schoolInfoMenu">
                        <i class="fas fa-school menu-icon"></i>
                        <span class="menu-text">School Info</span>
                    </a>
                    <a href="#" class="menu-item" id="classesMenu">
                        <i class="fas fa-chalkboard-teacher menu-icon"></i>
                        <span class="menu-text">Classes & Sections</span>
                    </a>
                    <a href="#" class="menu-item" id="subjectsMenu">
                        <i class="fas fa-book-open menu-icon"></i>
                        <span class="menu-text">Subjects</span>
                    </a>
                </div>

                <div class="menu-group">
                    <div class="menu-group-title">PEOPLE MANAGEMENT</div>
                    <a href="#" class="menu-item" id="teachersMenu">
                        <i class="fas fa-users menu-icon"></i>
                        <span class="menu-text">Teachers</span>
                    </a>
                    <a href="#" class="menu-item" id="studentsMenu">
                        <i class="fas fa-user-graduate menu-icon"></i>
                        <span class="menu-text">Students</span>
                    </a>
                    <a href="#" class="menu-item" id="assignmentsMenu">
                        <i class="fas fa-tasks menu-icon"></i>
                        <span class="menu-text">Assign Teachers</span>
                    </a>
                </div>

                <div class="menu-group">
                    <div class="menu-group-title">ANALYTICS & REPORTS</div>
                    <a href="#" class="menu-item" id="reportsMenu">
                        <i class="fas fa-chart-bar menu-icon"></i>
                        <span class="menu-text">Reports</span>
                    </a>
                    <a href="#" class="menu-item">
                        <i class="fas fa-cog menu-icon"></i>
                        <span class="menu-text">Settings</span>
                    </a>
                </div>
            </div>

            <div class="sidebar-footer">
                <div class="user-avatar">AD</div>
                <div class="user-info">
                    <h4>Admin User</h4>
                    <p>Administrator</p>
                </div>
            </div>
        </div>

        <!-- ========== MAIN CONTENT ========== -->
        <div class="main-content" id="mainContent">
            <!-- Header -->
            <div class="header">
                <div class="header-left">
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="breadcrumb">
                        <span>Admin Dashboard</span>
                    </div>
                </div>

                <div class="header-right">
                    <div class="notification-wrapper">
                        <button class="notification-btn" id="notificationBtn">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="user-dropdown">
                        <button class="user-dropdown-toggle" id="userDropdownToggle">
                            <div class="user-avatar-small">AD</div>
                            <span class="user-name">Admin User</span>
                            <i class="fas fa-chevron-down dropdown-icon"></i>
                        </button>

                        <div class="user-dropdown-menu" id="userDropdownMenu">
                            <div class="dropdown-header">
                                <div class="user-avatar-medium">AD</div>
                                <div class="user-info">
                                    <h4>Admin User</h4>
                                    <p>admin@school.com</p>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>

                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>My Profile</span>
                            </a>

                            <a href="#" class="dropdown-item">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </a>

                            <a href="#" class="dropdown-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Account Security</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                            </form>
                            <a href="#" class="dropdown-item logout-item"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>{{ __('Log Out') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
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
            </div>
        </div>
    </div>

    <!-- ========== MODALS ========== -->
    <!-- Modal for School Info -->
    <div class="modal-overlay" id="schoolInfoModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-school"></i> School Information</h3>
                <button class="modal-close" id="closeSchoolInfoModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>School information management interface would appear here.</p>
                <p>This would include fields for:</p>
                <ul>
                    <li>School Name</li>
                    <li>Address and Contact Information</li>
                    <li>Academic Year</li>
                    <li>School Logo Upload</li>
                    <li>System Settings</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Class -->
    <div class="modal-overlay" id="addClassModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fas fa-chalkboard-teacher"></i> Add New Class</h3>
                <button class="modal-close" id="closeAddClassModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Class creation interface would appear here.</p>
                <p>This would include fields for:</p>
                <ul>
                    <li>Class Name/Level (e.g., Class 1, Class 2)</li>
                    <li>Class Code</li>
                    <li>Section Creation</li>
                    <li>Class Teacher Assignment</li>
                    <li>Capacity Settings</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const toggleSidebarBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuItems = document.querySelectorAll('.menu-item');
        const notificationBtn = document.getElementById('notificationBtn');
        const userDropdownToggle = document.getElementById('userDropdownToggle');
        const userDropdown = document.querySelector('.user-dropdown');
        const userDropdownMenu = document.getElementById('userDropdownMenu');

        // Modal Elements
        const schoolInfoModal = document.getElementById('schoolInfoModal');
        const addClassModal = document.getElementById('addClassModal');
        const closeSchoolInfoModal = document.getElementById('closeSchoolInfoModal');
        const closeAddClassModal = document.getElementById('closeAddClassModal');

        // Feature Buttons
        const editSchoolInfoBtn = document.getElementById('editSchoolInfoBtn');
        const viewSchoolSettingsBtn = document.getElementById('viewSchoolSettingsBtn');
        const addClassBtn = document.getElementById('addClassBtn');
        const viewClassesBtn = document.getElementById('viewClassesBtn');
        const addSubjectBtn = document.getElementById('addSubjectBtn');
        const manageSubjectsBtn = document.getElementById('manageSubjectsBtn');
        const addTeacherBtn = document.getElementById('addTeacherBtn');
        const addStudentBtn = document.getElementById('addStudentBtn');
        const assignTeacherBtn = document.getElementById('assignTeacherBtn');
        const viewAssignmentsBtn = document.getElementById('viewAssignmentsBtn');
        const attendanceReportBtn = document.getElementById('attendanceReportBtn');
        const resultsReportBtn = document.getElementById('resultsReportBtn');

        // Menu Items
        const schoolInfoMenu = document.getElementById('schoolInfoMenu');
        const classesMenu = document.getElementById('classesMenu');
        const subjectsMenu = document.getElementById('subjectsMenu');
        const teachersMenu = document.getElementById('teachersMenu');
        const studentsMenu = document.getElementById('studentsMenu');
        const assignmentsMenu = document.getElementById('assignmentsMenu');
        const reportsMenu = document.getElementById('reportsMenu');

        // Initialize Chart
        const initChart = () => {
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            return new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        label: 'Attendance Rate (%)',
                        data: [92, 88, 95, 90, 87, 93, 89, 94, 91, 96, 90, 93],
                        backgroundColor: 'rgba(67, 97, 238, 0.7)',
                        borderColor: 'rgba(67, 97, 238, 1)',
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
        };

        // Sidebar Toggle Function
        const toggleSidebar = () => {
            const isMobile = window.innerWidth <= 576;
            const isTablet = window.innerWidth <= 1024;

            if (isMobile) {
                sidebar.classList.toggle('expanded');
                sidebarOverlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('expanded') ? 'hidden' : '';
            } else if (isTablet) {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        };

        // Set Active Menu Item
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                menuItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                updateContentTitle(this.querySelector('.menu-text').textContent);

                // Close sidebar on mobile after clicking menu item
                if (window.innerWidth <= 576) {
                    sidebar.classList.remove('expanded');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        // Update Content Title
        const updateContentTitle = (menuText) => {
            const contentTitle = document.querySelector('.dashboard-title h1');
            const contentDesc = document.querySelector('.dashboard-title p');

            const titles = {
                'Dashboard': {
                    icon: 'fa-tachometer-alt',
                    desc: 'School Management System - Manage classes, teachers, students, and more'
                },
                'School Info': {
                    icon: 'fa-school',
                    desc: 'Manage school details, contact information, and system settings'
                },
                'Classes & Sections': {
                    icon: 'fa-chalkboard-teacher',
                    desc: 'Manage classes (Class 1, 2, 3...) and sections within each class'
                },
                'Subjects': {
                    icon: 'fa-book-open',
                    desc: 'Add, edit, or remove subjects from the curriculum'
                },
                'Teachers': {
                    icon: 'fa-users',
                    desc: 'Create, read, update, and delete teacher records'
                },
                'Students': {
                    icon: 'fa-user-graduate',
                    desc: 'Create, read, update, and delete student records'
                },
                'Assign Teachers': {
                    icon: 'fa-tasks',
                    desc: 'Assign teachers to specific classes and subjects they teach'
                },
                'Reports': {
                    icon: 'fa-chart-bar',
                    desc: 'View attendance, results, and other analytical reports'
                },
                'Settings': {
                    icon: 'fa-cog',
                    desc: 'Configure system preferences and user permissions'
                }
            };

            if (titles[menuText]) {
                contentTitle.innerHTML = `<i class="fas ${titles[menuText].icon}"></i> ${menuText}`;
                contentDesc.textContent = titles[menuText].desc;
            }
        };

        // Notification Button
        notificationBtn.addEventListener('click', () => {
            alert(
                'You have 3 new notifications:\n1. 2 new teacher applications\n2. 1 student transfer request\n3. Monthly report is ready'
            );
            notificationBtn.querySelector('.notification-badge').style.display = 'none';
        });

        // User Dropdown Toggle
        userDropdownToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!userDropdown.contains(e.target)) {
                userDropdown.classList.remove('active');
            }
            if (!schoolInfoModal.contains(e.target)) {
                schoolInfoModal.classList.remove('active');
            }
            if (!addClassModal.contains(e.target)) {
                addClassModal.classList.remove('active');
            }
        });

        // Feature Button Handlers
        const featureHandlers = {
            // School Info
            editSchoolInfoBtn: () => schoolInfoModal.classList.add('active'),
            viewSchoolSettingsBtn: () => schoolInfoModal.classList.add('active'),
            schoolInfoMenu: () => schoolInfoModal.classList.add('active'),

            // Classes
            addClassBtn: () => addClassModal.classList.add('active'),
            viewClassesBtn: () => addClassModal.classList.add('active'),
            classesMenu: () => addClassModal.classList.add('active'),

            // Subjects
            addSubjectBtn: () => alert('Add Subject feature would open here'),
            manageSubjectsBtn: () => alert('Manage Subjects interface would open here'),
            subjectsMenu: () => alert('Subjects Management interface would open here'),

            // Teachers & Students
            addTeacherBtn: () => alert('Add Teacher form would open here'),
            addStudentBtn: () => alert('Add Student form would open here'),
            teachersMenu: () => alert('Teachers Management interface would open here'),
            studentsMenu: () => alert('Students Management interface would open here'),

            // Assignments
            assignTeacherBtn: () => alert('Assign Teacher to Class/Subject interface would open here'),
            viewAssignmentsBtn: () => alert('View Teacher Assignments interface would open here'),
            assignmentsMenu: () => alert('Teacher Assignments interface would open here'),

            // Reports
            attendanceReportBtn: () => alert('Attendance Reports would be displayed here'),
            resultsReportBtn: () => alert('Results Reports would be displayed here'),
            reportsMenu: () => alert('Reports Dashboard would open here'),

            // Modal Closes
            closeSchoolInfoModal: () => schoolInfoModal.classList.remove('active'),
            closeAddClassModal: () => addClassModal.classList.remove('active')
        };

        // Attach Event Listeners
        Object.keys(featureHandlers).forEach(key => {
            const element = document.getElementById(key);
            if (element) {
                element.addEventListener('click', (e) => {
                    e.preventDefault();
                    featureHandlers[key]();
                    if (key.includes('Menu')) {
                        highlightMenu(key);
                    }
                });
            }
        });

        // Highlight Menu Function
        const highlightMenu = (menuId) => {
            menuItems.forEach(item => item.classList.remove('active'));
            document.getElementById(menuId).classList.add('active');
        };

        // Close sidebar overlay click
        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('expanded');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Handle window resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                if (window.innerWidth > 576) {
                    sidebar.classList.remove('expanded');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                }
            }, 250);
        });

        // Close dropdown when clicking on dropdown items
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', () => {
                userDropdown.classList.remove('active');
            });
        });

        // Toggle sidebar event
        toggleSidebarBtn.addEventListener('click', toggleSidebar);

        // Initialize on load
        window.addEventListener('DOMContentLoaded', () => {
            const attendanceChart = initChart();

            // Set initial state based on screen size
            if (window.innerWidth <= 1024) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }

            console.log('School Management Admin Dashboard loaded successfully.');
            console.log('Layout features:');
            console.log('1. Fixed sidebar with proper overflow handling');
            console.log('2. Sticky header with responsive design');
            console.log('3. Main content with fixed size and scroll');
            console.log('4. Mobile-friendly sidebar overlay');
        });
    </script>
</body>

</html>
