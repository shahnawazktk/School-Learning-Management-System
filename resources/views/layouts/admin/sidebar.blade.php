<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <a href="{{ route('dashboard') }}" class="logo-link">
                <img src="{{ asset('img/Smart-logo.png') }}" alt="Smart School Logo" class="logo-img">
                <h2>Smart Taleem</h2>
            </a>
        </div>
    </div>

    <div class="sidebar-menu">
        <div class="menu-group">
            <div class="menu-group-title">MAIN NAVIGATION</div>
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt menu-icon"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-group-title">SCHOOL MANAGEMENT</div>
            <a href="{{ route('admin.profile') }}" class="menu-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}" id="schoolInfoMenu">
                <i class="fas fa-school menu-icon"></i>
                <span class="menu-text">School Info</span>
            </a>
            <a href="{{ route('admin.dashboard') }}#academic-overview" class="menu-item" id="classesMenu">
                <i class="fas fa-chalkboard-teacher menu-icon"></i>
                <span class="menu-text">Classes & Sections</span>
            </a>
            <a href="{{ route('admin.dashboard') }}#academic-overview" class="menu-item" id="subjectsMenu">
                <i class="fas fa-book-open menu-icon"></i>
                <span class="menu-text">Subjects</span>
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-group-title">PEOPLE MANAGEMENT</div>
            <a href="{{ route('admin.dashboard') }}#people-overview" class="menu-item" id="teachersMenu">
                <i class="fas fa-users menu-icon"></i>
                <span class="menu-text">Teachers</span>
            </a>
            <a href="{{ route('admin.dashboard') }}#people-overview" class="menu-item" id="studentsMenu">
                <i class="fas fa-user-graduate menu-icon"></i>
                <span class="menu-text">Students</span>
            </a>
            <a href="{{ route('admin.dashboard') }}#academic-overview" class="menu-item" id="assignmentsMenu">
                <i class="fas fa-tasks menu-icon"></i>
                <span class="menu-text">Assign Teachers</span>
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-group-title">ANALYTICS & REPORTS</div>
            <a href="{{ route('admin.dashboard') }}#attendance-overview" class="menu-item" id="reportsMenu">
                <i class="fas fa-chart-bar menu-icon"></i>
                <span class="menu-text">Reports</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="menu-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="fas fa-cog menu-icon"></i>
                <span class="menu-text">Settings</span>
            </a>
        </div>
    </div>
</div>
