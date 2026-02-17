<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <a href="{{ route('student.dashboard') }}" class="logo-link">
                <img src="{{ asset('img/Smart-logo.png') }}" alt="Logo" class="logo-img">
                <h2>Student Portal</h2>
            </a>
        </div>
    </div>

    <div class="student-profile-sidebar">
        <div class="student-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        <div class="student-info-sidebar">
            <h3>{{ Auth::user()->name }}</h3>
            <p><i class="fas fa-id-card"></i> {{ $student->student_id ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="sidebar-menu">
        <a href="{{ route('student.dashboard') }}" class="menu-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt menu-icon"></i>
            <span class="menu-text">Dashboard</span>
        </a>
        <a href="{{ route('student.subjects') }}" class="menu-item {{ request()->routeIs('student.subjects') ? 'active' : '' }}">
            <i class="fas fa-book-open menu-icon"></i>
            <span class="menu-text">My Subjects</span>
        </a>
        <a href="{{ route('student.resources') }}" class="menu-item {{ request()->routeIs('student.resources') ? 'active' : '' }}">
            <i class="fas fa-video menu-icon"></i>
            <span class="menu-text">Study Materials</span>
        </a>
        <a href="{{ route('student.assignments') }}" class="menu-item {{ request()->routeIs('student.assignments') ? 'active' : '' }}">
            <i class="fas fa-tasks menu-icon"></i>
            <span class="menu-text">Assignments</span>
        </a>
        <a href="{{ route('student.attendance') }}" class="menu-item {{ request()->routeIs('student.attendance') ? 'active' : '' }}">
            <i class="fas fa-calendar-check menu-icon"></i>
            <span class="menu-text">Attendance</span>
        </a>
        <a href="{{ route('student.results') }}" class="menu-item {{ request()->routeIs('student.results') ? 'active' : '' }}">
            <i class="fas fa-chart-line menu-icon"></i>
            <span class="menu-text">Results</span>
        </a>
        <a href="{{ route('student.exams') }}" class="menu-item {{ request()->routeIs('student.exams') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list menu-icon"></i>
            <span class="menu-text">Exams</span>
        </a>
        <a href="{{ route('student.profile') }}" class="menu-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
            <i class="fas fa-user menu-icon"></i>
            <span class="menu-text">My Profile</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
