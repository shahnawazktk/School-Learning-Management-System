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
        :root {
            --teacher-topbar-height: 64px;
            --teacher-sidebar-width: 286px;
            --teacher-sidebar-collapsed: 86px;
            --teacher-bg: #f1f5f9;
            --teacher-surface: #ffffff;
            --teacher-border: #e2e8f0;
            --teacher-text: #0f172a;
            --teacher-muted: #64748b;
            --teacher-primary: #2563eb;
            --teacher-primary-soft: #dbeafe;
            --teacher-sidebar-grad-start: #0f172a;
            --teacher-sidebar-grad-end: #1e293b;
        }
        body {
            background:
                radial-gradient(circle at 100% 0%, rgba(37, 99, 235, 0.09), transparent 28%),
                radial-gradient(circle at 0% 100%, rgba(14, 165, 233, 0.08), transparent 24%),
                var(--teacher-bg);
            color: var(--teacher-text);
        }
        .teacher-shell {
            min-height: calc(100vh - var(--teacher-topbar-height));
        }
        .teacher-sidebar {
            width: var(--teacher-sidebar-width);
            min-height: calc(100vh - var(--teacher-topbar-height));
            border-right: 1px solid rgba(148, 163, 184, 0.22);
            background: linear-gradient(180deg, var(--teacher-sidebar-grad-start), var(--teacher-sidebar-grad-end));
            transition: width .2s ease;
        }
        .teacher-content {
            min-height: calc(100vh - var(--teacher-topbar-height));
            max-width: 1650px;
            margin: 0 auto;
        }
        .teacher-layout-desktop .teacher-sidebar {
            position: sticky;
            top: var(--teacher-topbar-height);
            max-height: calc(100vh - var(--teacher-topbar-height));
            overflow-y: auto;
        }
        .teacher-topbar {
            min-height: var(--teacher-topbar-height);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--teacher-border);
        }
        .teacher-sidebar .nav-link {
            border-radius: .65rem;
            color: rgba(226, 232, 240, 0.88);
            font-weight: 500;
            padding: .62rem .8rem;
            border: 1px solid transparent;
            transition: all .17s ease;
        }
        .teacher-sidebar .nav-link i {
            width: 20px;
            text-align: center;
            color: #93c5fd;
        }
        .teacher-sidebar .nav-link:hover {
            background: rgba(148, 163, 184, 0.18);
            color: #fff;
            border-color: rgba(148, 163, 184, 0.3);
        }
        .teacher-sidebar .nav-link.active {
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.34), rgba(56, 189, 248, 0.18));
            color: #fff;
            border-color: rgba(96, 165, 250, 0.35);
        }
        .teacher-menu-group-title {
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            font-weight: 700;
            color: #93c5fd;
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
            width: var(--teacher-sidebar-collapsed);
        }
        .teacher-layout-desktop .teacher-sidebar.is-collapsed .teacher-meta,
        .teacher-layout-desktop .teacher-sidebar.is-collapsed .teacher-label,
        .teacher-layout-desktop .teacher-sidebar.is-collapsed .teacher-link-text {
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
            color: #0f172a;
            font-weight: 700;
        }
        .teacher-brand img { width: 34px; height: 34px; object-fit: contain; }
        .teacher-quick-btn {
            width: 34px;
            height: 34px;
            border-radius: .6rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #334155;
            border: 1px solid var(--teacher-border);
            background: #fff;
        }
        .teacher-quick-btn:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
        }
        .teacher-sidebar-footer {
            background: rgba(2, 6, 23, 0.2);
            border-top: 1px solid rgba(148, 163, 184, 0.2);
        }
        .teacher-mobile-sidebar .teacher-menu-group-title {
            color: var(--teacher-muted);
        }
        .teacher-mobile-sidebar .nav-link {
            color: #334155;
            border-radius: .6rem;
        }
        .teacher-mobile-sidebar .nav-link:hover {
            background: #f1f5f9;
        }
        .teacher-mobile-sidebar .nav-link.active {
            color: var(--teacher-primary);
            background: var(--teacher-primary-soft);
        }
        .teacher-sidebar .btn-outline-danger {
            color: #fecaca;
            border-color: rgba(239, 68, 68, 0.55);
        }
        .teacher-sidebar .btn-outline-danger:hover {
            color: #fff;
            background: rgba(239, 68, 68, 0.9);
            border-color: transparent;
        }
    </style>
</head>
<body>
    @include('layouts.teacher.header')

    <div class="container-fluid px-0">
        <div class="d-flex teacher-layout-desktop teacher-shell">
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
