@php
    $user = auth()->user();
    $name = $user?->name ?? 'Admin';
    $initials = strtoupper(substr($name, 0, 2));
    $pageTitle = trim($__env->yieldContent('page_title')) !== '' ? trim($__env->yieldContent('page_title')) : 'Admin Dashboard';
    $notifications = $user?->notifications?->take(6) ?? collect();
    $unreadCount = $user?->unreadNotifications?->count() ?? 0;
@endphp

<header class="admin-topbar d-flex align-items-center px-3 px-lg-4">
    <div class="d-flex align-items-center justify-content-between w-100">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-secondary btn-sm d-none d-lg-inline-flex" id="adminSidebarDesktopToggle" type="button" aria-label="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <button class="btn btn-outline-secondary btn-sm d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebarMobile" aria-controls="adminSidebarMobile">
                <i class="fas fa-bars"></i>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none fw-bold text-dark d-flex align-items-center gap-2">                <span class="d-none d-sm-inline">Admin Panel</span>
            </a>
            <span class="text-secondary d-none d-md-inline">/</span>
            <span class="fw-semibold d-none d-md-inline">{{ $pageTitle }}</span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
                <button class="btn btn-light border btn-sm position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    @if($unreadCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $unreadCount }}</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-end p-0" style="min-width: 300px;">
                    <div class="px-3 py-2 border-bottom fw-semibold">Notifications</div>
                    @forelse($notifications as $notification)
                        <div class="px-3 py-2 border-bottom small {{ $notification->read_at ? '' : 'fw-semibold bg-light' }}">
                            {{ $notification->data['message'] ?? 'No message' }}
                            <div class="text-muted mt-1">{{ optional($notification->created_at)->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="px-3 py-3 text-muted small">No notifications.</div>
                    @endforelse
                </div>
            </div>

            <div class="dropdown">
                <button class="btn btn-light border btn-sm d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width:30px;height:30px;font-size:.75rem;font-weight:700;">{{ $initials }}</span>
                    <span class="d-none d-md-inline">{{ $name }}</span>
                    <i class="fas fa-chevron-down small"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.users') }}"><i class="fas fa-users me-2"></i>Users</a></li>
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
</header>
