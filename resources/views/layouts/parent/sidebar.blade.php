 <div class="sidebar" id="sidebar">
     <div class="sidebar-header">
         <div class="logo-container">
             <a href="{{ route('dashboard') }}" class="logo-link">
                 <img src="{{ asset('img/Smart-logo.png') }}" alt="Smart School Logo" class="logo-img">
                 <h2>Parent Portal</h2>
             </a>
         </div>
     </div>

     <div class="parent-profile-sidebar">
         <div class="parent-avatar-sidebar">JD</div>
         <div class="parent-info-sidebar">
             <h3>John Doe</h3>
             <p><i class="fas fa-user"></i> Parent Account</p>
             <p><i class="fas fa-users"></i> 2 Children</p>
         </div>
     </div>

     <div class="sidebar-menu">
         <div class="menu-group">
             <div class="menu-group-title">DASHBOARD</div>
             <a href="#" class="menu-item active" data-page="dashboard">
                 <i class="fas fa-tachometer-alt menu-icon"></i>
                 <span class="menu-text">Dashboard</span>
             </a>
         </div>

         <div class="menu-group">
             <div class="menu-group-title">MY CHILDREN</div>
             <a href="#" class="menu-item" data-page="children">
                 <i class="fas fa-child menu-icon"></i>
                 <span class="menu-text">Children Profile</span>
             </a>
             <a href="#" class="menu-item" data-page="attendance">
                 <i class="fas fa-calendar-check menu-icon"></i>
                 <span class="menu-text">Attendance</span>
             </a>
             <a href="#" class="menu-item" data-page="grades">
                 <i class="fas fa-chart-line menu-icon"></i>
                 <span class="menu-text">Grades & Reports</span>
             </a>
         </div>

         <div class="menu-group">
             <div class="menu-group-title">SCHOOL</div>
             <a href="#" class="menu-item" data-page="schedule">
                 <i class="fas fa-clock menu-icon"></i>
                 <span class="menu-text">Class Schedule</span>
             </a>
             <a href="#" class="menu-item" data-page="homework">
                 <i class="fas fa-book menu-icon"></i>
                 <span class="menu-text">Homework</span>
             </a>
             <a href="#" class="menu-item" data-page="notices">
                 <i class="fas fa-bullhorn menu-icon"></i>
                 <span class="menu-text">Notices</span>
             </a>
         </div>

         <div class="menu-group">
             <div class="menu-group-title">FINANCE</div>
             <a href="#" class="menu-item" data-page="fees">
                 <i class="fas fa-file-invoice-dollar menu-icon"></i>
                 <span class="menu-text">Fee Status</span>
             </a>
             <a href="#" class="menu-item" data-page="payments">
                 <i class="fas fa-credit-card menu-icon"></i>
                 <span class="menu-text">Payment History</span>
             </a>
         </div>

         <div class="menu-group">
             <div class="menu-group-title">COMMUNICATION</div>
             <a href="#" class="menu-item" data-page="messages">
                 <i class="fas fa-comments menu-icon"></i>
                 <span class="menu-text">Messages</span>
             </a>
             <a href="#" class="menu-item" data-page="teachers">
                 <i class="fas fa-chalkboard-teacher menu-icon"></i>
                 <span class="menu-text">Teachers</span>
             </a>
         </div>
     </div>

     <div class="sidebar-footer">
         <form method="POST" action="{{ route('logout') }}" id="logout-form">
             @csrf
         </form>
         <button class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
             <i class="fas fa-sign-out-alt"></i>
             <span>Log Out</span>
         </button>
     </div>
 </div>
