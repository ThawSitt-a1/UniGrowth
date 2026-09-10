<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Console') — {{ $platformName ?? 'UniGrowth' }}</title>
    @include('partials.preconnect')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script>
        (function() {
            const html = document.documentElement;
            const saved = localStorage.getItem('adminTheme');
            if (saved === 'dark') {
                html.setAttribute('data-bs-theme', 'dark');
            }
            html.classList.add('no-transition');
            window.addEventListener('load', function() {
                html.classList.remove('no-transition');
            });
        })();
    </script>
    <style>
        [data-bs-theme="dark"] body { background: #0f172a !important; }
        [data-bs-theme="dark"] .admin-main { background: #0f172a !important; }
        [data-bs-theme="dark"] .admin-topbar.bg-body { background-color: #1e293b !important; }
        [data-bs-theme="dark"] .content-card,
        [data-bs-theme="dark"] .stat-card { background: #1e293b !important; border-color: #334155 !important; }
        [data-bs-theme="dark"] .page-title { color: #f1f5f9 !important; }
        [data-bs-theme="dark"] .table-admin td,
        [data-bs-theme="dark"] .table-admin th { color: #e2e8f0 !important; }
        [data-bs-theme="dark"] .table-admin thead th { color: #94a3b8 !important; }
        [data-bs-theme="dark"] .text-muted { color: #94a3b8 !important; }
        [data-bs-theme="dark"] .text-dark { color: #f1f5f9 !important; }
        [data-bs-theme="dark"] .text-success { color: #6ee7b7 !important; }
        [data-bs-theme="dark"] [style*="color: #1a1a2e"] { color: #f1f5f9 !important; }
        [data-bs-theme="dark"] .page-title { color: #f1f5f9 !important; }
        [data-bs-theme="dark"] hr { border-color: #334155 !important; }
        [data-bs-theme="dark"] .empty-state i,
        [data-bs-theme="dark"] .empty-state p { color: #94a3b8 !important; }
        [data-bs-theme="dark"] .badge.bg-secondary { background-color: #334155 !important; color: #e2e8f0 !important; }
        [data-bs-theme="dark"] ::-webkit-scrollbar { width: 10px; height: 10px; }
        [data-bs-theme="dark"] ::-webkit-scrollbar-track { background: #0f172a; }
        [data-bs-theme="dark"] ::-webkit-scrollbar-thumb { background: #334155; border-radius: 6px; }
        [data-bs-theme="dark"] .stat-icon[style*="background: #ede9fe"],
        [data-bs-theme="dark"] [style*="background: #ede9fe"] { background-color: #2e1065 !important; }
        [data-bs-theme="dark"] .stat-icon[style*="color: #6d28d9"],
        [data-bs-theme="dark"] [style*="color: #6d28d9"] { color: #c4b5fd !important; }
        [data-bs-theme="dark"] .stat-icon[style*="background: #dbeafe"],
        [data-bs-theme="dark"] [style*="background: #dbeafe"] { background-color: #1e3a8a !important; }
        [data-bs-theme="dark"] .stat-icon[style*="color: #1e40af"],
        [data-bs-theme="dark"] [style*="color: #1e40af"] { color: #93c5fd !important; }
        [data-bs-theme="dark"] .stat-icon[style*="background: #fef3c7"],
        [data-bs-theme="dark"] [style*="background: #fef3c7"] { background-color: #78350f !important; }
        [data-bs-theme="dark"] .stat-icon[style*="color: #b45309"],
        [data-bs-theme="dark"] [style*="color: #b45309"] { color: #fcd34d !important; }
        [data-bs-theme="dark"] .stat-icon[style*="background: #fee2e2"],
        [data-bs-theme="dark"] [style*="background: #fee2e2"] { background-color: #7f1d1d !important; }
        [data-bs-theme="dark"] .stat-icon[style*="color: #dc2626"],
        [data-bs-theme="dark"] [style*="color: #dc2626"] { color: #fca5a5 !important; }
        [data-bs-theme="dark"] .stat-icon[style*="background: #ecfdf5"],
        [data-bs-theme="dark"] [style*="background: #ecfdf5"] { background-color: #064e3b !important; }
        [data-bs-theme="dark"] .stat-icon[style*="color: #059669"],
        [data-bs-theme="dark"] [style*="color: #059669"] { color: #6ee7b7 !important; }
        [data-bs-theme="dark"] .stat-icon[style*="background: #e0f2fe"],
        [data-bs-theme="dark"] [style*="background: #e0f2fe"] { background-color: #164e63 !important; }
        [data-bs-theme="dark"] .stat-icon[style*="color: #0369a1"],
        [data-bs-theme="dark"] [style*="color: #0369a1"] { color: #7dd3fc !important; }
        [data-bs-theme="dark"] .stat-icon[style*="background: #d1fae5"],
        [data-bs-theme="dark"] [style*="background: #d1fae5"] { background-color: #065f46 !important; }
        [data-bs-theme="dark"] .stat-icon[style*="color: #065f46"],
        [data-bs-theme="dark"] [style*="color: #065f46"] { color: #6ee7b7 !important; }
        [data-bs-theme="dark"] .badge-role.user { background: #164e63 !important; color: #7dd3fc !important; }
        [data-bs-theme="dark"] .badge-role.editor { background: #78350f !important; color: #fcd34d !important; }
        [data-bs-theme="dark"] .badge-role.admin { background: #2e1065 !important; color: #c4b5fd !important; }
        [data-bs-theme="dark"] .badge-status.allowed,
        [data-bs-theme="dark"] .badge-status.resolved { background: #064e3b !important; color: #6ee7b7 !important; }
        [data-bs-theme="dark"] .badge-status.banned { background: #7f1d1d !important; color: #fca5a5 !important; }
        [data-bs-theme="dark"] .badge-status.suspended,
        [data-bs-theme="dark"] .badge-status.pending { background: #78350f !important; color: #fcd34d !important; }
        [data-bs-theme="dark"] .badge-status.reviewed { background: #164e63 !important; color: #7dd3fc !important; }
        [data-bs-theme="dark"] .badge-status.in_progress { background: #1e3a8a !important; color: #93c5fd !important; }
        [data-bs-theme="dark"] .btn-admin-action { border-color: #334155 !important; }
        [data-bs-theme="dark"] .btn-admin-action.ban,
        [data-bs-theme="dark"] .btn-admin-action.delete { background: #7f1d1d !important; color: #fca5a5 !important; border-color: #991b1b !important; }
        [data-bs-theme="dark"] .btn-admin-action.ban:hover,
        [data-bs-theme="dark"] .btn-admin-action.delete:hover { background: #991b1b !important; border-color: #b91c1c !important; }
        [data-bs-theme="dark"] .btn-admin-action.suspend,
        [data-bs-theme="dark"] .btn-admin-action.demote { background: #78350f !important; color: #fcd34d !important; border-color: #92400e !important; }
        [data-bs-theme="dark"] .btn-admin-action.suspend:hover,
        [data-bs-theme="dark"] .btn-admin-action.demote:hover { background: #92400e !important; }
        [data-bs-theme="dark"] .btn-admin-action.promote,
        [data-bs-theme="dark"] .btn-admin-action.restore,
        [data-bs-theme="dark"] .btn-admin-action.complete { background: #064e3b !important; color: #6ee7b7 !important; border-color: #14532d !important; }
        [data-bs-theme="dark"] .btn-admin-action.promote:hover,
        [data-bs-theme="dark"] .btn-admin-action.restore:hover,
        [data-bs-theme="dark"] .btn-admin-action.complete:hover { background: #065f46 !important; }
        [data-bs-theme="dark"] .btn-admin-action.view { background: #273449 !important; color: #cbd5e1 !important; border-color: #334155 !important; }
        [data-bs-theme="dark"] .btn-admin-action.view:hover { background: #334155 !important; }
        [data-bs-theme="dark"] .btn-admin-action.edit { background: #1e3a8a !important; color: #93c5fd !important; border-color: #1e40af !important; }
        [data-bs-theme="dark"] .btn-admin-action.edit:hover { background: #1e40af !important; }
        [data-bs-theme="dark"] .season-badge.active { background: #064e3b !important; color: #6ee7b7 !important; }
        [data-bs-theme="dark"] .season-badge.inactive { background: #273449 !important; color: #94a3b8 !important; }
        [data-bs-theme="dark"] .bg-light { background-color: #1e293b !important; }
        [data-bs-theme="dark"] .bg-light.rounded-3 { border: 1px solid #334155; }
        [data-bs-theme="dark"] .form-check-input { background-color: #0f172a; border-color: #334155; }
        [data-bs-theme="dark"] .form-check-input:checked { background-color: #6366f1; border-color: #6366f1; }
        [data-bs-theme="dark"] .table-admin { --bs-table-color: #e2e8f0; --bs-table-border-color: #334155; }
        [data-bs-theme="dark"] .table-admin thead th { color: #94a3b8 !important; }
        [data-bs-theme="dark"] .table-admin td { color: #e2e8f0; }
        [data-bs-theme="dark"] .table-admin tbody tr:hover { background-color: #273449 !important; }
        [data-bs-theme="dark"] .modal-admin .modal-content { background-color: #1e293b !important; color: #e2e8f0; border: 1px solid #334155; }
        [data-bs-theme="dark"] .modal-admin .modal-header,
        [data-bs-theme="dark"] .modal-admin .modal-footer { border-color: #334155 !important; }
        [data-bs-theme="dark"] .modal-admin .modal-title { color: #f1f5f9 !important; }
        [data-bs-theme="dark"] .modal-admin .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
        [data-bs-theme="dark"] .form-control-admin,
        [data-bs-theme="dark"] .form-select.form-control-admin { background-color: #0f172a !important; color: #e2e8f0 !important; border-color: #334155 !important; }
        [data-bs-theme="dark"] .form-control-admin:focus,
        [data-bs-theme="dark"] .form-select.form-control-admin:focus { background-color: #0f172a !important; border-color: #6366f1 !important; }
        [data-bs-theme="dark"] .form-label-admin { color: #cbd5e1 !important; }
        [data-bs-theme="dark"] .btn-search { background-color: #273449 !important; border-color: #334155 !important; color: #cbd5e1 !important; }
        [data-bs-theme="dark"] .btn-search:hover { background-color: #6366f1 !important; border-color: #6366f1 !important; color: #fff !important; }
        [data-bs-theme="dark"] .admin-sidebar { background: #0b0a24 !important; }
        [data-bs-theme="dark"] .admin-sidebar-brand { border-bottom-color: rgba(255, 255, 255, 0.08); }
        [data-bs-theme="dark"] .admin-sidebar-nav .nav-link.active { background: rgba(124, 58, 237, 0.35); }
        [data-bs-theme="dark"] .content-card .card-header-custom { border-bottom-color: #334155 !important; }
        [data-bs-theme="dark"] .content-card .card-header-custom h5 { color: #f1f5f9 !important; }
        [data-bs-theme="dark"] .stat-card,
        [data-bs-theme="dark"] .content-card { background: #1e293b !important; border-color: #334155 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4) !important; }
        [data-bs-theme="dark"] .stat-card:hover,
        [data-bs-theme="dark"] .content-card:hover { box-shadow: 0 4px 16px rgba(99, 102, 241, 0.15) !important; border-color: rgba(99, 102, 241, 0.4) !important; }
        [data-bs-theme="dark"] .stat-value,
        [data-bs-theme="dark"] [style*="color: #1a1a2e"] { color: #f1f5f9 !important; }

        .no-transition,
        .no-transition * {
            transition: none !important;
        }
        :root {
            --admin-sidebar-w: 260px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
        }
        .admin-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--admin-sidebar-w);
            z-index: 1030;
            display: flex; flex-direction: column;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }
        .admin-sidebar-brand { padding: 1.25rem 1.25rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .admin-sidebar-brand .brand-text { font-size: 1.15rem; font-weight: 700; color: #fff; letter-spacing: -0.02em; }
        .admin-sidebar-brand .brand-sub { font-size: 0.7rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.08em; margin-top: 2px; }
        .admin-sidebar-nav { flex: 1; padding: 0.75rem; }
        .admin-sidebar-nav .nav-section-label {
            font-size: 0.65rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.08em; color: rgba(255,255,255,0.3);
            padding: 1rem 0.75rem 0.35rem;
        }
        .admin-sidebar-nav .nav-link {
            display: flex; align-items: center; gap: 0.65rem;
            padding: 0.55rem 0.75rem; border-radius: 8px;
            color: rgba(255,255,255,0.65); font-size: 0.85rem; font-weight: 500;
            text-decoration: none; transition: all 0.15s ease; margin-bottom: 2px;
        }
        .admin-sidebar-nav .nav-link i { font-size: 1.1rem; width: 20px; text-align: center; flex-shrink: 0; }
        .admin-sidebar-nav .nav-link:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .admin-sidebar-nav .nav-link.active { color: #fff; background: rgba(124,58,237,0.25); border-left: 3px solid #7c3aed; }
        .admin-sidebar-footer { padding: 0.75rem; border-top: 1px solid rgba(255,255,255,0.08); }
        .admin-sidebar-footer .nav-link {
            display: flex; align-items: center; gap: 0.65rem;
            padding: 0.55rem 0.75rem; border-radius: 8px;
            color: rgba(255,255,255,0.55); font-size: 0.8rem;
            text-decoration: none; transition: all 0.15s ease;
        }
        .admin-sidebar-footer .nav-link:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .admin-sidebar-footer .nav-link i { font-size: 1rem; width: 20px; text-align: center; }

        /* ===== Main Content ===== */
        .admin-main { margin-left: var(--admin-sidebar-w); flex: 1; min-height: 100vh; display: flex; flex-direction: column; }
        .admin-topbar {
            padding: 0.75rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 1020;
        }
        .admin-content { flex: 1; padding: 1.5rem; }

        /* ===== Toggle ===== */
        .sidebar-toggle {
            display: none; background: none; border: none; font-size: 1.3rem;
            cursor: pointer; padding: 0.25rem 0.5rem; border-radius: 6px;
        }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 1025; }

        /* ===== Responsive ===== */
        @media (max-width: 767.98px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .admin-main { margin-left: 0; }
            .sidebar-toggle { display: inline-flex; align-items: center; justify-content: center; }
            .admin-topbar { padding: 0.65rem 1rem; }
            .admin-content { padding: 1rem; }
            .admin-topbar .topbar-actions { gap: 0.35rem !important; }
            .table-admin .btn-admin-action { font-size: 0.65rem; padding: 0.2rem 0.45rem; }
            .table-admin .actions-cell { gap: 0.2rem; }
        }
        @media (min-width: 768px) and (max-width: 991.98px) {
            .admin-sidebar { width: 220px; }
            .admin-main { margin-left: 220px; }
        }

/* ===== Admin Components ===== */
        .stat-card {
            border-radius: 12px; padding: 1.25rem;
            transition: all 0.2s ease; height: 100%;
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .stat-card .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; margin-bottom: 0.75rem; }
        .stat-card .stat-value { font-size: 1.5rem; font-weight: 700; line-height: 1.2; color: var(--bs-body-color); }
        .stat-card .stat-label { font-size: 0.8rem; font-weight: 500; margin-top: 0.2rem; color: var(--bs-secondary-color); }
        .stat-trend { color: var(--bs-secondary-color) !important; }
        .content-card {
            border-radius: 12px;
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .content-card .card-header-custom { padding: 1rem 1.25rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; border-bottom: 1px solid var(--bs-border-color); }
        .content-card .card-header-custom h5 { font-size: 0.95rem; font-weight: 600; margin: 0; color: var(--bs-body-color); }
        .content-card .card-body-custom { padding: 1.25rem; }

        .badge-role { font-size: 0.7rem; font-weight: 600; padding: 0.25em 0.65em; border-radius: 20px; }
        .badge-role.user { background: #e0f2fe; color: #0369a1; }
        .badge-role.editor { background: #fef3c7; color: #b45309; }
        .badge-role.admin { background: #ede9fe; color: #6d28d9; }
        .badge-status { font-size: 0.7rem; font-weight: 600; padding: 0.25em 0.65em; border-radius: 20px; }
        .badge-status.allowed { background: #d1fae5; color: #065f46; }
        .badge-status.banned { background: #fee2e2; color: #991b1b; }
        .badge-status.suspended { background: #fef3c7; color: #92400e; }
        .badge-status.pending { background: #fef3c7; color: #92400e; }
        .badge-status.reviewed { background: #e0f2fe; color: #0369a1; }
        .badge-status.in_progress { background: #dbeafe; color: #1e40af; }
        .badge-status.resolved { background: #d1fae5; color: #065f46; }

        .table-admin { font-size: 0.85rem; margin-bottom: 0; }
        .table-admin thead th { font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em; padding: 0.6rem 0.75rem; }
        .table-admin td { padding: 0.6rem 0.75rem; vertical-align: middle; }
        .table-admin .actions-cell { display: flex; gap: 0.35rem; flex-wrap: wrap; }

        .btn-admin-action {
            font-size: 0.7rem; font-weight: 600; padding: 0.25rem 0.6rem; border-radius: 6px;
            border: 1px solid transparent; transition: all 0.15s; cursor: pointer;
            text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;
        }
        .btn-admin-action i { font-size: 0.75rem; }
        .btn-admin-action.ban { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
        .btn-admin-action.ban:hover { background: #fee2e2; border-color: #fca5a5; }
        .btn-admin-action.suspend { background: #fffbeb; color: #d97706; border-color: #fde68a; }
        .btn-admin-action.suspend:hover { background: #fef3c7; border-color: #fcd34d; }
        .btn-admin-action.promote { background: #ecfdf5; color: #059669; border-color: #a7f3d0; }
        .btn-admin-action.promote:hover { background: #d1fae5; border-color: #6ee7b7; }
        .btn-admin-action.demote { background: #fef3c7; color: #b45309; border-color: #fde68a; }
        .btn-admin-action.demote:hover { background: #fde68a; }
        .btn-admin-action.delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
        .btn-admin-action.delete:hover { background: #fee2e2; }
        .btn-admin-action.restore { background: #ecfdf5; color: #059669; border-color: #a7f3d0; }
        .btn-admin-action.restore:hover { background: #d1fae5; }
        .btn-admin-action.complete { background: #d1fae5; color: #065f46; border-color: #6ee7b7; }
        .btn-admin-action.complete:hover { background: #a7f3d0; }
        .btn-admin-action.view { background: #f3f4f6; color: #374151; border-color: #d1d5db; }
        .btn-admin-action.view:hover { background: #e5e7eb; }
        .btn-admin-action.edit { background: #dbeafe; color: #1e40af; border-color: #93c5fd; }
        .btn-admin-action.edit:hover { background: #bfdbfe; }

        .season-badge { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.7rem; font-weight: 600; padding: 0.25rem 0.75rem; border-radius: 20px; }
        .season-badge.active { background: #d1fae5; color: #065f46; }
        .season-badge.inactive { background: #f3f4f6; color: #6b7280; }

        .form-control-admin { font-size: 0.85rem; border-radius: 8px; padding: 0.45rem 0.75rem; }
        .form-label-admin { font-size: 0.8rem; font-weight: 600; margin-bottom: 0.3rem; }
        .alert-admin { border-radius: 10px; border: none; font-size: 0.85rem; padding: 0.75rem 1rem; }
        .search-input-group { max-width: 320px; }
        .search-input-group .form-control { font-size: 0.8rem; border-radius: 8px 0 0 8px; }
        .search-input-group .btn-search { font-size: 0.8rem; border-radius: 0 8px 8px 0; }

        .form-switch-admin .form-check-input { width: 2.5em; height: 1.3em; cursor: pointer; }
        .empty-state { padding: 2.5rem 1rem; text-align: center; }
        .empty-state i { font-size: 2.5rem; margin-bottom: 0.75rem; }
        .empty-state p { font-size: 0.9rem; margin-bottom: 0; }

        .modal-admin .modal-content { border-radius: 12px; border: none; }
        .modal-admin .modal-header { padding: 1rem 1.25rem; }
        .modal-admin .modal-body { padding: 1.25rem; }
        .modal-admin .modal-footer { padding: 0.75rem 1.25rem; }
    </style>
</head>
<body>
    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar (always dark) -->
    <aside class="admin-sidebar" id="adminSidebar" data-bs-theme="dark" style="background: #0f0d2e;">
        <div class="admin-sidebar-brand">
            <div class="brand-text"><i class="bi bi-shield-shaded me-2"></i>{{ $platformName ?? 'UniGrowth' }}</div>
            <div class="brand-sub">Admin Console</div>
        </div>
        <nav class="admin-sidebar-nav">
            <div class="nav-section-label">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') || request()->routeIs('admin.editors') ? 'active' : '' }}">
                <i class="bi bi-people"></i>Users & Editors
            </a>
            <a href="{{ route('admin.content') }}" class="nav-link {{ request()->routeIs('admin.content') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>Content
            </a>
            <a href="{{ route('admin.bug-reports') }}" class="nav-link {{ request()->routeIs('admin.bug-reports') ? 'active' : '' }}">
                <i class="bi bi-bug"></i>Bug Reports
            </a>
            <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>Settings
            </a>
        </nav>
        <div class="admin-sidebar-footer">
            <a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-house-door"></i>Back to Main Site</a>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start"><i class="bi bi-box-arrow-right"></i>Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Top Bar -->
        <div class="admin-topbar border-bottom bg-body d-flex flex-wrap align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="page-title h5 fw-semibold mb-0 text-body-emphasis">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap topbar-actions ms-auto">
                @if(isset($seasonStatus))
                    @if(!empty($seasonStatus['has_active_season']))
                        <span class="season-badge active"><i class="bi bi-fire"></i>{{ $seasonStatus['name'] ?? 'Active Season' }}</span>
                    @else
                        <span class="season-badge inactive"><i class="bi bi-snow"></i>No Active Season</span>
                    @endif
                @endif
                <button id="themeToggle" class="btn btn-sm btn-outline-secondary rounded-2" title="Toggle theme">
                    <i class="bi bi-sun-fill" id="themeIcon"></i>
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-2 text-decoration-none">
                    <i class="bi bi-box-arrow-up-right d-none d-sm-inline me-1"></i><span class="d-sm-none">Site</span><span class="d-none d-sm-inline">Main Site</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2">
                        <i class="bi bi-box-arrow-right d-none d-sm-inline me-1"></i><span class="d-sm-none">Out</span><span class="d-none d-sm-inline">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Flash Messages + Content -->
        <div class="admin-content">
            @if (session('success'))
                <div class="alert alert-success alert-admin d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill flex-shrink-0"></i><span>{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-admin d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i><span>{{ session('error') }}</span>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.getElementById('adminSidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('show');
            }
        });

// Theme toggle using Bootstrap's data-bs-theme
        const html = document.documentElement;
        const themeIcon = document.getElementById('themeIcon');
        const adminDarkCssId = 'admin-dark-mode-css';
        const savedTheme = localStorage.getItem('adminTheme') || 'light';

        // Load the admin dark-mode stylesheet when dark is active
        function applyAdminDarkCss(theme) {
            let link = document.getElementById(adminDarkCssId);
            if (theme === 'dark') {
                if (!link) {
                    link = document.createElement('link');
                    link.id = adminDarkCssId;
                    link.rel = 'stylesheet';
                    link.href = '{{ asset('css/admin-dark-mode.css') }}';
                    document.head.appendChild(link);
                }
            } else if (link) {
                link.remove();
            }
        }

        html.setAttribute('data-bs-theme', savedTheme);
        applyAdminDarkCss(savedTheme);
        updateThemeIcon(savedTheme);

        document.getElementById('themeToggle').addEventListener('click', function() {
            const current = html.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', next);
            localStorage.setItem('adminTheme', next);
            applyAdminDarkCss(next);
            updateThemeIcon(next);
        });

        function updateThemeIcon(theme) {
            themeIcon.className = theme === 'dark' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
        }
    </script>
    @stack('scripts')
</body>
</html>
