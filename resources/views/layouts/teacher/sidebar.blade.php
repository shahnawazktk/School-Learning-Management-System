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
            <a href="#" class="menu-item active" data-page="dashboard">
                <i class="fas fa-tachometer-alt menu-icon"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-group-title">TEACHING</div>
            <a href="#" class="menu-item" data-page="myClasses">
                <i class="fas fa-chalkboard-teacher menu-icon"></i>
                <span class="menu-text">My Classes</span>
            </a>
            <a href="#" class="menu-item" data-page="subjects">
                <i class="fas fa-book-open menu-icon"></i>
                <span class="menu-text">My Subjects</span>
            </a>
            <a href="#" class="menu-item" data-page="assignments">
                <i class="fas fa-tasks menu-icon"></i>
                <span class="menu-text">Assignments</span>
            </a>
            <a href="#" class="menu-item" data-page="studyMaterials">
                <i class="fas fa-video menu-icon"></i>
                <span class="menu-text">Study Materials</span>
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-group-title">STUDENTS</div>
            <a href="#" class="menu-item" data-page="students">
                <i class="fas fa-user-graduate menu-icon"></i>
                <span class="menu-text">My Students</span>
            </a>
            <a href="#" class="menu-item" data-page="attendance">
                <i class="fas fa-calendar-check menu-icon"></i>
                <span class="menu-text">Attendance</span>
            </a>
            <a href="#" class="menu-item" data-page="grades">
                <i class="fas fa-chart-line menu-icon"></i>
                <span class="menu-text">Grades & Results</span>
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-group-title">ACCOUNT</div>
            <a href="#" class="menu-item" data-page="profile">
                <i class="fas fa-user menu-icon"></i>
                <span class="menu-text">My Profile</span>
            </a>
            <a href="#" class="menu-item" data-page="reports">
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
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
        </form>
        <button class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </button>
    </div>
</div>
