<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Editor Console') — {{ $platformName ?? 'UniGrowth' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --editor-sidebar-w: 260px; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh; display: flex;
        }
        .editor-sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--editor-sidebar-w); z-index: 1030;
            display: flex; flex-direction: column; overflow-y: auto;
            transition: transform 0.3s ease;
        }
        .editor-sidebar-brand { padding: 1.25rem 1.25rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .editor-sidebar-brand .brand-text { font-size: 1.15rem; font-weight: 700; color: #fff; letter-spacing: -0.02em; }
        .editor-sidebar-brand .brand-sub { font-size: 0.7rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.08em; margin-top: 2px; }
        .editor-sidebar-nav { flex: 1; padding: 0.75rem; }
        .editor-sidebar-nav .nav-section-label { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(255,255,255,0.3); padding: 1rem 0.75rem 0.35rem; }
        .editor-sidebar-nav .nav-link { display: flex; align-items: center; gap: 0.65rem; padding: 0.55rem 0.75rem; border-radius: 8px; color: rgba(255,255,255,0.65); font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: all 0.15s ease; margin-bottom: 2px; }
        .editor-sidebar-nav .nav-link i { font-size: 1.1rem; width: 20px; text-align: center; flex-shrink: 0; }
        .editor-sidebar-nav .nav-link:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .editor-sidebar-nav .nav-link.active { color: #fff; background: rgba(124,58,237,0.25); border-left: 3px solid #7c3aed; }
        .editor-sidebar-footer { padding: 0.75rem; border-top: 1px solid rgba(255,255,255,0.08); }
        .editor-sidebar-footer .nav-link { display: flex; align-items: center; gap: 0.65rem; padding: 0.55rem 0.75rem; border-radius: 8px; color: rgba(255,255,255,0.55); font-size: 0.8rem; text-decoration: none; transition: all 0.15s ease; }
        .editor-sidebar-footer .nav-link:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .editor-sidebar-footer .nav-link i { font-size: 1rem; width: 20px; text-align: center; }
        .editor-main { margin-left: var(--editor-sidebar-w); flex: 1; min-height: 100vh; display: flex; flex-direction: column; }
        .editor-topbar { padding: 0.75rem 1.5rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 1020; }
        .editor-content { flex: 1; padding: 1.5rem; }
        .sidebar-toggle { display: none; background: none; border: none; font-size: 1.3rem; cursor: pointer; padding: 0.25rem 0.5rem; border-radius: 6px; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 1025; }
        @media (max-width: 767.98px) {
            .editor-sidebar { transform: translateX(-100%); }
            .editor-sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .editor-main { margin-left: 0; }
            .sidebar-toggle { display: inline-flex; align-items: center; justify-content: center; }
            .editor-topbar { padding: 0.65rem 1rem; }
            .editor-content { padding: 1rem; }
        }
        @media (min-width: 768px) and (max-width: 991.98px) {
            .editor-sidebar { width: 220px; }
            .editor-main { margin-left: 220px; }
        }
.stat-card { border-radius: 12px; padding: 1.25rem; transition: all 0.2s ease; height: 100%; background: var(--bs-body-bg); border: 1px solid var(--bs-border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .stat-card .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; margin-bottom: 0.75rem; }
        .stat-card .stat-value { font-size: 1.5rem; font-weight: 700; line-height: 1.2; color: var(--bs-body-color); }
        .stat-card .stat-label { font-size: 0.8rem; font-weight: 500; margin-top: 0.2rem; color: var(--bs-secondary-color); }
        .content-card { border-radius: 12px; background: var(--bs-body-bg); border: 1px solid var(--bs-border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .content-card .card-header-custom { padding: 1rem 1.25rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; border-bottom: 1px solid var(--bs-border-color); }
        .content-card .card-header-custom h5 { font-size: 0.95rem; font-weight: 600; margin: 0; color: var(--bs-body-color); }
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
        .badge-status.suspended { background: #fef3c7; color: #92400e; }
        .badge-status.inactive { background: #f3f4f6; color: #6b7280; }
        .table-editor { font-size: 0.85rem; margin-bottom: 0; }
        .table-editor thead th { font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em; padding: 0.6rem 0.75rem; }
        .table-editor td { padding: 0.6rem 0.75rem; vertical-align: middle; }
        .table-editor .actions-cell { display: flex; gap: 0.35rem; flex-wrap: wrap; }
        .btn-editor-action { font-size: 0.7rem; font-weight: 600; padding: 0.25rem 0.6rem; border-radius: 6px; border: 1px solid transparent; transition: all 0.15s; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem; }
        .btn-editor-action i { font-size: 0.75rem; }
        .btn-editor-action.edit { background: #dbeafe; color: #1e40af; border-color: #93c5fd; }
        .btn-editor-action.edit:hover { background: #bfdbfe; }
        .btn-editor-action.delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
        .btn-editor-action.delete:hover { background: #fee2e2; }
        .btn-editor-action.view { background: #f3f4f6; color: #374151; border-color: #d1d5db; }
        .btn-editor-action.view:hover { background: #e5e7eb; }
        .btn-editor-action.create { background: #ede9fe; color: #6d28d9; border-color: #c4b5fd; }
        .btn-editor-action.create:hover { background: #ddd6fe; }
        .form-control-editor { font-size: 0.85rem; border-radius: 8px; padding: 0.45rem 0.75rem; }
        .form-label-editor { font-size: 0.8rem; font-weight: 600; margin-bottom: 0.3rem; }
        .alert-editor { border-radius: 10px; border: none; font-size: 0.85rem; padding: 0.75rem 1rem; }
        .search-input-group { max-width: 320px; }
        .search-input-group .form-control { font-size: 0.8rem; border-radius: 8px 0 0 8px; }
        .search-input-group .btn-search { font-size: 0.8rem; border-radius: 0 8px 8px 0; }
        .empty-state { padding: 2.5rem 1rem; text-align: center; }
        .empty-state i { font-size: 2.5rem; margin-bottom: 0.75rem; }
        .empty-state p { font-size: 0.9rem; margin-bottom: 0; }
        .modal-editor .modal-content { border-radius: 12px; border: none; }
        .modal-editor .modal-header { padding: 1rem 1.25rem; }
        .modal-editor .modal-body { padding: 1.25rem; }
        .modal-editor .modal-footer { padding: 0.75rem 1.25rem; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    <aside class="editor-sidebar" id="editorSidebar" data-bs-theme="dark" style="background: #0f0d2e;">
        <div class="editor-sidebar-brand">
            <div class="brand-text"><i class="bi bi-pencil-square me-2"></i>{{ $platformName ?? 'UniGrowth' }}</div>
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
        <div class="editor-topbar border-bottom bg-body">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" onclick="toggleSidebar()" aria-label="Toggle sidebar"><i class="bi bi-list"></i></button>
                <h1 class="page-title h5 fw-semibold mb-0 text-body-emphasis">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button id="themeToggle" class="btn btn-sm btn-outline-secondary rounded-2" title="Toggle theme">
                    <i class="bi bi-sun-fill" id="themeIcon"></i>
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-2 text-decoration-none"><i class="bi bi-box-arrow-up-right me-1"></i>Main Site</a>
                <form method="POST" action="{{ route('logout') }}" class="m-0">@csrf<button type="submit" class="btn btn-sm btn-outline-danger rounded-2"><i class="bi bi-box-arrow-right me-1"></i>Logout</button></form>
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
// Theme toggle using Bootstrap's data-bs-theme
        const html = document.documentElement;
        const themeIcon = document.getElementById('themeIcon');
        const editorDarkCssId = 'editor-dark-mode-css';
        const savedTheme = localStorage.getItem('editorTheme') || 'light';

        // Load the editor dark-mode stylesheet when dark is active
        function applyEditorDarkCss(theme) {
            let link = document.getElementById(editorDarkCssId);
            if (theme === 'dark') {
                if (!link) {
                    link = document.createElement('link');
                    link.id = editorDarkCssId;
                    link.rel = 'stylesheet';
                    link.href = '{{ asset('css/editor-dark-mode.css') }}';
                    document.head.appendChild(link);
                }
            } else if (link) {
                link.remove();
            }
        }

        html.setAttribute('data-bs-theme', savedTheme);
        applyEditorDarkCss(savedTheme);
        updateThemeIcon(savedTheme);
        document.getElementById('themeToggle').addEventListener('click', function() {
            const current = html.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', next);
            localStorage.setItem('editorTheme', next);
            applyEditorDarkCss(next);
            updateThemeIcon(next);
        });
        function updateThemeIcon(theme) {
            themeIcon.className = theme === 'dark' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
        }
    </script>
    @stack('scripts')
</body>
</html>
