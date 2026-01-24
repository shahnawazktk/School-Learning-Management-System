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
=======
     <div class="sidebar-menu">
         <a href="{{ route('student.dashboard') }}" class="menu-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
             <i class="fas fa-tachometer-alt menu-icon"></i>
             <span class="menu-text">Dashboard</span>
         </a>
         <a href="{{ route('student.subjects') }}" class="menu-item {{ request()->routeIs('student.subjects') ? 'active' : '' }}">
             <i class="fas fa-book-open menu-icon"></i>
             <span class="menu-text">My Subjects</span>
         </a>
         <a href="{{ route('student.resources') }}" class="menu-item {{ request()->routeIs('student.resources') ? 'active' : '' }}">
             <i class="fas fa-video menu-icon"></i>
             <span class="menu-text">Study Materials</span>
         </a>
         <a href="{{ route('student.assignments') }}" class="menu-item {{ request()->routeIs('student.assignments') ? 'active' : '' }}">
             <i class="fas fa-tasks menu-icon"></i>
             <span class="menu-text">Assignments</span>
         </a>
         <a href="{{ route('student.attendance') }}" class="menu-item {{ request()->routeIs('student.attendance') ? 'active' : '' }}">
             <i class="fas fa-calendar-check menu-icon"></i>
             <span class="menu-text">Attendance</span>
         </a>
         <a href="{{ route('student.results') }}" class="menu-item {{ request()->routeIs('student.results') ? 'active' : '' }}">
             <i class="fas fa-chart-line menu-icon"></i>
             <span class="menu-text">Results</span>
         </a>
         <a href="{{ route('student.profile') }}" class="menu-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
             <i class="fas fa-user menu-icon"></i>
             <span class="menu-text">My Profile</span>
         </a>
     </div>
