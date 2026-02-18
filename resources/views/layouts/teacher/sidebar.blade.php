@php
    $user = auth()->user();
    $teacher = $user?->teacher;
    $teacherName = $user->name ?? 'Teacher';
    $teacherInitials = strtoupper(substr($teacherName, 0, 2));
    $isMobile = $mobile ?? false;
@endphp

@if($isMobile)
    <div class="offcanvas offcanvas-start teacher-mobile-sidebar" tabindex="-1" id="teacherSidebarOffcanvas" aria-labelledby="teacherSidebarOffcanvasLabel">
        <div class="offcanvas-header border-bottom bg-light-subtle">
            <h5 class="offcanvas-title" id="teacherSidebarOffcanvasLabel">Teacher Portal</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-3 d-flex flex-column">
            <div class="d-flex align-items-center gap-3 mb-3 p-2 rounded bg-light">
                @if(!empty($teacher?->profile_image))
                    <img src="{{ asset('storage/' . $teacher->profile_image) }}" alt="Teacher" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;">
                @else
                    <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;font-size:.85rem;font-weight:700;">{{ $teacherInitials }}</span>
                @endif
                <div>
                    <div class="fw-semibold">{{ $teacherName }}</div>
                    <small class="text-muted">Teacher Account</small>
                </div>
            </div>

            <div class="teacher-menu-group-title">Main</div>
            <ul class="teacher-menu-list nav flex-column">
                <li class="nav-item"><a href="{{ route('teacher.dashboard') }}" class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}"><i class="fas fa-gauge-high me-2"></i><span class="teacher-link-text">Dashboard</span></a></li>
            </ul>

            <div class="teacher-menu-group-title">Teaching</div>
            <ul class="teacher-menu-list nav flex-column">
                <li class="nav-item"><a href="{{ route('teacher.courses') }}" class="nav-link {{ request()->routeIs('teacher.courses') ? 'active' : '' }}"><i class="fas fa-book-open me-2"></i><span class="teacher-link-text">My Courses</span></a></li>
                <li class="nav-item"><a href="{{ route('teacher.assignments') }}" class="nav-link {{ request()->routeIs('teacher.assignments') ? 'active' : '' }}"><i class="fas fa-list-check me-2"></i><span class="teacher-link-text">Assignments</span></a></li>
                <li class="nav-item"><a href="{{ route('teacher.submissions') }}" class="nav-link {{ request()->routeIs('teacher.submissions') ? 'active' : '' }}"><i class="fas fa-file-lines me-2"></i><span class="teacher-link-text">Submissions</span></a></li>
                <li class="nav-item"><a href="{{ route('teacher.attendance') }}" class="nav-link {{ request()->routeIs('teacher.attendance') ? 'active' : '' }}"><i class="fas fa-calendar-check me-2"></i><span class="teacher-link-text">Attendance</span></a></li>
                <li class="nav-item"><a href="{{ route('teacher.exams') }}" class="nav-link {{ request()->routeIs('teacher.exams') ? 'active' : '' }}"><i class="fas fa-clipboard-list me-2"></i><span class="teacher-link-text">Exams</span></a></li>
            </ul>

            <div class="teacher-menu-group-title">Account</div>
            <ul class="teacher-menu-list nav flex-column">
                <li class="nav-item"><a href="{{ route('teacher.profile') }}" class="nav-link {{ request()->routeIs('teacher.profile') ? 'active' : '' }}"><i class="fas fa-user me-2"></i><span class="teacher-link-text">My Profile</span></a></li>
            </ul>

            <div class="mt-auto pt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100"><i class="fas fa-right-from-bracket me-1"></i>Logout</button>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="d-flex flex-column h-100">
        <div class="p-3 border-bottom border-light border-opacity-25">
            <div class="d-flex align-items-center gap-3">
                @if(!empty($teacher?->profile_image))
                    <img src="{{ asset('storage/' . $teacher->profile_image) }}" alt="Teacher" class="rounded-circle" style="width:44px;height:44px;object-fit:cover;">
                @else
                    <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width:44px;height:44px;font-size:.9rem;font-weight:700;">{{ $teacherInitials }}</span>
                @endif
                <div class="teacher-meta">
                    <div class="fw-semibold text-truncate teacher-label text-white">{{ $teacherName }}</div>
                    <small class="teacher-label text-info-emphasis">Teacher Account</small>
                </div>
            </div>
        </div>

        <div class="p-3">
            <div class="teacher-menu-group-title teacher-label">Main</div>
            <ul class="teacher-menu-list nav flex-column">
                <li class="nav-item"><a href="{{ route('teacher.dashboard') }}" class="nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Dashboard"><i class="fas fa-gauge-high me-2"></i><span class="teacher-link-text">Dashboard</span></a></li>
            </ul>

            <div class="teacher-menu-group-title teacher-label">Teaching</div>
            <ul class="teacher-menu-list nav flex-column">
                <li class="nav-item"><a href="{{ route('teacher.courses') }}" class="nav-link {{ request()->routeIs('teacher.courses') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="My Courses"><i class="fas fa-book-open me-2"></i><span class="teacher-link-text">My Courses</span></a></li>
                <li class="nav-item"><a href="{{ route('teacher.assignments') }}" class="nav-link {{ request()->routeIs('teacher.assignments') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Assignments"><i class="fas fa-list-check me-2"></i><span class="teacher-link-text">Assignments</span></a></li>
                <li class="nav-item"><a href="{{ route('teacher.submissions') }}" class="nav-link {{ request()->routeIs('teacher.submissions') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Submissions"><i class="fas fa-file-lines me-2"></i><span class="teacher-link-text">Submissions</span></a></li>
                <li class="nav-item"><a href="{{ route('teacher.attendance') }}" class="nav-link {{ request()->routeIs('teacher.attendance') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Attendance"><i class="fas fa-calendar-check me-2"></i><span class="teacher-link-text">Attendance</span></a></li>
                <li class="nav-item"><a href="{{ route('teacher.exams') }}" class="nav-link {{ request()->routeIs('teacher.exams') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Exams"><i class="fas fa-clipboard-list me-2"></i><span class="teacher-link-text">Exams</span></a></li>
            </ul>

            <div class="teacher-menu-group-title teacher-label">Account</div>
            <ul class="teacher-menu-list nav flex-column">
                <li class="nav-item"><a href="{{ route('teacher.profile') }}" class="nav-link {{ request()->routeIs('teacher.profile') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="My Profile"><i class="fas fa-user me-2"></i><span class="teacher-link-text">My Profile</span></a></li>
            </ul>
        </div>

        <div class="mt-auto p-3 teacher-sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Logout"><i class="fas fa-right-from-bracket me-1"></i><span class="teacher-link-text">Logout</span></button>
            </form>
        </div>
    </div>
@endif
