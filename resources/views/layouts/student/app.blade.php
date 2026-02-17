<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel | LMS</title>
    <link rel="icon" href="{{ asset('img/smart-icon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 92px;
            --header-height: 72px;
            --layout-bg: #f6f8fb;
            --surface: #ffffff;
            --border-color: #e9edf2;
            --text-muted: #667085;
            --brand: #0d6efd;
        }

        body {
            background: var(--layout-bg);
            color: #1d2939;
        }

        .student-shell {
            min-height: 100vh;
        }

        .student-sidebar {
            width: var(--sidebar-width);
            background: var(--surface);
            border-right: 1px solid var(--border-color);
            transition: width 0.2s ease;
            z-index: 1031;
            min-height: 100vh;
        }

        .main-shell {
            min-width: 0;
            width: 100%;
            transition: margin-left 0.2s ease;
        }

        .student-header {
            min-height: var(--header-height);
            background: var(--surface);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1029;
        }

        .student-content {
            min-width: 0;
        }

        .menu-link {
            color: #344054;
            border-radius: 10px;
            font-weight: 500;
            padding: 0.65rem 0.8rem;
            transition: all 0.15s ease;
            text-decoration: none !important;
        }

        .menu-link:hover {
            background: #eff4ff;
            color: #175cd3;
        }

        .menu-link.active {
            background: #e7f0ff;
            color: #175cd3;
            font-weight: 600;
        }

        .menu-link i {
            width: 1.25rem;
            text-align: center;
        }

        .student-badge {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        @media (min-width: 992px) {
            .student-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                overflow-y: auto;
            }

            .main-shell {
                margin-left: var(--sidebar-width);
                min-height: 100vh;
            }

            .student-shell.sidebar-collapsed .main-shell {
                margin-left: var(--sidebar-collapsed-width);
            }

            .student-shell.sidebar-collapsed .student-sidebar {
                width: var(--sidebar-collapsed-width);
            }

            .student-shell.sidebar-collapsed .sidebar-label,
            .student-shell.sidebar-collapsed .student-profile-meta,
            .student-shell.sidebar-collapsed .sidebar-brand-text {
                display: none !important;
            }

            .student-shell.sidebar-collapsed .menu-link {
                justify-content: center;
            }

            .student-shell.sidebar-collapsed .menu-link i {
                margin-right: 0 !important;
            }
        }

        #studentSidebarOffcanvas {
            width: min(84vw, 300px);
        }

        @media (max-width: 575.98px) {
            #studentSidebarOffcanvas {
                width: 92vw;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="student-shell d-flex" id="studentShell">
        @include('layouts.student.sidebar', ['mobile' => false])

        <div class="main-shell d-flex flex-column flex-grow-1">
            @include('layouts.student.header')

            <main class="student-content p-3 p-lg-4">
                @yield('content')
            </main>
        </div>
    </div>

    @include('layouts.student.sidebar', ['mobile' => true])

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const shell = document.getElementById('studentShell');
            const desktopToggle = document.getElementById('desktopSidebarToggle');
            const persisted = localStorage.getItem('student_sidebar_collapsed');

            if (persisted === '1') {
                shell.classList.add('sidebar-collapsed');
            }

            if (desktopToggle) {
                desktopToggle.addEventListener('click', function () {
                    shell.classList.toggle('sidebar-collapsed');
                    localStorage.setItem(
                        'student_sidebar_collapsed',
                        shell.classList.contains('sidebar-collapsed') ? '1' : '0'
                    );
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
