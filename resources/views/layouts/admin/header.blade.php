<div class="header">
    <div class="header-left">
        <button class="toggle-sidebar" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="breadcrumb">
            <span>Admin Dashboard</span>
        </div>
    </div>

    <div class="header-right">
        <div class="notification-wrapper">
            <button class="notification-btn" id="notificationBtn">
                <i class="fas fa-bell"></i>

                @if (auth()->user()->unreadNotifications->count() > 0)
                    <span class="notification-badge">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </button>

            <div class="notification-dropdown" id="notificationDropdown">
                <ul>
                    @forelse(auth()->user()->notifications as $notification)
                        <li class="{{ $notification->read_at ? '' : 'unread' }}">
                            {{ $notification->data['message'] }}
                        </li>
                    @empty
                        <li>No notifications</li>
                    @endforelse
                </ul>
            </div>


        </div>

        <!-- User Profile Dropdown -->
        <div class="user-dropdown">
            <button class="user-dropdown-toggle" id="userDropdownToggle">
                <div class="user-avatar-small">AD</div>
                <span class="user-name">Admin User</span>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </button>

            <div class="user-dropdown-menu" id="userDropdownMenu">
                <div class="dropdown-header">
                    <div class="user-avatar-medium">AD</div>
                    <div class="user-info">
                        <h4>Admin User</h4>
                        <p>admin@school.com</p>
                    </div>
                </div>

                <div class="dropdown-divider"></div>

                <a href="{{ route('admin.profile') }}" class="dropdown-item">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>

                <a href="{{ route('admin.settings') }}" class="dropdown-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>

                <a href="{{ route('admin.users') }}" class="dropdown-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Account Security</span>
                </a>

                <div class="dropdown-divider"></div>

                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                </form>
                <a href="#" class="dropdown-item logout-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>{{ __('Log Out') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
