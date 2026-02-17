@php
    $title = 'Student Dashboard';
    $icon = 'fas fa-gauge-high';

    if (request()->routeIs('student.dashboard')) { $title = 'Dashboard'; $icon = 'fas fa-gauge-high'; }
    elseif (request()->routeIs('student.subjects')) { $title = 'My Subjects'; $icon = 'fas fa-book-open'; }
    elseif (request()->routeIs('student.assignments')) { $title = 'Assignments'; $icon = 'fas fa-list-check'; }
    elseif (request()->routeIs('student.attendance')) { $title = 'Attendance'; $icon = 'fas fa-calendar-check'; }
    elseif (request()->routeIs('student.results')) { $title = 'Results'; $icon = 'fas fa-chart-line'; }
    elseif (request()->routeIs('student.resources')) { $title = 'Study Materials'; $icon = 'fas fa-photo-film'; }
    elseif (request()->routeIs('student.exams')) { $title = 'Exams'; $icon = 'fas fa-clipboard-list'; }
    elseif (request()->routeIs('student.profile')) { $title = 'My Profile'; $icon = 'fas fa-user'; }
@endphp

<header class="student-header px-3 px-lg-4 d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <button class="btn btn-light d-none d-lg-inline-flex border" id="desktopSidebarToggle" type="button" aria-label="Toggle sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <button class="btn btn-light d-inline-flex d-lg-none border" type="button" data-bs-toggle="offcanvas" data-bs-target="#studentSidebarOffcanvas" aria-controls="studentSidebarOffcanvas">
            <i class="fas fa-bars"></i>
        </button>
        <div>
            <div class="d-flex align-items-center gap-2">
                
                <h1 class="h5 mb-0 fw-semibold">{{ $title }}</h1>
            </div>
            
        </div>
    </div>

    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <a href="{{ route('student.profile') }}" class="text-decoration-none">
            <div class="d-flex align-items-center gap-2 p-1 pe-2 rounded border bg-white">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'ST', 0, 2)) }}
                </div>
                <div class="d-none d-md-block">
                    <div class="small fw-semibold text-dark lh-1">{{ Auth::user()->name ?? 'Student' }}</div>
                    <small class="text-muted">{{ $student->class ?? 'N/A' }} - {{ $student->section ?? 'N/A' }}</small>
                </div>
            </div>
        </a>
    </div>
</header>
