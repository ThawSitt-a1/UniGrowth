<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security - UniGrowth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @livewireStyles
    <style>
        /* ============================================================
           UniGrowth — Security Page Design System
           (Mirrors the token architecture from profile/index.blade.php)
           ============================================================ */

        /* === 1. PRIMITIVES (raw values — never change) === */
        :root {
            /* Neutrals */
            --slate-50:  #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #1f2937;
            --slate-800: #1e293b;
            --slate-850: #16203a;
            --slate-900: #0f172a;

            /* Brand indigo / violet */
            --indigo-100: #eef2ff;
            --indigo-200: #e0e7ff;
            --indigo-400: #818cf8;
            --indigo-500: #6366f1;
            --indigo-600: #4f46e5;
            --indigo-700: #4338ca;
            --indigo-900: #312e81;
            --violet-100: #faf5ff;
            --violet-500: #7c3aed;
            --violet-900: #2e1065;

            /* Feedback */
            --red-50:   #fef2f2;
            --red-200:  #fecaca;
            --red-300:  #fca5a5;
            --red-500:  #ef4444;
            --red-600:  #dc2626;
            --red-700:  #b91c1c;
            --red-800:  #991b1b;
            --red-900:  #7f1d1d;
            --amber-100: #fef3c7;
            --amber-500: #f59e0b;
            --amber-600: #d97706;
            --amber-800: #78350f;

            /* Spacing scale (4px base) */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;

            /* Radius */
            --radius-sm: 0.375rem;
            --radius-md: 0.625rem;
            --radius-lg: 1rem;
            --radius-full: 50%;

            /* Motion */
            --duration-fast: 0.15s;
            --duration-normal: 0.25s;
            --ease-out: cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* === 2. SEMANTIC (purpose aliases — theme-aware) === */
        :root {
            color-scheme: light;

            /* Backgrounds */
            --bg-body: var(--slate-50);
            --bg-card: #ffffff;
            --bg-elevated: var(--slate-50);
            --bg-subtle: var(--slate-100);
            --bg-input: #ffffff;
            --bg-hover: var(--indigo-100);

            /* Text */
            --text-strong: var(--slate-700);
            --text-body: var(--slate-600);
            --text-muted: var(--slate-400);
            --text-faint: var(--slate-500);

            /* Brand */
            --primary: var(--indigo-500);
            --primary-deep: var(--indigo-600);
            --primary-soft-bg: var(--indigo-100);
            --primary-soft-fg: var(--indigo-600);
            --gradient-brand: linear-gradient(135deg, var(--indigo-500), var(--violet-500));

            /* Surface borders */
            --border-default: var(--slate-200);
            --border-soft: rgba(0, 0, 0, 0.04);
            --border-brand: var(--indigo-200);

            /* Feedback semantic */
            --danger-bg: var(--red-50);
            --danger-border: var(--red-200);
            --danger-text: var(--red-700);
            --danger-soft-fg: var(--red-600);
            --danger-solid: var(--red-600);
            --warning-bg: var(--amber-100);
            --warning-fg: var(--amber-600);

            /* Shadows */
            --shadow-card: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-pop: 0 10px 40px rgba(15, 23, 42, 0.12);
            --shadow-brand: 0 6px 20px rgba(99, 102, 241, 0.28);
        }

        /* === DARK SEMANTIC OVERRIDES === */
        [data-bs-theme="dark"] {
            color-scheme: dark;

            --bg-body: var(--slate-900);
            --bg-card: var(--slate-800);
            --bg-elevated: #273449;
            --bg-subtle: var(--slate-850);
            --bg-input: var(--slate-900);
            --bg-hover: rgba(99, 102, 241, 0.12);

            --text-strong: var(--slate-100);
            --text-body: var(--slate-200);
            --text-muted: var(--slate-400);
            --text-faint: var(--slate-500);

            --primary: var(--indigo-400);
            --primary-deep: var(--indigo-500);
            --primary-soft-bg: rgba(99, 102, 241, 0.14);
            --primary-soft-fg: var(--indigo-400);

            --border-default: var(--slate-700);
            --border-soft: var(--slate-700);
            --border-brand: rgba(99, 102, 241, 0.4);

            --danger-bg: var(--red-900);
            --danger-border: var(--red-800);
            --danger-text: var(--red-300);
            --danger-soft-fg: var(--red-300);
            --danger-solid: var(--red-600);
            --warning-bg: var(--amber-800);
            --warning-fg: var(--amber-500);

            --shadow-card: 0 4px 24px rgba(0, 0, 0, 0.35);
            --shadow-pop: 0 20px 60px rgba(0, 0, 0, 0.5);
            --shadow-brand: 0 6px 24px rgba(99, 102, 241, 0.35);
        }

        /* === 3. COMPONENT (security page) === */
        :root {
            /* Cards */
            --card-bg: var(--bg-card);
            --card-border: var(--border-soft);
            --card-radius: var(--radius-lg);
            --card-shadow: var(--shadow-card);
            --card-padding: 1.75rem;

            /* Section icon chips */
            --icon-chip-bg: var(--primary-soft-bg);
            --icon-chip-color: var(--primary-soft-fg);

            /* Buttons */
            --btn-brand-bg: var(--gradient-brand);
            --btn-brand-color: #ffffff;
            --btn-brand-radius: var(--radius-md);

            /* Danger zone */
            --danger-card-bg: var(--danger-bg);
            --danger-card-border: var(--danger-border);
            --danger-card-title: var(--danger-text);
            --danger-item-text: var(--text-strong);
            --danger-divider: var(--danger-border);

            /* Form controls */
            --input-bg: var(--bg-input);
            --input-border: var(--border-default);
            --input-color: var(--text-body);
            --input-focus: var(--primary);
            --label-color: var(--text-strong);
        }

        /* ============================================================
           Base
           ============================================================ */
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-body);
            transition: background-color var(--duration-normal) var(--ease-out),
                        color var(--duration-normal) var(--ease-out);
        }

        /* ============================================================
           Top navigation (same brand gradient as profile pages)
           ============================================================ */
        .navbar-unigrowth {
            background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);
            box-shadow: 0 4px 24px rgba(30, 27, 75, 0.45);
        }
        .nav-link-custom {
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.875rem;
            font-weight: 500;
            padding: 6px 14px !important;
            border-radius: 8px;
            transition: all var(--duration-fast) var(--ease-out);
        }
        .nav-link-custom:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }
        .nav-link-custom i {
            margin-right: 6px;
            font-size: 0.9rem;
        }
        .avatar-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #fff;
            padding: 4px 10px 4px 4px;
            border-radius: 30px;
            transition: all var(--duration-fast) var(--ease-out);
        }
        .avatar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        .avatar-img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        .avatar-initial {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        /* ============================================================
           Section cards
           ============================================================ */
        .section-card {
            background-color: var(--card-bg);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            border: 1px solid var(--card-border);
            padding: var(--card-padding);
            margin-bottom: var(--space-6);
            transition: background-color var(--duration-normal) var(--ease-out),
                        border-color var(--duration-normal) var(--ease-out),
                        box-shadow var(--duration-normal) var(--ease-out);
        }
        .section-card h5 {
            font-weight: 700;
            color: var(--text-strong);
            margin-bottom: var(--space-5);
        }
        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-right: 12px;
            background: var(--icon-chip-bg);
            color: var(--icon-chip-color);
            flex-shrink: 0;
            transition: background-color var(--duration-normal) var(--ease-out);
        }

        /* ============================================================
           Buttons
           ============================================================ */
        .btn-brand-gradient {
            background: var(--btn-brand-bg);
            border: none;
            border-radius: var(--btn-brand-radius);
            padding: 8px 22px;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--btn-brand-color);
            transition: transform var(--duration-fast) var(--ease-out),
                        box-shadow var(--duration-fast) var(--ease-out);
        }
        .btn-brand-gradient:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-brand);
            color: #fff;
        }
        .btn-danger-soft {
            border: 2px solid var(--danger-border);
            color: var(--danger-text);
            border-radius: var(--btn-brand-radius);
            padding: 8px 22px;
            font-weight: 600;
            font-size: 0.85rem;
            background: transparent;
            transition: all var(--duration-fast) var(--ease-out);
        }
        .btn-danger-soft:hover {
            background: var(--danger-solid);
            border-color: var(--danger-solid);
            color: #fff;
        }
        .btn-delete-solid {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            border: none;
            border-radius: var(--btn-brand-radius);
            padding: 10px 28px;
            font-weight: 600;
            font-size: 0.9rem;
            color: #fff;
            transition: transform var(--duration-fast) var(--ease-out),
                        box-shadow var(--duration-fast) var(--ease-out);
        }
        .btn-delete-solid:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
            color: #fff;
        }
        .btn-delete-solid:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* ============================================================
           Danger zone
           ============================================================ */
        .danger-zone-card {
            background: var(--danger-card-bg);
            border: 1px solid var(--danger-card-border);
            border-radius: var(--card-radius);
            padding: var(--card-padding);
            transition: background-color var(--duration-normal) var(--ease-out),
                        border-color var(--duration-normal) var(--ease-out);
        }
        .danger-zone-card h5 {
            color: var(--danger-card-title);
        }
        .danger-item-title {
            color: var(--danger-item-text);
            font-weight: 600;
        }
        .danger-divider {
            border-color: var(--danger-divider) !important;
            opacity: 1;
        }

        /* ============================================================
           Delete account form specific
           ============================================================ */
        .delete-step {
            margin-bottom: var(--space-5);
        }
        .delete-step:last-child {
            margin-bottom: 0;
        }
        .delete-step-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }
        .delete-step-badge {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: #fff;
            background: var(--gradient-brand);
            flex-shrink: 0;
        }
        .delete-impact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 14px;
        }
        .impact-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-md);
            background: var(--bg-elevated);
            border: 1px solid var(--border-default);
        }
        .impact-item > i {
            font-size: 1.1rem;
            color: var(--danger-soft-fg);
            margin-top: 2px;
        }
        .delete-danger-note {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            padding: 12px 14px;
            border-radius: var(--radius-md);
            background: var(--danger-bg);
            border: 1px solid var(--danger-border);
            color: var(--danger-text);
            font-size: 0.85rem;
        }
        .delete-danger-note i {
            color: var(--danger-soft-fg);
            flex-shrink: 0;
            margin-top: 2px;
        }
        .delete-sep {
            border: none;
            border-top: 1px dashed var(--border-default);
            opacity: 1;
            margin: 1.25rem 0;
        }
        .delete-ack {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            border-radius: var(--radius-md);
            background: var(--bg-elevated);
            border: 1px solid var(--border-default);
        }
        .delete-ack .form-check-input {
            margin-top: 2px;
            flex-shrink: 0;
        }

        /* ============================================================
           Forms
           ============================================================ */
        .form-control, .form-select {
            background-color: var(--input-bg);
            border-color: var(--input-border);
            color: var(--input-color);
            border-radius: var(--radius-md);
            transition: background-color var(--duration-normal) var(--ease-out),
                        border-color var(--duration-normal) var(--ease-out),
                        box-shadow var(--duration-fast) var(--ease-out);
        }
        .form-control:focus, .form-select:focus {
            background-color: var(--input-bg);
            border-color: var(--input-focus);
            color: var(--input-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
        }
        .form-control::placeholder {
            color: var(--text-faint);
        }
        .form-label {
            color: var(--label-color);
        }

        /* ============================================================
           Alerts
           ============================================================ */
        .alert {
            border-radius: var(--radius-md);
        }

        /* ============================================================
           Responsive
           ============================================================ */
        @media (max-width: 575.98px) {
            .delete-impact-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

{{--
============================================================
TOP NAVIGATION BAR (Same as Profile pages)
============================================================
--}}
<nav class="navbar navbar-expand-lg sticky-top navbar-unigrowth">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="{{ route('dashboard') }}">
            <i class="bi bi-mortarboard-fill me-2"></i>UniGrowth
        </a>
        <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#securityNavMenu" style="color: rgba(255,255,255,0.7);">
            <i class="bi bi-list fs-4"></i>
        </button>
        <div class="collapse navbar-collapse" id="securityNavMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link nav-link-custom">
                        <i class="bi bi-house-door"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.show') }}" class="nav-link nav-link-custom">
                        <i class="bi bi-person-circle"></i>Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('core-assets.skills') }}" class="nav-link nav-link-custom">
                        <i class="bi bi-book"></i>Skills
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('assessment.test.index') }}" class="nav-link nav-link-custom">
                        <i class="bi bi-pencil-square"></i>Quiz
                    </a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                @include('partials.theme-toggle', [
                    'btnClasses' => 'btn btn-sm text-white border-0',
                    'style' => 'background: rgba(255,255,255,0.1); border-radius: 8px;',
                ])
                <a href="{{ route('profile.show') }}" class="avatar-link">
                    @php $user = auth()->user(); @endphp
                    @if (!empty($user->avatar_path))
                        <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="avatar" class="avatar-img">
                    @else
                        <span class="avatar-initial">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
                    @endif
                    <span class="d-none d-sm-inline small">{{ $user->username }}</span>
                </a>
                <form action="/logout" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm text-white border-0" style="background: rgba(255,255,255,0.1); border-radius: 8px;">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container py-5" style="max-width: 800px;">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: var(--text-strong);">
            <i class="bi bi-shield-lock me-2" style="color: var(--primary);"></i>Security Settings
        </h1>
        <a href="{{ route('profile.show') }}" class="back-link">
            <i class="bi bi-arrow-left me-1"></i>Back to Profile
        </a>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
            <i class="bi bi-check-circle-fill flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-info d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
            <i class="bi bi-info-circle-fill flex-shrink-0"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger py-3 px-4 mb-4 rounded-3 small" role="alert">
            <ul class="list-unstyled mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-triangle me-1"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Security Tip --}}
    <div class="section-card" style="background: linear-gradient(135deg, var(--indigo-100), var(--violet-100)); border: 1px solid rgba(99,102,241,0.15);">
        <div class="d-flex align-items-start gap-3">
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--indigo-500), var(--violet-500));">
                <i class="bi bi-shield-lock-fill fs-5 text-white"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-2" style="color: var(--text-strong);">
                    <i class="bi bi-lightbulb-fill me-1" style="color: var(--amber-600);"></i>Security Tip: Use a Password Manager
                </h5>
                <p class="text-secondary small mb-0" style="line-height: 1.7;">
                    Protect your accounts from credential theft by using a password manager.
                    It generates and stores unique, complex passwords for every site so you never
                    have to reuse or memorize them.
                </p>
            </div>
        </div>
    </div>

    {{-- Change Password --}}
    <div class="section-card">
        <div class="d-flex align-items-center mb-3">
            <div class="section-icon">
                <i class="bi bi-key"></i>
            </div>
            <h5 class="mb-0">Change Password</h5>
        </div>

        <form action="{{ route('profile.account.update') }}" method="POST" id="change-password-form">
            @csrf
            @method('PUT')
            <input type="hidden" name="action" value="change_password">

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="current_password" class="form-label fw-semibold small text-secondary">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required
                           class="form-control" autocomplete="current-password">
                </div>
                <div class="col-md-4">
                    <label for="new_password" class="form-label fw-semibold small text-secondary">New Password</label>
                    <input type="password" name="new_password" id="new_password" required minlength="12"
                           class="form-control" autocomplete="new-password">
                    <small class="text-muted">Minimum 12 characters.</small>
                </div>
                <div class="col-md-4">
                    <label for="new_password_confirmation" class="form-label fw-semibold small text-secondary">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                           class="form-control" autocomplete="new-password">
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-brand-gradient">
                    <i class="bi bi-check2-circle me-1"></i>Change Password
                </button>
            </div>
        </form>
    </div>

    {{-- Delete My Account --}}
    <div class="danger-zone-card">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-exclamation-triangle-fill fs-5" style="color: var(--danger-soft-fg);"></i>
            <h5 class="mb-0">⚠️ Danger Zone</h5>
        </div>

        <p class="text-secondary small mb-4">
            Deactivating your account will permanently delete your account and all associated data.
            This action is irreversible and you will not be able to log in or recover any data afterward.
        </p>
    </div>
</div>

@include('partials.footer')
</body>
</html>
