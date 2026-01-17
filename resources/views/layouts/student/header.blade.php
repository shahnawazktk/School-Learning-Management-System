<div class="header">
    <div class="header-left">
        <button class="toggle-sidebar" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="page-title">
            <h1 style="cursor:pointer; color:rgb(23, 23, 26);"
                onclick="window.location='{{ route('student.dashboard') }}'" id="pageTitle"> Student Dashboard</h1>

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
