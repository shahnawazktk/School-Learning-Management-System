<div class="header">
    <div class="header-left">
        <button class="toggle-sidebar" id="toggleSidebar" aria-label="Toggle Sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <div class="page-title">
            <h1>
                <i class="fas {{ $icon ?? 'fa-tachometer-alt' }}"></i>
                <span class="title-text">{{ $title ?? 'Parent Dashboard' }}</span>
            </h1>
        </div>
    </div>
    
    <div class="header-right">
        <!-- Search Bar -->
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Search..." id="globalSearch">
        </div>

        <!-- Notifications -->
        <div class="notification-wrapper">
            <button class="notification-btn" id="notificationBtn" aria-label="Notifications">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </button>
            
            <!-- Notifications Dropdown -->
            <div class="notification-dropdown" id="notificationDropdown">
                <div class="dropdown-header">
                    <h6>Notifications</h6>
                    <span class="mark-read">Mark all as read</span>
                </div>
                <div class="dropdown-body">
                    <a href="#" class="notification-item unread">
                        <div class="notification-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">Attendance marked for John</p>
                            <span class="notification-time">5 min ago</span>
                        </div>
                    </a>
                    <a href="#" class="notification-item unread">
                        <div class="notification-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">New assignment uploaded</p>
                            <span class="notification-time">1 hour ago</span>
                        </div>
                    </a>
                    <a href="#" class="notification-item">
                        <div class="notification-icon">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">Fee payment reminder</p>
                            <span class="notification-time">2 days ago</span>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer">
                    <a href="{{ route('parent.notifications') }}">View All Notifications</a>
                </div>
            </div>
        </div>

        <!-- User Profile Dropdown -->
        <div class="user-dropdown-wrapper">
            <div class="user-profile-header" id="userProfileBtn">
                <div class="user-avatar">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">Parent</span>
                </div>
                <i class="fas fa-chevron-down dropdown-arrow"></i>
            </div>

            <!-- Profile Dropdown -->
            <div class="profile-dropdown" id="profileDropdown">
                <a href="{{ route('parent.profile') }}" class="dropdown-item">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
                <a href="{{ route('parent.settings') }}" class="dropdown-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>
</div>