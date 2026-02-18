<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Portal</title>
    <link rel="icon" href="{{ asset('img/smart-icon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --admin-sidebar-width: 280px;
            --admin-sidebar-collapsed: 88px;
            --admin-topbar-height: 64px;
            --admin-bg: #f1f5f9;
            --admin-surface: #ffffff;
            --admin-border: #e2e8f0;
            --admin-primary: #2563eb;
        }
        body {
            background:
                radial-gradient(circle at 0% 100%, rgba(59, 130, 246, 0.08), transparent 26%),
                radial-gradient(circle at 100% 0%, rgba(14, 165, 233, 0.1), transparent 24%),
                var(--admin-bg);
            color: #0f172a;
        }
        .admin-shell {
            min-height: 100vh;
        }
        .admin-sidebar {
            width: var(--admin-sidebar-width);
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 60%, #0f172a 100%);
            border-right: 1px solid rgba(148, 163, 184, 0.25);
            position: sticky;
            top: 0;
            height: 100vh;
            transition: width .2s ease;
            overflow-y: auto;
        }
        .admin-topbar {
            min-height: var(--admin-topbar-height);
            background: rgba(255, 255, 255, 0.9);
            border-bottom: 1px solid var(--admin-border);
            backdrop-filter: blur(8px);
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .admin-main {
            min-height: 100vh;
            width: calc(100% - var(--admin-sidebar-width));
            transition: width .2s ease;
        }
        .admin-content-wrap {
            max-width: 1680px;
            margin: 0 auto;
        }
        body.admin-sidebar-collapsed .admin-sidebar {
            width: var(--admin-sidebar-collapsed);
        }
        body.admin-sidebar-collapsed .admin-main {
            width: calc(100% - var(--admin-sidebar-collapsed));
        }
        body.admin-sidebar-collapsed .admin-sidebar .admin-label,
        body.admin-sidebar-collapsed .admin-sidebar .admin-meta {
            display: none !important;
        }
        body.admin-sidebar-collapsed .admin-sidebar .nav-link {
            justify-content: center;
        }
        body.admin-sidebar-collapsed .admin-sidebar .nav-link i {
            margin-right: 0 !important;
        }
        body.admin-sidebar-collapsed .admin-sidebar .admin-brand h5 {
            display: none;
        }
        .admin-card {
            border: 1px solid var(--admin-border);
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
        }
        .admin-sidebar .nav-link {
            border-radius: .6rem;
            border: 1px solid transparent;
            transition: all .17s ease;
            font-weight: 500;
        }
        .admin-sidebar .nav-link:hover {
            background: rgba(148, 163, 184, 0.2);
            border-color: rgba(148, 163, 184, 0.35);
        }
        .admin-sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }
        .admin-offcanvas {
            width: 290px !important;
        }
        @media (max-width: 991.98px) {
            .admin-main {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex admin-shell">
        <aside class="admin-sidebar d-none d-lg-flex flex-column" id="adminDesktopSidebar">
            @include('layouts.admin.sidebar', ['mobile' => false])
        </aside>

        <div class="admin-main flex-grow-1">
            @include('layouts.admin.header')
            <main class="p-3 p-lg-4">
                <div class="admin-content-wrap">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @include('layouts.admin.sidebar', ['mobile' => true])

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            const key = 'admin_sidebar_collapsed';
            const toggleBtn = document.getElementById('adminSidebarDesktopToggle');
            if (!toggleBtn) return;

            const apply = (collapsed) => {
                document.body.classList.toggle('admin-sidebar-collapsed', collapsed);
            };

            const read = () => {
                try {
                    return localStorage.getItem(key) === '1';
                } catch (e) {
                    return false;
                }
            };

            const write = (collapsed) => {
                try {
                    localStorage.setItem(key, collapsed ? '1' : '0');
                } catch (e) {
                    // Ignore storage errors.
                }
            };

            toggleBtn.addEventListener('click', () => {
                const collapsed = !document.body.classList.contains('admin-sidebar-collapsed');
                apply(collapsed);
                write(collapsed);
            });

            apply(read());
        })();
    </script>
</body>
</html>
