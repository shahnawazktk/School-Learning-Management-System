@php
    $isMobile = $mobile ?? false;
    $user = auth()->user();
    $name = $user?->name ?? 'Admin';
    $initials = strtoupper(substr($name, 0, 2));
@endphp

@if($isMobile)
    <div class="offcanvas offcanvas-start admin-offcanvas" tabindex="-1" id="adminSidebarMobile" aria-labelledby="adminSidebarMobileLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="adminSidebarMobileLabel">Smart Taleem Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-3">
            <div class="d-flex align-items-center gap-2 p-2 rounded bg-light mb-3">
                <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;font-weight:700;">{{ $initials }}</span>
                <div>
                    <div class="fw-semibold">{{ $name }}</div>
                    <small class="text-muted">Administrator</small>
                </div>
            </div>

            <div class="text-uppercase small fw-bold text-secondary mb-2">Main</div>
            <ul class="nav nav-pills flex-column gap-1 mb-3">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-dark' }}"><i class="fas fa-gauge-high me-2"></i>Dashboard</a></li>
            </ul>

            <div class="text-uppercase small fw-bold text-secondary mb-2">Management</div>
            <ul class="nav nav-pills flex-column gap-1 mb-3">
                <li class="nav-item"><a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : 'text-dark' }}"><i class="fas fa-school me-2"></i>School Info</a></li>
                <li class="nav-item"><a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : 'text-dark' }}"><i class="fas fa-users me-2"></i>Users & Access</a></li>
                <li class="nav-item"><a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : 'text-dark' }}"><i class="fas fa-sliders me-2"></i>Settings</a></li>
            </ul>

            <div class="text-uppercase small fw-bold text-secondary mb-2">Analytics</div>
            <ul class="nav nav-pills flex-column gap-1">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}#people-overview" class="nav-link text-dark"><i class="fas fa-users-viewfinder me-2"></i>People Snapshot</a></li>
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}#academic-overview" class="nav-link text-dark"><i class="fas fa-graduation-cap me-2"></i>Academic Ops</a></li>
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}#attendance-overview" class="nav-link text-dark"><i class="fas fa-chart-line me-2"></i>Attendance Trends</a></li>
            </ul>

            <div class="mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger w-100"><i class="fas fa-right-from-bracket me-1"></i>Logout</button>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="p-3 border-bottom border-light border-opacity-25">
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2 admin-brand">
            <img src="{{ asset('img/Smart-logo.png') }}" alt="Smart Taleem" style="width:38px;height:38px;object-fit:contain;">
            <h5 class="mb-0 text-white admin-label">Smart Taleem</h5>
        </a>
    </div>

    <div class="p-3 border-bottom border-light border-opacity-25">
        <div class="d-flex align-items-center gap-2">
            <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width:42px;height:42px;font-weight:700;">{{ $initials }}</span>
            <div class="admin-meta">
                <div class="text-white fw-semibold text-truncate">{{ $name }}</div>
                <small class="text-info">Administrator</small>
            </div>
        </div>
    </div>

    <div class="p-3 flex-grow-1">
        <div class="text-uppercase small fw-bold text-info mb-2 admin-label">Main</div>
        <ul class="nav flex-column gap-1 mb-3">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active text-white bg-primary bg-opacity-25 border border-primary-subtle' : 'text-light' }}">
                    <i class="fas fa-gauge-high me-2"></i><span class="admin-label">Dashboard</span>
                </a>
            </li>
        </ul>

        <div class="text-uppercase small fw-bold text-info mb-2 admin-label">Management</div>
        <ul class="nav flex-column gap-1 mb-3">
            <li class="nav-item">
                <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile') ? 'active text-white bg-primary bg-opacity-25 border border-primary-subtle' : 'text-light' }}">
                    <i class="fas fa-school me-2"></i><span class="admin-label">School Info</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active text-white bg-primary bg-opacity-25 border border-primary-subtle' : 'text-light' }}">
                    <i class="fas fa-users me-2"></i><span class="admin-label">Users & Access</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active text-white bg-primary bg-opacity-25 border border-primary-subtle' : 'text-light' }}">
                    <i class="fas fa-sliders me-2"></i><span class="admin-label">Settings</span>
                </a>
            </li>
        </ul>

        <div class="text-uppercase small fw-bold text-info mb-2 admin-label">Analytics</div>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}#people-overview" class="nav-link text-light">
                    <i class="fas fa-users-viewfinder me-2"></i><span class="admin-label">People Snapshot</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}#academic-overview" class="nav-link text-light">
                    <i class="fas fa-graduation-cap me-2"></i><span class="admin-label">Academic Ops</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}#attendance-overview" class="nav-link text-light">
                    <i class="fas fa-chart-line me-2"></i><span class="admin-label">Attendance Trends</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="p-3 border-top border-light border-opacity-25">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-danger w-100"><i class="fas fa-right-from-bracket me-1"></i><span class="admin-label">Logout</span></button>
        </form>
    </div>
@endif
