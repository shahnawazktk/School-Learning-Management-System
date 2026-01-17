<div class="header">
    <div class="header-left">
        <button class="toggle-sidebar" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="page-title">
            <h1 style="cursor:pointer; color:rgb(23, 23, 26);"
                onclick="window.location='{{ route('teacher.dashboard') }}'" id="pageTitle">Dashboard</h1>
        </div>
    </div>

    <div class="header-right">
        <div class="notification-wrapper">
            <button class="notification-btn" id="notificationBtn">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">5</span>
            </button>
        </div>

        <div class="teacher-profile-header">
            <div class="teacher-avatar-small">SJ</div>
            <div class="teacher-info-header">
                <h4>Ms. Sarah Johnson</h4>
                <p>Math Teacher</p>
            </div>
        </div>
    </div>
</div>
