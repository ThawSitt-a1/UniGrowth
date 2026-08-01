<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Editor Console') — UniGrowth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --editor-sidebar-w: 260px;
            --editor-primary: #1e1b4b;
            --editor-primary-light: #3730a3;
            --editor-accent: #7c3aed;
            --editor-sidebar-bg: #0f0d2e;
            --editor-sidebar-hover: rgba(255,255,255,0.06);
            --editor-sidebar-active: rgba(124,58,237,0.2);
            --editor-body-bg: #f4f5f7;
            --editor-card-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --editor-card-hover-shadow: 0 10px 40px rgba(0,0,0,0.08), 0 2px 8px rgba(0,0,0,0.04);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--editor-body-bg);
            min-height: 100vh;
            display: flex;
        }
        .editor-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--editor-sidebar-w);
            background: var(--editor-sidebar-bg);
            z-index: 1030;
            display: flex; flex-direction: column;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }
        .editor-sidebar-brand {
            padding: 1.25rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .editor-sidebar-brand .brand-text {
            font-size: 1.15rem; font-weight: 700; color: #fff; letter-spacing: -0.02em;
        }
        .editor-sidebar-brand .brand-sub {
            font-size: 0.7rem; color: rgba(255,255,255,0.4);
            text-transform: uppercase; letter-spacing: 0.08em; margin-top: 2px;
        }
        .editor-sidebar-nav { flex: 1; padding: 0.75rem 0.75rem; }
        .editor-sidebar-nav .nav-section-label {
            font-size: 0.65rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.08em; color: rgba(255,255,255,0.3);
            padding: 1rem 0.75rem 0.35rem;
        }
        .editor-sidebar-nav .nav-link {
            display: flex; align-items: center; gap: 0.65rem;
            padding: 0.55rem 0.75rem; border-radius: 8px;
            color: rgba(255,255,255,0.65); font-size: 0.85rem; font-weight: 500;
            text-decoration: none; transition: all 0.15s ease; margin-bottom: 2px;
        }
        .editor-sidebar-nav .nav-link i { font-size: 1.1rem; width: 20px; text-align: center; flex-shrink: 0; }
        .editor-sidebar-nav .nav-link:hover { color: #fff; background: var(--editor-sidebar-hover); }
        .editor-sidebar-nav .nav-link.active {
            color: #fff; background: var(--editor-sidebar-active);
            border-left: 3px solid var(--editor-accent);
        }
        .editor-sidebar-footer { padding: 0.75rem; border-top: 1px solid rgba(255,255,255,0.06); }
        .editor-sidebar-footer .nav-link {
            display: flex; align-items: center; gap: 0.65rem;
            padding: 0.55rem 0.75rem; border-radius: 8px;
            color: rgba(255,255,255,0.55); font-size: 0.8rem;
            text-decoration: none; transition: all 0.15s ease;
        }
        .editor-sidebar-footer .nav-link:hover { color: #fff; background: var(--editor-sidebar-hover); }
        .editor-sidebar-footer .nav-link i { font-size: 1rem; width: 20px; text-align: center; }
        .editor-main {
            margin-left: var(--editor-sidebar-w); flex: 1;
            min-height: 100vh; display: flex; flex-direction: column;
        }
        .editor-topbar {
            background: #fff; border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 0.75rem 1.5rem; display: flex; align-items: center;
            justify-content: space-between; position: sticky; top: 0; z-index: 1020;
        }
        .editor-topbar .page-title { font-size: 1.1rem; font-weight: 600; color: #1a1a2e; }
        .editor-topbar .topbar-actions { display: flex; align-items: center; gap: 0.75rem; }
        .editor-topbar .topbar-actions .btn-main-site {
            font-size: 0.8rem; color: #6b7280; text-decoration: none;
            display: flex; align-items: center; gap: 0.35rem;
            padding: 0.35rem 0.75rem; border-radius: 6px; transition: all 0.15s;
        }
        .editor-topbar .topbar-actions .btn-main-site:hover { background: #f3f4f6; color: #374151; }
        .editor-topbar .topbar-actions .btn-logout-editor {
            font-size: 0.8rem; background: none; border: 1px solid #e5e7eb;
            color: #6b7280; padding: 0.35rem 0.75rem; border-radius: 6px;
            text-decoration: none; display: flex; align-items: center;
            gap: 0.35rem; transition: all 0.15s;
        }
        .editor-topbar .topbar-actions .btn-logout-editor:hover {
            background: #fef2f2; border-color: #fca5a5; color: #dc2626;
        }
        .editor-content { flex: 1; padding: 1.5rem; }
        .sidebar-toggle {
            display: none; background: none; border: none; font-size: 1.3rem;
            color: #374151; cursor: pointer; padding: 0.25rem 0.5rem; border-radius: 6px;
        }
        .sidebar-toggle:hover { background: #f3f4f6; }
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.4); z-index: 1025;
        }
        @media (max-width: 767.98px) {
            .editor-sidebar { transform: translateX(-100%); }
            .editor-sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .editor-main { margin-left: 0; }
            .sidebar-toggle { display: inline-flex; align-items: center; justify-content: center; }
            .editor-topbar { padding: 0.65rem 1rem; }
            .editor-topbar .page-title { font-size: 0.95rem; }
            .editor-content { padding: 1rem; }
        }
        @media (min-width: 768px) and (max-width: 991.98px) {
            .editor-sidebar { width: 220px; }
            .editor-main { margin-left: 220px; }
        }
        .stat-card {
            background: #fff; border-radius: 12px; border: 1px solid rgba(0,0,0,0.04);
            box-shadow: var(--editor-card-shadow); padding: 1.25rem;
            transition: all 0.2s ease; height: 100%;
        }
        .stat-card:hover { box-shadow: var(--editor-card-hover-shadow); transform: translateY(-2px); }
        .stat-card .stat-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem; margin-bottom: 0.75rem;
        }
        .stat-card .stat-value { font-size: 1.5rem; font-weight: 700; color: #1a1a2e; line-height: 1.2; }
        .stat-card .stat-label { font-size: 0.8rem; font-weight: 500; color: #6b7280; margin-top: 0.2rem; }
        .content-card {
            background: #fff; border-radius: 12px; border: 1px solid rgba(0,0,0,0.04);
            box-shadow: var(--editor-card-shadow);
        }
        .content-card .card-header-custom {
            padding: 1rem 1.25rem; border-bottom: 1px solid rgba(0,0,0,0.04);
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;
        }
        .content-card .card-header-custom h5 { font-size: 0.95rem; font-weight: 600; color: #1a1a2e; margin: 0; }
        .content-card .card-body-custom { padding: 1.25rem; }
        .badge-difficulty { font-size: 0.7rem; font-weight: 600; padding: 0.25em 0.65em; border-radius: 20px; }
        .badge-difficulty.easy { background: #d1fae5; color: #065f46; }
        .badge-difficulty.medium { background: #fef3c7; color: #b45309; }
        .badge-difficulty.hard { background: #fee2e2; color: #991b1b; }
        .badge-role { font-size: 0.7rem; font-weight: 600; padding: 0.25em 0.65em; border-radius: 20px; }
        .badge-role.user { background: #e0f2fe; color: #0369a1; }
        .badge-role.editor { background: #fef3c7; color: #b45309; }
        .badge-role.admin { background: #ede9fe; color: #6d28d9; }
        .badge-status { font-size: 0.7rem; font-weight: 600; padding: 0.25em 0.65em; border-radius: 20px; }
        .badge-status.active { background: #d1fae5; color: #065f46; }
        .badge-status.locked { background: #fee2e2; color: #991b1b; }
        .badge-status.inactive { background: #f3f4f6; color: #6b7280; }
        .table-editor { font-size: 0.85rem; margin-bottom: 0; }
        .table-editor thead th {
            font-weight: 600; font-size: 0.75rem; text-transform: uppercase;
            letter-spacing: 0.04em; color: #6b7280; background: #f9fafb;
            border-bottom: 1px solid #e5e7eb; padding: 0.6rem 0.75rem;
        }
        .table-editor td { padding: 0.6rem 0.75rem; vertical-align: middle; border-bottom: 1px solid #f3f4f6; }
        .table-editor tbody tr:hover { background: #f9fafb; }
        .table-editor .actions-cell { display: flex; gap: 0.35rem; flex-wrap: wrap; }
        .btn-editor-action {
            font-size: 0.7rem; font-weight: 600; padding: 0.25rem 0.6rem; border-radius: 6px;
            border: 1px solid transparent; transition: all 0.15s; cursor: pointer;
            text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;
        }
        .btn-editor-action i { font-size: 0.75rem; }
        .btn-editor-action.edit { background: #dbeafe; color: #1e40af; border-color: #93c5fd; }
        .btn-editor-action.edit:hover { background: #bfdbfe; }
        .btn-editor-action.delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
        .btn-editor-action.delete:hover { background: #fee2e2; }
        .btn-editor-action.view { background: #f3f4f6; color: #374151; border-color: #d1d5db; }
        .btn-editor-action.view:hover { background: #e5e7eb; }
        .btn-editor-action.create { background: #ede9fe; color: #6d28d9; border-color: #c4b5fd; }
        .btn-editor-action.create:hover { background: #ddd6fe; }
        .form-control-editor { font-size: 0.85rem; border-radius: 8px; border: 1px solid #d1d5db; padding: 0.45rem 0.75rem; transition: all 0.15s; }
        .form-control-editor:focus { border-color: var(--editor-accent); box-shadow: 0 0 0 3px rgba(124,58,237,0.1); }
        .form-label-editor { font-size: 0.8rem; font-weight: 600; color: #374151; margin-bottom: 0.3rem; }
        .alert-editor { border-radius: 10px; border: none; font-size: 0.85rem; padding: 0.75rem 1rem; }
        .search-input-group { max-width: 320px; }
        .search-input-group .form-control { font-size: 0.8rem; border-radius: 8px 0 0 8px; border: 1px solid #d1d5db; }
        .search-input-group .btn-search { font-size: 0.8rem; border-radius: 0 8px 8px 0; background: var(--editor-primary); color: #fff; border: 1px solid var(--editor-primary); }
        .search-input-group .btn-search:hover { background: var(--editor-primary-light); }
        .empty-state { padding: 2.5rem 1rem; text-align: center; color: #9ca3af; }
        .empty-state i { font-size: 2.5rem; margin-bottom: 0.75rem; }
        .empty-state p { font-size: 0.9rem; margin-bottom: 0; }
        .modal-editor .modal-content { border-radius: 12px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
        .modal-editor .modal-header { border-bottom: 1px solid #f3f4f6; padding: 1rem 1.25rem; }
        .modal-editor .modal-body { padding: 1.25rem; }
        .modal-editor .modal-footer { border-top: 1px solid #f3f4f6; padding: 0.75rem 1.25rem; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    <aside class="editor-sidebar" id="editorSidebar">
        <div class="editor-sidebar-brand">
            <div class="brand-text"><i class="bi bi-pencil-square me-2"></i>UniGrowth</div>
            <div class="brand-sub">Editor Console</div>
        </div>
        <nav class="editor-sidebar-nav">
            <div class="nav-section-label">Main</div>
            <a href="{{ route('editor.dashboard') }}" class="nav-link {{ request()->routeIs('editor.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i>Dashboard</a>
            <a href="{{ route('editor.skills.index') }}" class="nav-link {{ request()->routeIs('editor.skills.*') ? 'active' : '' }}"><i class="bi bi-book"></i>Skills</a>
            <a href="{{ route('editor.questions.index') }}" class="nav-link {{ request()->routeIs('editor.questions.*') ? 'active' : '' }}"><i class="bi bi-question-circle"></i>Questions</a>
            <a href="{{ route('editor.history.index') }}" class="nav-link {{ request()->routeIs('editor.history.*') ? 'active' : '' }}"><i class="bi bi-clock-history"></i>History</a>
            <a href="{{ route('editor.settings.index') }}" class="nav-link {{ request()->routeIs('editor.settings.*') ? 'active' : '' }}"><i class="bi bi-gear"></i>Settings</a>
        </nav>
        <div class="editor-sidebar-footer">
            <a href="{{ route('dashboard') }}" class="nav-link"><i class="bi bi-house-door"></i>Back to Main Site</a>
            <form method="POST" action="{{ route('logout') }}" class="m-0">@csrf<button type="submit" class="nav-link w-100 border-0 bg-transparent text-start"><i class="bi bi-box-arrow-right"></i>Logout</button></form>
        </div>
    </aside>
    <div class="editor-main">
        <div class="editor-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" onclick="toggleSidebar()" aria-label="Toggle sidebar"><i class="bi bi-list"></i></button>
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="topbar-actions">
                @include('partials.theme-toggle', [
                    'btnClasses' => 'btn btn-sm border',
                    'style' => 'background: #fff; color: #374151; border-color: #e5e7eb; border-radius: 6px;',
                ])
                <a href="{{ route('dashboard') }}" class="btn-main-site"><i class="bi bi-box-arrow-up-right"></i>Main Site</a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">@csrf<button type="submit" class="btn-logout-editor"><i class="bi bi-box-arrow-right"></i>Logout</button></form>
            </div>
        </div>
        <div class="editor-content">
            @if (session('success'))
                <div class="alert alert-success alert-editor d-flex align-items-center gap-2 mb-4" role="alert"><i class="bi bi-check-circle-fill flex-shrink-0"></i><span>{{ session('success') }}</span></div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-editor d-flex align-items-center gap-2 mb-4" role="alert"><i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i><span>{{ session('error') }}</span></div>
            @endif
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('editorSidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.getElementById('editorSidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('show');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
