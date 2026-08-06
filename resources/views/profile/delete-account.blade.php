<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account - UniGrowth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* ============================================================
           UniGrowth — Delete Account Wizard Design System
           ============================================================ */

        /* === 1. PRIMITIVES === */
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

        /* === 2. SEMANTIC === */
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

        /* === 3. COMPONENT (Delete Account Wizard) === */
        :root {
            /* Cards */
            --card-bg: var(--bg-card);
            --card-border: var(--border-soft);
            --card-radius: var(--radius-lg);
            --card-shadow: var(--shadow-card);
            --card-padding: 2rem;

            /* Wizard */
            --wizard-bg: var(--bg-card);
            --wizard-border: var(--border-default);
            --step-active-bg: var(--primary-soft-bg);
            --step-active-color: var(--primary-soft-fg);
            --step-completed-bg: var(--primary);
            --step-completed-color: #fff;

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
           Top navigation
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
           Wizard Container
           ============================================================ */
        .wizard-container {
            background: var(--wizard-bg);
            border: 1px solid var(--wizard-border);
            border-radius: var(--card-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        /* ============================================================
           Progress Steps Indicator
           ============================================================ */
        .wizard-progress {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 2rem 2rem 1.5rem;
            background: linear-gradient(135deg, var(--indigo-100), var(--violet-100));
            border-bottom: 1px solid var(--border-default);
        }
        .wizard-step-indicator {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex: 1;
        }
        .wizard-step-indicator:not(:last-child)::after {
            content: '';
            flex: 1;
            height: 2px;
            background: var(--border-default);
            margin: 0 0.5rem;
            transition: background var(--duration-normal) var(--ease-out);
        }
        .wizard-step-indicator.completed:not(:last-child)::after {
            background: var(--primary);
        }
        .step-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
            background: var(--bg-card);
            color: var(--text-muted);
            border: 2px solid var(--border-default);
            transition: all var(--duration-normal) var(--ease-out);
        }
        .wizard-step-indicator.active .step-circle {
            background: var(--gradient-brand);
            color: #fff;
            border-color: transparent;
            box-shadow: var(--shadow-brand);
        }
        .wizard-step-indicator.completed .step-circle {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }
        .step-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            white-space: nowrap;
            transition: color var(--duration-normal) var(--ease-out);
        }
        .wizard-step-indicator.active .step-label {
            color: var(--text-strong);
        }
        .wizard-step-indicator.completed .step-label {
            color: var(--primary);
        }

        /* ============================================================
           Wizard Content
           ============================================================ */
        .wizard-content {
            padding: 2rem;
            min-height: 400px;
        }
        .wizard-step {
            display: none;
            animation: fadeIn 0.4s var(--ease-out);
        }
        .wizard-step.active {
            display: block;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============================================================
           Step Content Styling
           ============================================================ */
        .step-header {
            margin-bottom: 1.5rem;
        }
        .step-header h3 {
            font-weight: 700;
            color: var(--text-strong);
            margin-bottom: 0.5rem;
        }
        .step-header p {
            color: var(--text-muted);
            margin: 0;
        }

        /* Impact Grid */
        .impact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .impact-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem;
            border-radius: var(--radius-md);
            background: var(--bg-elevated);
            border: 1px solid var(--border-default);
            transition: all var(--duration-fast) var(--ease-out);
        }
        .impact-item:hover {
            border-color: var(--danger-border);
            background: var(--danger-bg);
        }
        .impact-item > i {
            font-size: 1.25rem;
            color: var(--danger-soft-fg);
            margin-top: 2px;
            flex-shrink: 0;
        }
        .impact-item-content {
            flex: 1;
        }
        .impact-item-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-strong);
            margin-bottom: 0.25rem;
        }
        .impact-item-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin: 0;
        }

        /* Danger Note */
        .danger-note {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem;
            border-radius: var(--radius-md);
            background: var(--danger-bg);
            border: 1px solid var(--danger-border);
            color: var(--danger-text);
        }
        .danger-note i {
            font-size: 1.25rem;
            color: var(--danger-soft-fg);
            flex-shrink: 0;
            margin-top: 2px;
        }
        .danger-note strong {
            color: var(--danger-text);
        }

        /* Acknowledgment */
        .acknowledgment {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem;
            border-radius: var(--radius-md);
            background: var(--bg-elevated);
            border: 1px solid var(--border-default);
        }
        .acknowledgment .form-check-input {
            margin-top: 2px;
            flex-shrink: 0;
        }
        .acknowledgment .form-check-label {
            color: var(--text-strong);
            font-size: 0.9rem;
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
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .form-text {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* ============================================================
           Buttons
           ============================================================ */
        .btn-brand-gradient {
            background: var(--btn-brand-bg);
            border: none;
            border-radius: var(--btn-brand-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--btn-brand-color);
            transition: transform var(--duration-fast) var(--ease-out),
                        box-shadow var(--duration-fast) var(--ease-out);
        }
        .btn-brand-gradient:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-brand);
            color: #fff;
        }
        .btn-brand-gradient:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .btn-outline-custom {
            border: 2px solid var(--border-default);
            color: var(--text-strong);
            border-radius: var(--btn-brand-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            background: transparent;
            transition: all var(--duration-fast) var(--ease-out);
        }
        .btn-outline-custom:hover {
            background: var(--bg-elevated);
            border-color: var(--text-muted);
            color: var(--text-strong);
        }
        .btn-delete-solid {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            border: none;
            border-radius: var(--btn-brand-radius);
            padding: 0.75rem 1.5rem;
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
           Wizard Footer
           ============================================================ */
        .wizard-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: var(--bg-elevated);
            border-top: 1px solid var(--border-default);
        }
        .wizard-footer .btn-group {
            gap: 0.75rem;
        }

        /* ============================================================
           Responsive
           ============================================================ */
        @media (max-width: 575.98px) {
            .wizard-progress {
                padding: 1.5rem 1rem 1rem;
            }
            .step-label {
                display: none;
            }
            .wizard-content {
                padding: 1.5rem;
            }
            .wizard-footer {
                padding: 1rem 1.5rem;
                flex-direction: column;
                gap: 0.75rem;
            }
            .wizard-footer .btn-group {
                width: 100%;
                flex-direction: column;
            }
            .wizard-footer .btn-group .btn {
                width: 100%;
            }
            .impact-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    {{-- Top Navigation Bar --}}
    <nav class="navbar navbar-expand-lg sticky-top navbar-unigrowth">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="{{ route('dashboard') }}">
                <i class="bi bi-mortarboard-fill me-2"></i>UniGrowth
            </a>
            <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#deleteNavMenu" style="color: rgba(255,255,255,0.7);">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="deleteNavMenu">
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

    <div class="container py-5" style="max-width: 900px;">
        {{-- Header --}}
        <div class="mb-4">
            <h1 class="fw-bold mb-2" style="color: var(--text-strong);">
                <i class="bi bi-trash3 me-2" style="color: var(--danger-solid);"></i>Delete My Account
            </h1>
            <p class="text-muted">This process will guide you through account deletion. Please read each step carefully.</p>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
                <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger py-3 px-4 mb-4 rounded-3 small" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <span>{{ session('error') }}</span>
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

        {{-- Wizard Form --}}
        <form action="{{ route('profile.account.update') }}" method="POST" id="delete-account-wizard">
            @csrf
            @method('PUT')
            <input type="hidden" name="action" value="deactivate">

            <div class="wizard-container">
                {{-- Progress Steps --}}
                <div class="wizard-progress">
                    <div class="wizard-step-indicator active" data-step="1">
                        <div class="step-circle">1</div>
                        <span class="step-label">Impact</span>
                    </div>
                    <div class="wizard-step-indicator" data-step="2">
                        <div class="step-circle">2</div>
                        <span class="step-label">Verify</span>
                    </div>
                    <div class="wizard-step-indicator" data-step="3">
                        <div class="step-circle">3</div>
                        <span class="step-label">Confirm</span>
                    </div>
                    <div class="wizard-step-indicator" data-step="4">
                        <div class="step-circle">4</div>
                        <span class="step-label">Feedback</span>
                    </div>
                    <div class="wizard-step-indicator" data-step="5">
                        <div class="step-circle">
                            <i class="bi bi-trash3"></i>
                        </div>
                        <span class="step-label">Delete</span>
                    </div>
                </div>

                {{-- Step 1: Impact Summary --}}
                <div class="wizard-step active" data-step="1">
                    <div class="wizard-content">
                        <div class="step-header">
                            <h3>What will be deleted?</h3>
                            <p>Please review the data that will be permanently removed from your account.</p>
                        </div>

                        <div class="impact-grid">
                            <div class="impact-item">
                                <i class="bi bi-person-circle"></i>
                                <div class="impact-item-content">
                                    <div class="impact-item-title">Profile & Bio</div>
                                    <p class="impact-item-desc">Username, avatar, major, university, and personal description</p>
                                </div>
                            </div>
                            <div class="impact-item">
                                <i class="bi bi-bullseye"></i>
                                <div class="impact-item-content">
                                    <div class="impact-item-title">Goals & Habits</div>
                                    <p class="impact-item-desc">All goals, progress tracking, and habit streaks</p>
                                </div>
                            </div>
                            <div class="impact-item">
                                <i class="bi bi-journal-check"></i>
                                <div class="impact-item-content">
                                    <div class="impact-item-title">Quiz Attempts</div>
                                    <p class="impact-item-desc">All test scores, history, and performance data</p>
                                </div>
                            </div>
                            <div class="impact-item">
                                <i class="bi bi-trophy"></i>
                                <div class="impact-item-content">
                                    <div class="impact-item-title">Season Standings</div>
                                    <p class="impact-item-desc">Rank, leaderboard position, and season scores</p>
                                </div>
                            </div>
                        </div>

                        <div class="danger-note">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div>
                                <strong>This action is irreversible.</strong> Once deleted, your account and all associated data cannot be recovered. You will not be able to log in or access any of your information.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Step 2: Re-authentication --}}
                <div class="wizard-step" data-step="2">
                    <div class="wizard-content">
                        <div class="step-header">
                            <h3>Verify Your Identity</h3>
                            <p>For security purposes, please enter your current password to confirm your identity.</p>
                        </div>

                        <div class="mb-4">
                            <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" id="current_password" required
                                   class="form-control" autocomplete="current-password" placeholder="Enter your current password">
                            <div class="form-text">You must enter your current password to proceed with account deletion.</div>
                        </div>

                        <div class="alert alert-info d-flex align-items-start gap-2" role="alert">
                            <i class="bi bi-info-circle-fill flex-shrink-0 mt-1"></i>
                            <small>This step ensures that only you can delete your account, even if someone else has access to your device.</small>
                        </div>
                    </div>
                </div>

                {{-- Step 3: Intent Guard --}}
                <div class="wizard-step" data-step="3">
                    <div class="wizard-content">
                        <div class="step-header">
                            <h3>Confirm Your Intent</h3>
                            <p>Please complete both fields below to confirm you want to permanently delete your account.</p>
                        </div>

                        <div class="mb-3">
                            <label for="del_confirmation" class="form-label">Type <code>DELETE</code> to confirm <span class="text-danger">*</span></label>
                            <input type="text" name="confirmation" id="del_confirmation" required class="form-control"
                                   placeholder="Type DELETE here" autocomplete="off">
                            <div class="form-text">Please type the word <strong>DELETE</strong> exactly as shown to confirm you understand the consequences.</div>
                        </div>

                        <div class="acknowledgment">
                            <input class="form-check-input" type="checkbox" name="agree_irreversible" value="1" id="del_agree_irreversible" required>
                            <label class="form-check-label" for="del_agree_irreversible">
                                I understand that this action is <strong>irreversible</strong> and my account and all data will be permanently deleted.
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Step 4: Optional Feedback --}}
                <div class="wizard-step" data-step="4">
                    <div class="wizard-content">
                        <div class="step-header">
                            <h3>Help Us Improve</h3>
                            <p>We're sorry to see you go. Please share your feedback to help us improve UniGrowth for everyone.</p>
                        </div>

                        <div class="mb-3">
                            <label for="del_feedback_reason" class="form-label">Reason for leaving</label>
                            <select name="feedback_reason" id="del_feedback_reason" class="form-select">
                                <option value="">Select a reason...</option>
                                <option value="not_useful">Content is not useful</option>
                                <option value="too_expensive">Too expensive</option>
                                <option value="privacy">Privacy concerns</option>
                                <option value="found_alternative">Found a better alternative</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-0">
                            <label for="del_feedback" class="form-label">Additional feedback</label>
                            <textarea name="feedback" id="del_feedback" rows="4" maxlength="500"
                                      class="form-control" placeholder="Tell us more about your experience (optional)..."></textarea>
                            <div class="form-text">Your feedback helps us understand how to improve. Maximum 500 characters.</div>
                        </div>
                    </div>
                </div>

                {{-- Step 5: Final Confirmation --}}
                <div class="wizard-step" data-step="5">
                    <div class="wizard-content">
                        <div class="step-header">
                            <h3>Final Confirmation</h3>
                            <p>You're about to permanently delete your UniGrowth account. This is your last chance to cancel.</p>
                        </div>

                        <div class="alert alert-danger d-flex align-items-start gap-2" role="alert">
                            <i class="bi bi-exclamation-octagon-fill flex-shrink-0 mt-1" style="font-size: 1.5rem;"></i>
                            <div>
                                <strong>Warning: This cannot be undone!</strong><br>
                                All your data will be permanently deleted including your profile, goals, quiz attempts, and season standings. This action is final and irreversible.
                            </div>
                        </div>

                        <div class="card" style="background: var(--bg-elevated); border: 1px solid var(--border-default);">
                            <div class="card-body">
                                <h6 class="fw-semibold mb-3" style="color: var(--text-strong);">Account Information</h6>
                                <div class="row g-2 small">
                                    <div class="col-md-6">
                                        <span class="text-muted">Username:</span>
                                        <span class="fw-semibold">{{ auth()->user()->username }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Email:</span>
                                        <span class="fw-semibold">{{ auth()->user()->email }}</span>
                                    </div>
                                    @if(auth()->user()->university_name)
                                        <div class="col-md-6">
                                            <span class="text-muted">University:</span>
                                            <span class="fw-semibold">{{ auth()->user()->university_name }}</span>
                                        </div>
                                    @endif
                                    @if(auth()->user()->major)
                                        <div class="col-md-6">
                                            <span class="text-muted">Major:</span>
                                            <span class="fw-semibold">{{ auth()->user()->major }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Wizard Footer --}}
                <div class="wizard-footer">
                    <button type="button" class="btn btn-outline-custom" id="btn-prev" disabled>
                        <i class="bi bi-arrow-left me-1"></i>Previous
                    </button>
                    <div class="btn-group">
                        <a href="{{ route('profile.security') }}" class="btn btn-outline-custom">
                            <i class="bi bi-x-circle me-1"></i>Cancel
                        </a>
                        <button type="button" class="btn btn-brand-gradient" id="btn-next">
                            Next<i class="bi bi-arrow-right ms-1"></i>
                        </button>
                        <button type="submit" class="btn btn-delete-solid" id="btn-submit" style="display: none;">
                            <i class="bi bi-trash3 me-1"></i>Permanently Delete My Account
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 5;

            const prevBtn = document.getElementById('btn-prev');
            const nextBtn = document.getElementById('btn-next');
            const submitBtn = document.getElementById('btn-submit');
            const form = document.getElementById('delete-account-wizard');

            // Update wizard UI based on current step
            function updateWizard() {
                // Update step indicators
                document.querySelectorAll('.wizard-step-indicator').forEach((indicator, index) => {
                    const stepNum = index + 1;
                    indicator.classList.remove('active', 'completed');

                    if (stepNum < currentStep) {
                        indicator.classList.add('completed');
                        indicator.querySelector('.step-circle').innerHTML = '<i class="bi bi-check"></i>';
                    } else if (stepNum === currentStep) {
                        indicator.classList.add('active');
                        indicator.querySelector('.step-circle').textContent = stepNum;
                    } else {
                        indicator.querySelector('.step-circle').textContent = stepNum;
                    }
                });

                // Show current step content
                document.querySelectorAll('.wizard-step').forEach(step => {
                    step.classList.remove('active');
                });
                document.querySelector(`.wizard-step[data-step="${currentStep}"]`).classList.add('active');

                // Update buttons
                prevBtn.disabled = currentStep === 1;

                if (currentStep === totalSteps) {
                    nextBtn.style.display = 'none';
                    submitBtn.style.display = 'inline-block';
                } else {
                    nextBtn.style.display = 'inline-block';
                    submitBtn.style.display = 'none';
                }
            }

            // Validate current step
            function validateStep(step) {
                const currentStepElement = document.querySelector(`.wizard-step[data-step="${step}"]`);
                const requiredInputs = currentStepElement.querySelectorAll('[required]');
                let isValid = true;

                requiredInputs.forEach(input => {
                    if (input.type === 'checkbox') {
                        if (!input.checked) {
                            isValid = false;
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    } else if (input.type === 'text' && input.id === 'del_confirmation') {
                        if (input.value.trim().toUpperCase() !== 'DELETE') {
                            isValid = false;
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    } else {
                        if (!input.value.trim()) {
                            isValid = false;
                            input.classList.add('is-invalid');
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    }
                });

                return isValid;
            }

            // Next button click
            nextBtn.addEventListener('click', function() {
                if (validateStep(currentStep)) {
                    if (currentStep < totalSteps) {
                        currentStep++;
                        updateWizard();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                } else {
                    // Shake animation for invalid step
                    const currentStepElement = document.querySelector(`.wizard-step[data-step="${currentStep}"]`);
                    currentStepElement.style.animation = 'none';
                    setTimeout(() => {
                        currentStepElement.style.animation = 'shake 0.5s';
                    }, 10);
                }
            });

            // Previous button click
            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    updateWizard();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                if (!validateStep(currentStep)) {
                    e.preventDefault();
                    return;
                }

                if (!confirm('Are you absolutely sure? This will permanently delete your account and all data. This cannot be undone.')) {
                    e.preventDefault();
                }
            });

            // Real-time validation for confirmation input
            const confirmationInput = document.getElementById('del_confirmation');
            if (confirmationInput) {
                confirmationInput.addEventListener('input', function() {
                    if (this.value.trim().toUpperCase() === 'DELETE') {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                    }
                });
            }

            // Initialize
            updateWizard();
        });
    </script>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
    </style>
</body>
</html>
