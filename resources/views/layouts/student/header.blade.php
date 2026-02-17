<div class="header">
    <div class="header-left">
        <button class="toggle-sidebar" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="page-title">
            <h1 id="pageTitle">
                @if(request()->routeIs('student.dashboard'))
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                @elseif(request()->routeIs('student.subjects'))
                    <i class="fas fa-book-open"></i> My Subjects
                @elseif(request()->routeIs('student.assignments'))
                    <i class="fas fa-tasks"></i> Assignments
                @elseif(request()->routeIs('student.attendance'))
                    <i class="fas fa-calendar-check"></i> Attendance
                @elseif(request()->routeIs('student.results'))
                    <i class="fas fa-chart-line"></i> Results
                @elseif(request()->routeIs('student.resources'))
                    <i class="fas fa-video"></i> Study Materials
                @elseif(request()->routeIs('student.exams'))
                    <i class="fas fa-clipboard-list"></i> Exams
                @elseif(request()->routeIs('student.profile'))
                    <i class="fas fa-user"></i> My Profile
                @else
                    <i class="fas fa-tachometer-alt"></i> Student Dashboard
                @endif
            </h1>
        </div>
    </div>

    <div class="header-right">
        <div class="notification-wrapper">
            <button class="notification-btn" id="notificationBtn">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">{{ Auth::user()->unreadNotifications->count() ?? 0 }}</span>
            </button>
        </div>

        <div class="student-profile-header">
            <div class="student-avatar-small">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
            <div class="student-info-header">
                <h4>{{ Auth::user()->name }}</h4>
                <p>{{ $student->class ?? 'N/A' }} - {{ $student->section ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
