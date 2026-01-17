 <div class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <i class="fas fa-graduation-cap" style="color: var(--primary-color); font-size: 1.8rem;"></i>
                    <h2>Student Portal</h2>
                </div>

                <div class="student-profile-sidebar">
                    <div class="student-avatar">JS</div>
                    <div class="student-info-sidebar">
                        <h3>John Smith</h3>
                        <p><i class="fas fa-user-graduate"></i> Class 10 - Section A</p>
                        <p><i class="fas fa-id-card"></i> STU2023001</p>
                    </div>
                </div>

                <div class="sidebar-menu">
                    <a href="#" class="menu-item active" data-page="dashboard">
                        <i class="fas fa-tachometer-alt menu-icon"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                    <a href="#" class="menu-item" data-page="subjects">
                        <i class="fas fa-book-open menu-icon"></i>
                        <span class="menu-text">My Subjects</span>
                    </a>
                    <a href="#" class="menu-item" data-page="studyMaterials">
                        <i class="fas fa-video menu-icon"></i>
                        <span class="menu-text">Study Materials</span>
                    </a>
                    <a href="#" class="menu-item" data-page="assignments">
                        <i class="fas fa-tasks menu-icon"></i>
                        <span class="menu-text">Assignments</span>
                    </a>
                    <a href="#" class="menu-item" data-page="attendance">
                        <i class="fas fa-calendar-check menu-icon"></i>
                        <span class="menu-text">Attendance</span>
                    </a>
                    <a href="#" class="menu-item" data-page="results">
                        <i class="fas fa-chart-line menu-icon"></i>
                        <span class="menu-text">Results</span>
                    </a>
                    <a href="#" class="menu-item" data-page="profile">
                        <i class="fas fa-user menu-icon"></i>
                        <span class="menu-text">My Profile</span>
                    </a>
                </div>

                <div class="sidebar-footer">
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                    </form>
                    <button class="logout-btn"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Log Out</span>
                    </button>
                </div>
            </div>