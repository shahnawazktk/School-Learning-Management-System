<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <a href="{{ route('dashboard') }}" class="logo-link">
                <img src="{{ asset('img/Smart-logo.png') }}" alt="Smart School Logo" class="logo-img">
                <h2>Teacher Portal</h2>
            </a>
        </div>
    </div>

    <div class="teacher-profile-sidebar">
        <div class="teacher-avatar">SJ</div>
        <div class="teacher-info-sidebar">
            <h3>Ms. Sarah Johnson</h3>
            <p><i class="fas fa-user-tie"></i> Mathematics Teacher</p>
            <p><i class="fas fa-id-card"></i> TEA2023001</p>
        </div>
    </div>

    <div class="sidebar-menu">
        <div class="menu-group">
            <div class="menu-group-title">DASHBOARD</div>
            <a href="{{ route('teacher.dashboard') }}" class="menu-item {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt menu-icon"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-group-title">TEACHING</div>
            <a href="{{ route('teacher.courses') }}" class="menu-item {{ request()->routeIs('teacher.courses') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher menu-icon"></i>
                <span class="menu-text">My Courses</span>
            </a>
            <a href="{{ route('teacher.assignments') }}" class="menu-item {{ request()->routeIs('teacher.assignments') ? 'active' : '' }}">
                <i class="fas fa-tasks menu-icon"></i>
                <span class="menu-text">Assignments</span>
            </a>
            <a href="{{ route('teacher.submissions') }}" class="menu-item {{ request()->routeIs('teacher.submissions') ? 'active' : '' }}">
                <i class="fas fa-file-alt menu-icon"></i>
                <span class="menu-text">Submissions</span>
            </a>
            <a href="{{ route('teacher.exams') }}" class="menu-item {{ request()->routeIs('teacher.exams') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list menu-icon"></i>
                <span class="menu-text">Exams</span>
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-group-title">STUDENTS</div>
            <a href="{{ route('teacher.attendance') }}" class="menu-item {{ request()->routeIs('teacher.attendance') ? 'active' : '' }}">
                <i class="fas fa-calendar-check menu-icon"></i>
                <span class="menu-text">Attendance</span>
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-group-title">ACCOUNT</div>
            <a href="{{ route('teacher.profile') }}" class="menu-item {{ request()->routeIs('teacher.profile') ? 'active' : '' }}">
                <i class="fas fa-user menu-icon"></i>
                <span class="menu-text">My Profile</span>
            </a>
        </div>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
        </form>
        <button class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </button>
    </div>
</div>
