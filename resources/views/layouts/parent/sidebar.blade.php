<div class="sidebar @if(request()->cookie('sidebar_collapsed')) collapsed @endif" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('parent.dashboard') }}" class="logo-container">
            <img src="{{ asset('img/Smart-logo.png') }}" alt="Smart School Logo" class="logo-img">
            <span class="logo-text">Parent Portal</span>
        </a>
    </div>

    <div class="sidebar-menu">
        <!-- Dashboard -->
        <div class="menu-group">
            <a href="{{ route('parent.dashboard') }}" class="menu-item {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt menu-icon"></i>
                <span class="menu-text">Dashboard</span>
            </a>
        </div>

        <!-- Children Management -->
        <div class="menu-group">
            <div class="menu-group-title">
                <span class="menu-text">Management</span>
            </div>
            <a href="{{ route('parent.children') }}" class="menu-item {{ request()->routeIs('parent.children') ? 'active' : '' }}">
                <i class="fas fa-child menu-icon"></i>
                <span class="menu-text">My Children</span>
            </a>
            <a href="{{ route('parent.children') }}" class="menu-item {{ request()->routeIs('parent.child.attendance') ? 'active' : '' }}">
                <i class="fas fa-calendar-check menu-icon"></i>
                <span class="menu-text">Attendance</span>
            </a>
            <a href="{{ route('parent.children') }}" class="menu-item {{ request()->routeIs('parent.child.grades') ? 'active' : '' }}">
                <i class="fas fa-chart-line menu-icon"></i>
                <span class="menu-text">Grades</span>
            </a>
            <a href="{{ route('parent.children') }}" class="menu-item {{ request()->routeIs('parent.child.assignments') ? 'active' : '' }}">
                <i class="fas fa-book menu-icon"></i>
                <span class="menu-text">Assignments</span>
            </a>
        </div>

        <!-- Profile -->
        <div class="menu-group">
            <a href="{{ route('parent.profile') }}" class="menu-item {{ request()->routeIs('parent.profile') ? 'active' : '' }}">
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
            <span class="menu-text">Log Out</span>
        </button>
    </div>
</div>