@php
    $user = auth()->user();
    $teacher = $user?->teacher;
    $teacherName = $user->name ?? 'Teacher';
    $teacherInitials = strtoupper(substr($teacherName, 0, 2));
    $pageTitle = trim($__env->yieldContent('page_title')) !== '' ? trim($__env->yieldContent('page_title')) : 'Teacher Dashboard';
@endphp

<nav class="navbar navbar-expand-lg sticky-top teacher-topbar" style="z-index:1040;">
    <div class="container-fluid">
        <div class="d-flex align-items-center gap-2">
            <button id="teacherDesktopSidebarToggle" class="btn btn-sm btn-outline-secondary d-none d-lg-inline-flex" type="button" aria-label="Toggle sidebar" title="Toggle Sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <button class="btn btn-sm btn-outline-secondary d-inline-flex d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#teacherSidebarOffcanvas" aria-controls="teacherSidebarOffcanvas">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{ route('teacher.dashboard') }}" class="teacher-brand">
                <img src="{{ asset('img/Smart-logo.png') }}" alt="Logo">
                <span class="d-none d-sm-inline">Smart LMS</span>
            </a>
            <div class="ms-2 ps-2 border-start d-none d-md-block">
                <div class="small text-secondary mb-0">Teacher Panel</div>
                <h1 class="h6 mb-0 fw-semibold">{{ $pageTitle }}</h1>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-lg-flex align-items-center gap-2">
                <a href="{{ route('teacher.courses') }}" class="teacher-quick-btn text-decoration-none" title="Courses">
                    <i class="fas fa-book-open"></i>
                </a>
                <a href="{{ route('teacher.submissions') }}" class="teacher-quick-btn text-decoration-none" title="Submissions">
                    <i class="fas fa-file-lines"></i>
                </a>
            </div>
            <div class="dropdown">
                <button class="btn btn-sm btn-light border d-flex align-items-center gap-2 rounded-3 px-2 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(!empty($teacher?->profile_image))
                        <img src="{{ asset('storage/' . $teacher->profile_image) }}" alt="Teacher" class="rounded-circle" style="width:30px;height:30px;object-fit:cover;">
                    @else
                        <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width:30px;height:30px;font-size:.75rem;font-weight:700;">
                            {{ $teacherInitials }}
                        </span>
                    @endif
                    <span class="d-none d-md-inline">{{ $teacherName }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('teacher.profile') }}"><i class="fas fa-user me-2"></i>My Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('teacher.dashboard') }}"><i class="fas fa-gauge-high me-2"></i>Dashboard</a></li>
                    <li><a class="dropdown-item" href="{{ route('teacher.courses') }}"><i class="fas fa-book-open me-2"></i>Courses</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-right-from-bracket me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
