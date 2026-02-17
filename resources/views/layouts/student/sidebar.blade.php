@php
    $isMobile = $mobile ?? false;
    $studentName = Auth::user()->name ?? 'Student';
    $studentInitials = strtoupper(substr($studentName, 0, 2));
@endphp

@if($isMobile)
    <div class="offcanvas offcanvas-start" tabindex="-1" id="studentSidebarOffcanvas" aria-labelledby="studentSidebarOffcanvasLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="studentSidebarOffcanvasLabel">
                <i class="fas fa-graduation-cap text-primary me-2"></i>Student Portal
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 d-flex flex-column">
            <div class="p-3 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        @if(!empty($student->profile_image))
                            <img src="{{ asset('storage/' . $student->profile_image) }}" alt="Profile" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover;">
                        @else
                            {{ $studentInitials }}
                        @endif
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $studentName }}</div>
                        <div class="student-badge">{{ $student->student_id ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <nav class="p-3 d-grid gap-1">
                <a href="{{ route('student.dashboard') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-gauge-high me-2"></i><span class="sidebar-label">Dashboard</span>
                </a>
                <a href="{{ route('student.subjects') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.subjects') ? 'active' : '' }}">
                    <i class="fas fa-book-open me-2"></i><span class="sidebar-label">My Subjects</span>
                </a>
                <a href="{{ route('student.resources') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.resources') ? 'active' : '' }}">
                    <i class="fas fa-photo-film me-2"></i><span class="sidebar-label">Study Materials</span>
                </a>
                <a href="{{ route('student.assignments') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.assignments') ? 'active' : '' }}">
                    <i class="fas fa-list-check me-2"></i><span class="sidebar-label">Assignments</span>
                </a>
                <a href="{{ route('student.attendance') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.attendance') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check me-2"></i><span class="sidebar-label">Attendance</span>
                </a>
                <a href="{{ route('student.fees') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.fees') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave me-2"></i><span class="sidebar-label">Fees</span>
                </a>
                <a href="{{ route('student.results') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.results') ? 'active' : '' }}">
                    <i class="fas fa-chart-line me-2"></i><span class="sidebar-label">Results</span>
                </a>
                <a href="{{ route('student.exams') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.exams') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list me-2"></i><span class="sidebar-label">Exams</span>
                </a>
                <a href="{{ route('student.profile') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                    <i class="fas fa-user me-2"></i><span class="sidebar-label">My Profile</span>
                </a>
            </nav>

            <div class="mt-auto p-3 border-top">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fas fa-right-from-bracket me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
@else
    <aside class="student-sidebar d-none d-lg-flex flex-column">
        <div class="p-3 border-bottom">
            <a href="{{ route('student.dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
                <img src="{{ asset('img/Smart-logo.png') }}" alt="Logo" style="width: 36px; height: 36px; object-fit: contain;">
                <span class="sidebar-brand-text fw-bold text-dark">Student Portal</span>
            </a>
        </div>

        <div class="p-3 border-bottom">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px;">
                    @if(!empty($student->profile_image))
                        <img src="{{ asset('storage/' . $student->profile_image) }}" alt="Profile" style="width: 46px; height: 46px; border-radius: 50%; object-fit: cover;">
                    @else
                        {{ $studentInitials }}
                    @endif
                </div>
                <div class="student-profile-meta">
                    <div class="fw-semibold text-truncate">{{ $studentName }}</div>
                    <div class="student-badge text-truncate">{{ $student->class ?? 'N/A' }} - {{ $student->section ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <nav class="p-3 d-grid gap-1 flex-grow-1">
            <a href="{{ route('student.dashboard') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class="fas fa-gauge-high me-2"></i><span class="sidebar-label">Dashboard</span>
            </a>
            <a href="{{ route('student.subjects') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.subjects') ? 'active' : '' }}">
                <i class="fas fa-book-open me-2"></i><span class="sidebar-label">My Subjects</span>
            </a>
            <a href="{{ route('student.resources') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.resources') ? 'active' : '' }}">
                <i class="fas fa-photo-film me-2"></i><span class="sidebar-label">Study Materials</span>
            </a>
            <a href="{{ route('student.assignments') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.assignments') ? 'active' : '' }}">
                <i class="fas fa-list-check me-2"></i><span class="sidebar-label">Assignments</span>
            </a>
            <a href="{{ route('student.attendance') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.attendance') ? 'active' : '' }}">
                <i class="fas fa-calendar-check me-2"></i><span class="sidebar-label">Attendance</span>
            </a>
            <a href="{{ route('student.fees') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.fees') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave me-2"></i><span class="sidebar-label">Fees</span>
            </a>
            <a href="{{ route('student.results') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.results') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-2"></i><span class="sidebar-label">Results</span>
            </a>
            <a href="{{ route('student.exams') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.exams') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list me-2"></i><span class="sidebar-label">Exams</span>
            </a>
            <a href="{{ route('student.profile') }}" class="menu-link d-flex align-items-center {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                <i class="fas fa-user me-2"></i><span class="sidebar-label">My Profile</span>
            </a>
        </nav>

        <div class="p-3 border-top">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="fas fa-right-from-bracket me-1"></i><span class="sidebar-label">Logout</span>
                </button>
            </form>
        </div>
    </aside>
@endif
