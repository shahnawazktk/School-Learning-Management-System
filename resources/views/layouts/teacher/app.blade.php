<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teacher Portal</title>
    <link rel="icon" href="{{ asset('img/smart-icon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --teacher-sidebar-width: 270px; }
        body { background-color: #f8fafc; color: #0f172a; }
        .teacher-sidebar {
            width: var(--teacher-sidebar-width);
            min-height: calc(100vh - 56px);
            border-right: 1px solid #e5e7eb;
            background: #fff;
            transition: width .22s ease;
        }
        .teacher-content {
            min-height: calc(100vh - 56px);
        }
        .teacher-layout-desktop .teacher-sidebar {
            position: sticky;
            top: 56px;
            max-height: calc(100vh - 56px);
            overflow-y: auto;
        }
        .teacher-topbar {
            background: rgba(255, 255, 255, .92);
            backdrop-filter: blur(8px);
        }
        .teacher-sidebar .nav-link {
            border-radius: .5rem;
            color: #374151;
            font-weight: 500;
            padding: .55rem .75rem;
        }
        .teacher-sidebar .nav-link:hover { background: #f3f4f6; }
        .teacher-sidebar .nav-link.active {
            background: #e0e7ff;
            color: #1d4ed8;
        }
        .teacher-menu-group-title {
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            font-weight: 700;
            color: #64748b;
            margin: .9rem 0 .35rem;
            padding: 0 .45rem;
        }
        .teacher-menu-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .teacher-menu-list .nav-item {
            margin-bottom: .2rem;
        }
        .teacher-layout-desktop .teacher-sidebar.is-collapsed {
            width: 78px;
        }
        .teacher-layout-desktop .teacher-sidebar.is-collapsed .teacher-meta,
        .teacher-layout-desktop .teacher-sidebar.is-collapsed .teacher-label {
            display: none !important;
        }
        .teacher-layout-desktop .teacher-sidebar.is-collapsed .nav-link {
            justify-content: center;
        }
        .teacher-layout-desktop .teacher-sidebar.is-collapsed .nav-link i {
            margin-right: 0 !important;
        }
        .teacher-layout-desktop .teacher-sidebar.is-collapsed .btn i {
            margin-right: 0 !important;
        }
        .teacher-brand {
            display: flex;
            align-items: center;
            gap: .65rem;
            text-decoration: none;
            color: #111827;
            font-weight: 700;
        }
        .teacher-brand img { width: 34px; height: 34px; object-fit: contain; }
    </style>
</head>
<body>
    @include('layouts.teacher.header')

    <div class="container-fluid px-0">
        <div class="d-flex teacher-layout-desktop">
            <aside class="teacher-sidebar d-none d-lg-block">
                @include('layouts.teacher.sidebar', ['mobile' => false])
            </aside>
            <main class="teacher-content flex-grow-1 p-3 p-lg-4">
                @yield('content')
            </main>
        </div>
    </div>

    @include('layouts.teacher.sidebar', ['mobile' => true])

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            const storageKey = 'teacher_sidebar_collapsed';
            const toggleBtn = document.getElementById('teacherDesktopSidebarToggle');
            const desktopSidebar = document.querySelector('.teacher-layout-desktop .teacher-sidebar');
            if (!desktopSidebar) return;

            const tooltipElements = desktopSidebar.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipInstances = Array.from(tooltipElements).map((el) => {
                return new bootstrap.Tooltip(el, { trigger: 'hover focus', container: 'body' });
            });

            const syncTooltipState = () => {
                const collapsed = desktopSidebar.classList.contains('is-collapsed');
                tooltipInstances.forEach((instance) => {
                    if (collapsed) {
                        instance.enable();
                    } else {
                        instance.hide();
                        instance.disable();
                    }
                });
            };

            const applyCollapsedState = (collapsed) => {
                desktopSidebar.classList.toggle('is-collapsed', collapsed);
                syncTooltipState();
            };

            const readStoredState = () => {
                try {
                    return localStorage.getItem(storageKey) === '1';
                } catch (e) {
                    return false;
                }
            };

            const writeStoredState = (collapsed) => {
                try {
                    localStorage.setItem(storageKey, collapsed ? '1' : '0');
                } catch (e) {
                    // Ignore storage errors in restricted contexts.
                }
            };

            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    const collapsed = !desktopSidebar.classList.contains('is-collapsed');
                    applyCollapsedState(collapsed);
                    writeStoredState(collapsed);
                });
            }

            applyCollapsedState(readStoredState());
        })();
    </script>
</body>
</html>
