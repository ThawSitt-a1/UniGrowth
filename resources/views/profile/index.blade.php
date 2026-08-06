<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile & Account Manager - UniGrowth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @livewireStyles
    <style>
        /* ============================================================
           UniGrowth — Profile Page Design System
           ============================================================
           Three-layer token architecture (per UI/UX Pro Max):

             1. PRIMITIVES  → raw hex / spacing values
             2. SEMANTIC    → purpose aliases theme-aware
             3. COMPONENT   → profile-specific component tokens

           Dark mode is driven by Bootstrap 5.3's `data-bs-theme="dark"`
           attribute set on <html>, so every token swaps cleanly between
           light and dark without any hardcoded colours in markup.
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
            --slate-700: #334155;
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

        /* === 3. COMPONENT (profile page) === */
        :root {
            /* Sidebar navigation */
            --side-panel-bg: var(--bg-card);
            --side-panel-border: var(--border-soft);
            --nav-link-color: var(--text-body);
            --nav-link-hover-bg: var(--bg-hover);
            --nav-link-hover-color: var(--primary);
            --nav-link-active-bg: var(--gradient-brand);
            --nav-link-active-color: #ffffff;

            /* Cards */
            --card-bg: var(--bg-card);
            --card-border: var(--border-soft);
            --card-radius: var(--radius-lg);
            --card-shadow: var(--shadow-card);
            --card-padding: 1.75rem;

            /* Section icon chips */
            --icon-chip-bg: var(--primary-soft-bg);
            --icon-chip-color: var(--primary-soft-fg);

            /* Stat display */
            --stat-bg: var(--bg-elevated);
            --stat-border: var(--border-default);
            --stat-value-color: var(--text-strong);
            --stat-label-color: var(--text-muted);

            /* Avatar */
            --avatar-ring: var(--border-brand);

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

            /* Preference panels */
            --pref-panel-bg: var(--bg-elevated);
            --pref-panel-border: var(--border-default);
            --pref-panel-title: var(--text-strong);
            --pref-item-bg: var(--bg-card);
            --pref-item-border: var(--border-default);

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
           Top navigation (kept same brand gradient in both themes)
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
           Profile sidebar
           ============================================================ */
        .profile-sidebar {
            position: sticky;
            top: 90px;
            z-index: 1;
        }
        .side-panel {
            background-color: var(--side-panel-bg);
            border: 1px solid var(--side-panel-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            padding: var(--space-4);
            transition: background-color var(--duration-normal) var(--ease-out),
                        border-color var(--duration-normal) var(--ease-out);
        }
        .side-panel .panel-label {
            color: var(--text-muted);
            letter-spacing: 0.05em;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .profile-sidebar .nav-link {
            color: var(--nav-link-color);
            font-size: 0.9rem;
            font-weight: 500;
            padding: 10px 16px;
            border-radius: 10px;
            transition: all var(--duration-fast) var(--ease-out);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .profile-sidebar .nav-link:hover {
            background: var(--nav-link-hover-bg);
            color: var(--nav-link-hover-color);
        }
        .profile-sidebar .nav-link.active {
            background: var(--nav-link-active-bg);
            color: var(--nav-link-active-color);
            box-shadow: var(--shadow-brand);
        }
        .profile-sidebar .nav-link i {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
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
            scroll-margin-top: 90px;
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

        /* Profile hero / summary */
        .profile-hero {
            position: relative;
            overflow: hidden;
            background: var(--card-bg);
            border: 1px solid var(--border-soft);
        }
        .profile-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(600px 180px at 15% -40%, rgba(99, 102, 241, 0.18), transparent 70%),
                radial-gradient(500px 160px at 90% -30%, rgba(124, 58, 237, 0.14), transparent 70%);
            pointer-events: none;
        }
        .profile-hero .hero-content {
            position: relative;
            z-index: 1;
        }
        .avatar-xl {
            width: 84px;
            height: 84px;
            border-radius: var(--radius-full);
            object-fit: cover;
            border: 3px solid var(--avatar-ring);
            box-shadow: var(--shadow-card);
        }
        .avatar-initial-xl {
            width: 84px;
            height: 84px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 2.1rem;
            background: var(--gradient-brand);
            color: #fff;
            border: 3px solid var(--avatar-ring);
            box-shadow: var(--shadow-card);
        }
        .hero-name {
            color: var(--text-strong);
            font-weight: 700;
        }
        .hero-meta {
            color: var(--text-muted);
        }
        .hero-university {
            color: var(--text-muted);
        }

        /* Stat display */
        .stat-display {
            background: var(--stat-bg);
            border-radius: 14px;
            padding: 1rem 1.25rem;
            text-align: center;
            border: 1px solid var(--stat-border);
            min-width: 140px;
            transition: background-color var(--duration-normal) var(--ease-out),
                        border-color var(--duration-normal) var(--ease-out);
        }
        .stat-display .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--stat-value-color);
            line-height: 1.2;
        }
        .stat-display .stat-label {
            font-size: 0.72rem;
            color: var(--stat-label-color);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
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
        .btn-bug-submit {
            background: var(--danger-solid);
            color: #fff;
            border-radius: var(--btn-brand-radius);
            padding: 8px 22px;
            font-weight: 600;
            font-size: 0.85rem;
            border: none;
            transition: all var(--duration-fast) var(--ease-out);
        }
        .btn-bug-submit:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
            color: #fff;
        }

        /* ============================================================
           Danger zone
           ============================================================ */
        .danger-zone-card {
            background: var(--danger-card-bg);
            border: 1px solid var(--danger-card-border);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
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
           Preference panels
           ============================================================ */
        .pref-panel {
            background: var(--pref-panel-bg);
            border: 1px solid var(--pref-panel-border);
            border-radius: var(--radius-md);
            padding: var(--space-5);
            margin-bottom: var(--space-5);
            transition: background-color var(--duration-normal) var(--ease-out),
                        border-color var(--duration-normal) var(--ease-out);
        }
        .pref-panel-title {
            color: var(--pref-panel-title);
            font-weight: 700;
        }
        .pref-item {
            background: var(--pref-item-bg);
            border: 1px solid var(--pref-item-border);
            border-radius: var(--radius-md);
            padding: var(--space-4);
            box-shadow: var(--shadow-card);
            cursor: pointer;
            transition: background-color var(--duration-normal) var(--ease-out),
                        border-color var(--duration-normal) var(--ease-out);
        }
        .pref-item:hover {
            border-color: var(--input-focus);
        }
        .pref-item .form-switch {
            margin-bottom: 0;
        }
        .pref-toggle-row {
            display: flex;
            align-items: flex-start;
            gap: var(--space-3);
            margin-bottom: var(--space-4);
        }
        .pref-toggle-row:last-child {
            margin-bottom: 0;
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
           Modal
           ============================================================ */
        .modal-content {
            border-radius: var(--radius-lg);
            border: none;
            background: var(--card-bg);
            color: var(--text-body);
            box-shadow: var(--shadow-pop);
        }
        .modal-header, .modal-footer {
            border-color: var(--border-default) !important;
        }
        .modal-title {
            color: var(--text-strong);
        }

        /* ============================================================
           Alerts — theme-aware override (keeps Bootstrap context)
           ============================================================ */
        .alert {
            border-radius: var(--radius-md);
        }

/* ============================================================
           Delete Account Modal — redesigned confirmation flow
           ============================================================ */
        .delete-modal-header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 1.5rem 1.75rem 1.25rem;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.08), rgba(244, 63, 94, 0.06));
            border-bottom: 1px solid var(--red-200);
        }
        [data-bs-theme="dark"] .delete-modal-header {
            border-bottom-color: var(--red-800);
        }
        .delete-modal-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #fff;
            background: linear-gradient(135deg, #dc2626, #ef4444);
            box-shadow: 0 6px 18px rgba(220, 38, 38, 0.35);
            flex-shrink: 0;
        }
        .modal-subtitle {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-top: 2px;
        }
        .delete-step {
            margin-bottom: 0.25rem;
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
        .delete-modal-body {
            padding: 1.5rem 1.75rem;
        }
        .delete-step-panel {
            display: none;
        }
        .delete-step-panel.is-active {
            display: block;
        }
        .modal-progress {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
            margin: 0 1.75rem 1rem;
        }
        .modal-progress .progress-step {
            height: 6px;
            border-radius: 999px;
            background: var(--border-default);
            transition: background-color var(--duration-fast) var(--ease-out);
        }
        .modal-progress .progress-step.is-active,
        .modal-progress .progress-step.is-complete {
            background: var(--primary);
        }
        .modal-progress .progress-step.is-active {
            box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.25);
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
        .footer-delete {
            border-top: 1px solid var(--border-default) !important;
            background: var(--bg-elevated);
        }
        .btn-delete-solid {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            border: none;
            border-radius: var(--radius-md);
            padding: 8px 22px;
            font-weight: 600;
            font-size: 0.85rem;
            color: #fff;
            transition: transform var(--duration-fast) var(--ease-out),
                        box-shadow var(--duration-fast) var(--ease-out);
        }
        .btn-delete-solid:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 22px rgba(220, 38, 38, 0.35);
            color: #fff;
        }
        @media (max-width: 575.98px) {
            .delete-impact-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ============================================================
           Scrollbar (dark friendly)
           ============================================================ */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-body);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--border-default);
            border-radius: 6px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-faint);
        }

        /* ============================================================
           Responsive
           ============================================================ */
        @media (max-width: 767.98px) {
            .profile-sidebar {
                position: static;
                margin-bottom: var(--space-4);
            }
            .profile-sidebar .nav {
                flex-direction: row !important;
                overflow-x: auto;
                flex-wrap: nowrap;
                gap: 4px;
                padding-bottom: 4px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: thin;
            }
            .profile-sidebar .nav::-webkit-scrollbar {
                height: 4px;
            }
            .profile-sidebar .nav::-webkit-scrollbar-thumb {
                background: var(--border-default);
                border-radius: 4px;
            }
            .profile-sidebar .nav-link {
                white-space: nowrap;
                font-size: 0.8rem;
                padding: 8px 12px;
            }
            .profile-hero .hero-stats {
                width: 100%;
                justify-content: flex-start;
            }
        }
        @media (max-width: 400px) {
            body { overflow-x: hidden; }
            .section-card { padding: 1rem !important; }
            .section-card h5 { font-size: 1rem !important; }
            .avatar-xl { width: 64px; height: 64px; }
            .avatar-initial-xl { width: 64px; height: 64px; font-size: 1.6rem; }
            .stat-display { padding: 0.5rem 0.75rem !important; min-width: 110px; }
            .stat-display .stat-value { font-size: 1.1rem !important; }
            .danger-zone-card { padding: 1rem !important; }
            .pref-panel { padding: 1rem !important; }
        }
    </style>
</head>
<body>

{{--
============================================================
TOP NAVIGATION BAR (Same as Dashboard)
============================================================
--}}
<nav class="navbar navbar-expand-lg sticky-top navbar-unigrowth">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="{{ route('dashboard') }}">
            <i class="bi bi-mortarboard-fill me-2"></i>UniGrowth
        </a>
        <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#profileNavMenu" style="color: rgba(255,255,255,0.7);">
            <i class="bi bi-list fs-4"></i>
        </button>
        <div class="collapse navbar-collapse" id="profileNavMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link nav-link-custom">
                        <i class="bi bi-house-door"></i>Dashboard
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
                <li class="nav-item">
                    <a href="{{ route('core-assets.index') }}" class="nav-link nav-link-custom">
                        <i class="bi bi-bullseye"></i>Goals
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

{{--
============================================================
MAIN CONTENT: Grid with Sidebar + Content
============================================================
--}}
<div class="container py-4">
    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
            <i class="bi bi-check-circle-fill flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
            <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger py-3 px-4 mb-4 rounded-3 small">
            <ul class="list-unstyled mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-triangle me-1"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        {{--
        ============================================================
        LEFT SIDEBAR NAVIGATION (Sticky, never moves)
        ============================================================
        --}}
        <div class="col-lg-3">
            <div class="profile-sidebar">
                <div class="side-panel">
                    <h6 class="panel-label mb-3 px-2">
                        <i class="bi bi-compass me-1"></i>Navigation
                    </h6>
                    <nav class="nav flex-column gap-1">
                        <a href="#account-detail" class="nav-link active" data-section="account-detail">
                            <i class="bi bi-person-circle"></i>Account Detail
                        </a>
                        <a href="#preferences" class="nav-link" data-section="preferences">
                            <i class="bi bi-sliders"></i>Preferences
                        </a>
                        <a href="#bug-report" class="nav-link" data-section="bug-report">
                            <i class="bi bi-bug"></i>Bug Report
                        </a>
                        <a href="{{ route('profile.security') }}" class="nav-link">
                            <i class="bi bi-shield-lock"></i>Security
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        {{--
        ============================================================
        RIGHT MAIN CONTENT (All sections)
        ============================================================
        --}}
        <div class="col-lg-9">

            {{-- Profile Summary Hero --}}
            <div class="section-card profile-hero">
                <div class="hero-content d-flex flex-wrap align-items-center gap-4">
                    <div class="flex-shrink-0">
                        @if (!empty($profile['avatar_path']))
                            <img src="{{ asset('storage/' . $profile['avatar_path']) }}" alt="Avatar" class="avatar-xl">
                        @else
                            <div class="avatar-initial-xl">{{ strtoupper(substr($profile['username'] ?? 'U', 0, 1)) }}</div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="hero-name mb-1">{{ $profile['username'] ?? 'User' }}
                            <span data-bs-toggle="modal" data-bs-target="#rankTiersModal" style="cursor: pointer; color: #6366f1; font-weight: 600; font-size: 0.9rem;" title="View rank tiers">
                                [{{ \App\Auth\Models\User::rankTitle((float) ($profile['platform_score'] ?? 0)) }}]
                            </span>
                        </h4>
                        <p class="hero-meta mb-1 small">
                            <i class="bi bi-mortarboard me-1"></i>
                            {{ $profile['major'] ?? 'No major set' }}
                            @if ($profile['academic_year'])
                                <span class="mx-1">&bull;</span> {{ $profile['academic_year'] }}
                            @endif
                        </p>
                        @if ($profile['university_name'])
                            <p class="hero-university mb-0 small"><i class="bi bi-building me-1"></i>{{ $profile['university_name'] }}</p>
                        @endif
                    </div>
                    <div class="flex-shrink-0 hero-stats">
                        <div class="stat-display">
                            <div class="stat-value">{{ number_format($profile['platform_score'] ?? 0, 1) }}</div>
                            <div class="stat-label">Platform Score</div>
                        </div>
                    </div>
                </div>
            </div>

            {{--
            ============================================================
            SECTION 1: ACCOUNT DETAIL (Livewire Profile Update)
            ============================================================
            --}}
            <div id="account-detail" class="section-card">
                <div class="d-flex align-items-center mb-3">
                    <div class="section-icon">
                        <i class="bi bi-person-gear"></i>
                    </div>
                    <h5 class="mb-0">👤 Account Details & Profile Information</h5>
                </div>

                {{-- Livewire Component for Profile Updates --}}
                @livewire('profile-update-manager')

                <hr class="my-4">

                {{-- Danger Zone --}}
                <div class="danger-zone-card">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-exclamation-triangle-fill fs-5" style="color: var(--danger-soft-fg);"></i>
                        <h5 class="mb-0">⚠️ Danger Zone</h5>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 py-2">
                        <div>
                            <p class="danger-item-title mb-0">Password Reset</p>
                            <small class="text-muted">Reset your account password to a new one.</small>
                        </div>
                        <button type="button" class="btn btn-brand-gradient btn-sm" data-bs-toggle="modal" data-bs-target="#passwordResetModal">
                            <i class="bi bi-key me-1"></i>Password Reset
                        </button>
                    </div>
                    <hr class="my-3 danger-divider">
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 py-2">
                        <div>
                            <p class="danger-item-title mb-0">Delete My Account</p>
                            <small class="text-muted">Permanently delete your account and all associated data. This action is irreversible.</small>
                        </div>
                        <button type="button" class="btn btn-danger-soft btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="bi bi-trash3 me-1"></i>Delete My Account
                        </button>
                    </div>
                </div>
            </div>

            {{--
            ============================================================
            SECTION 2: PREFERENCES (Privacy & Communication)
            ============================================================
            --}}
            <div id="preferences" class="section-card">
                <div class="d-flex align-items-center mb-3">
                    <div class="section-icon">
                        <i class="bi bi-sliders"></i>
                    </div>
                    <h5 class="mb-0">🔒 Preferences & Communication Settings</h5>
                </div>

                <form action="{{ route('profile.preferences.update') }}" method="POST" id="preferences-form">
                    @csrf
                    @method('PATCH')

                    {{-- Privacy & Visibility --}}
                    <div class="pref-panel">
                        <h6 class="pref-panel-title mb-4">
                            <i class="bi bi-shield-lock me-2"></i>Privacy & Visibility
                        </h6>
                        <div class="pref-toggle-row">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="make_profile_private" value="1" role="switch"
                                       id="chk_private_profile"
                                       {{ ($profile['preferences']['make_profile_private'] ?? false) ? 'checked' : '' }}>
                            </div>
                            <div>
                                <label class="form-check-label fw-semibold" for="chk_private_profile" style="cursor: pointer; color: var(--text-strong);">
                                    Make my profile private
                                </label>
                                <p class="text-muted small mb-0">You can hide your profile from leaderboards, academic statistics, and external profile view lookups.</p>
                            </div>
                        </div>
                        <div class="pref-toggle-row">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="privacy_hide_leaderboards" value="1" role="switch"
                                       id="chk_hide_leaderboard"
                                       {{ ($profile['preferences']['privacy_hide_leaderboards'] ?? false) ? 'checked' : '' }}>
                            </div>
                            <div>
                                <label class="form-check-label fw-semibold" for="chk_hide_leaderboard" style="cursor: pointer; color: var(--text-strong);">
                                    Hide from leaderboards
                                </label>
                                <p class="text-muted small mb-0">Your name and score will not appear on public leaderboards.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-brand-gradient">
                            <i class="bi bi-check2-circle me-1"></i>Save Preferences
                        </button>
                    </div>
                </form>

                <script>
                    // Ensure preferences form submits correctly and prevents Livewire interference
                    document.getElementById('preferences-form').addEventListener('submit', function(e) {
                        // Stop Livewire from intercepting this form submission
                        e.stopPropagation();
                        e.stopImmediatePropagation();
                        // Let the form submit normally - this ensures the PATCH request goes through
                        console.log('Preferences form submitting...');
                    });
                </script>
            </div>

            {{--
            ============================================================
            SECTION 3: BUG REPORT
            ============================================================
            --}}
            <div id="bug-report" class="section-card">
                <div class="d-flex align-items-center mb-3">
                    <div class="section-icon" style="background: var(--warning-bg); color: var(--warning-fg);">
                        <i class="bi bi-bug"></i>
                    </div>
                    <h5 class="mb-0">🐛 Report a Bug</h5>
                </div>

                <form action="{{ route('profile.bug-report.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="bug_title" class="form-label fw-semibold">Bug Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="bug_title" value="{{ old('title') }}" required maxlength="200"
                               class="form-control" placeholder="Brief description of the issue">
                    </div>

                    <div class="mb-3">
                        <label for="bug_description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="bug_description" rows="4" required maxlength="5000"
                                  class="form-control" placeholder="Detailed description of what happened...">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="bug_steps" class="form-label fw-semibold">Steps to Reproduce</label>
                        <textarea name="steps_to_reproduce" id="bug_steps" rows="3" maxlength="5000"
                                  class="form-control" placeholder="1. Go to...&#10;2. Click on...&#10;3. See error...">{{ old('steps_to_reproduce') }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="bug_severity" class="form-label fw-semibold">Severity <span class="text-danger">*</span></label>
                            <select name="severity" id="bug_severity" required class="form-select">
                                <option value="low" {{ old('severity') === 'low' ? 'selected' : '' }}>Low - Minor inconvenience</option>
                                <option value="medium" {{ old('severity') === 'medium' ? 'selected' : '' }}>Medium - Affects functionality</option>
                                <option value="high" {{ old('severity') === 'high' ? 'selected' : '' }}>High - Major feature broken</option>
                                <option value="critical" {{ old('severity') === 'critical' ? 'selected' : '' }}>Critical - System down / data loss</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="bug_screenshot" class="form-label fw-semibold">Screenshot (optional)</label>
                            <input type="file" name="screenshot" id="bug_screenshot" accept="image/png,image/jpeg,image/gif"
                                   class="form-control">
                            <small class="text-muted">Max 2MB. Accepted formats: PNG, JPG, GIF.</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-bug-submit">
                            <i class="bi bi-send me-1"></i>Submit Bug Report
                        </button>
                    </div>
                </form>
            </div>

        </div>{{-- /col-lg-9 --}}
    </div>{{-- /row --}}
</div>{{-- /container --}}

{{--
============================================================
PASSWORD RESET MODAL
============================================================
--}}
<div class="modal fade" id="passwordResetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-key me-2"></i>Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.account.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="change_password">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modal_current_password" class="form-label fw-semibold">Current Password</label>
                        <input type="password" name="current_password" id="modal_current_password" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="modal_new_password" class="form-label fw-semibold">New Password</label>
                        <input type="password" name="new_password" id="modal_new_password" required minlength="12" class="form-control">
                        <small class="text-muted">Minimum 12 characters.</small>
                    </div>
                    <div class="mb-3">
                        <label for="modal_new_password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="modal_new_password_confirmation" required class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: var(--radius-md);">Cancel</button>
                    <button type="submit" class="btn btn-brand-gradient">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--
============================================================
DELETE ACCOUNT CONFIRMATION MODAL
============================================================
A polished, stagger-stepped confirmation flow:
  1. Impact summary — what data will be permanently removed.
  2. Re-authentication (current password) required.
  3. Typing "DELETE" (Intent Guard) to confirm intent.
  4. Checkbox acknowledging the action is irreversible.
  5. Optional feedback for why the user is leaving.
--}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content" style="overflow: hidden;">
            {{-- Tinted header band --}}
            <div class="delete-modal-header">
                <div class="delete-modal-icon">
                    <i class="bi bi-trash3-fill"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="modal-title fw-bold mb-0">Delete My Account</h5>
                    <p class="modal-subtitle mb-0">This will permanently remove your account and all associated data.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
 
            <div class="modal-progress" aria-hidden="true">
                <span class="progress-step is-active"></span>
                <span class="progress-step"></span>
                <span class="progress-step"></span>
                <span class="progress-step"></span>
            </div>
 
            <form action="{{ route('profile.account.update') }}" method="POST" id="delete-account-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="deactivate">
  
                <div class="modal-body delete-modal-body">
 
                    {{-- STEP 1: Impact summary --}}
                    <div class="delete-step-panel is-active" data-step="1">
                        <div class="delete-step">
                            <div class="delete-step-head">
                                <span class="delete-step-badge">1</span>
                                <span class="fw-semibold" style="color: var(--text-strong);">What will be deleted</span>
                            </div>
                            <div class="delete-impact-grid">
                                <div class="impact-item">
                                    <i class="bi bi-person-circle"></i>
                                    <div>
                                        <span class="d-block fw-semibold small">Profile & bio</span>
                                        <small class="text-muted">Username, avatar, major, links</small>
                                    </div>
                                </div>
                                <div class="impact-item">
                                    <i class="bi bi-bullseye"></i>
                                    <div>
                                        <span class="d-block fw-semibold small">Goals & habits</span>
                                        <small class="text-muted">All progress & streaks</small>
                                    </div>
                                </div>
                                <div class="impact-item">
                                    <i class="bi bi-journal-check"></i>
                                    <div>
                                        <span class="d-block fw-semibold small">Quiz attempts</span>
                                        <small class="text-muted">Scores & history</small>
                                    </div>
                                </div>
                                <div class="impact-item">
                                    <i class="bi bi-trophy"></i>
                                    <div>
                                        <span class="d-block fw-semibold small">Season standings</span>
                                        <small class="text-muted">Rank & leaderboard entry</small>
                                    </div>
                                </div>
                            </div>
                            <div class="delete-danger-note">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span><strong>Irreversible.</strong> You will not be able to log in or recover any of this data.</span>
                            </div>
                        </div>
                    </div>
 
                    <div class="delete-step-panel" data-step="2">
                        <div class="delete-step">
                            <div class="delete-step-head">
                                <span class="delete-step-badge">2</span>
                                <span class="fw-semibold" style="color: var(--text-strong);">Verify your identity</span>
                            </div>
                            <div class="mb-3 mb-0">
                                <label for="del_current_password" class="form-label fw-semibold">Current Password <span class="text-danger">*</span></label>
                                <input type="password" name="current_password" id="del_current_password" required class="form-control" autocomplete="current-password" placeholder="Enter your current password to confirm">
                                <div class="form-text">You must enter your current password to verify your identity.</div>
                            </div>
                        </div>
                    </div>
 
                    <div class="delete-step-panel" data-step="3">
                        <div class="delete-step">
                            <div class="delete-step-head">
                                <span class="delete-step-badge">3</span>
                                <span class="fw-semibold" style="color: var(--text-strong);">Confirm your intent</span>
                            </div>
                            <div class="mb-3">
                                <label for="del_confirmation" class="form-label fw-semibold">Type <code>DELETE</code> to confirm <span class="text-danger">*</span></label>
                                <input type="text" name="confirmation" id="del_confirmation" required class="form-control" placeholder="Type DELETE here" autocomplete="off">
                                <div class="form-text">Please type the word <strong>DELETE</strong> exactly as shown to confirm you understand.</div>
                            </div>
 
                            <div class="delete-ack">
                                <input class="form-check-input" type="checkbox" name="agree_irreversible" value="1" id="del_agree_irreversible" required>
                                <label class="form-check-label small" for="del_agree_irreversible" style="color: var(--text-strong);">
                                    I understand that this action is <strong>irreversible</strong> and my account and all data will be permanently deleted.
                                </label>
                            </div>
                        </div>
                    </div>
 
                    <div class="delete-step-panel" data-step="4">
                        <div class="delete-step">
                            <div class="delete-step-head">
                                <span class="delete-step-badge"><i class="bi bi-chat-heart"></i></span>
                                <span class="fw-semibold" style="color: var(--text-strong);">Would you like to tell us why? <span class="text-muted fw-normal">(optional)</span></span>
                            </div>
                            <div class="mb-3">
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
                                <textarea name="feedback" id="del_feedback" rows="3" maxlength="500" class="form-control" placeholder="Tell us more (optional)..."></textarea>
                            </div>
                        </div>
                    </div>
 
                </div>
                    <div class="delete-step">
                        <div class="delete-step-head">
                            <span class="delete-step-badge">1</span>
                            <span class="fw-semibold" style="color: var(--text-strong);">What will be deleted</span>
                        </div>
                        <div class="delete-impact-grid">
                            <div class="impact-item">
                                <i class="bi bi-person-circle"></i>
                                <div>
                                    <span class="d-block fw-semibold small">Profile & bio</span>
                                    <small class="text-muted">Username, avatar, major, links</small>
                                </div>
                            </div>
                            <div class="impact-item">
                                <i class="bi bi-bullseye"></i>
                                <div>
                                    <span class="d-block fw-semibold small">Goals & habits</span>
                                    <small class="text-muted">All progress & streaks</small>
                                </div>
                            </div>
                            <div class="impact-item">
                                <i class="bi bi-journal-check"></i>
                                <div>
                                    <span class="d-block fw-semibold small">Quiz attempts</span>
                                    <small class="text-muted">Scores & history</small>
                                </div>
                            </div>
                            <div class="impact-item">
                                <i class="bi bi-trophy"></i>
                                <div>
                                    <span class="d-block fw-semibold small">Season standings</span>
                                    <small class="text-muted">Rank & leaderboard entry</small>
                                </div>
                            </div>
                        </div>
                        <div class="delete-danger-note">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <span><strong>Irreversible.</strong> You will not be able to log in or recover any of this data.</span>
                        </div>
                    </div>

                    <hr class="delete-sep">

                    {{-- STEP 2: Re-authentication --}}
                    <div class="delete-step">
                        <div class="delete-step-head">
                            <span class="delete-step-badge">2</span>
                            <span class="fw-semibold" style="color: var(--text-strong);">Verify your identity</span>
                        </div>
                        <div class="mb-3 mb-0">
                            <label for="del_current_password" class="form-label fw-semibold">Current Password <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" id="del_current_password" required class="form-control" autocomplete="current-password" placeholder="Enter your current password to confirm">
                            <div class="form-text">You must enter your current password to verify your identity.</div>
                        </div>
                    </div>

                    <hr class="delete-sep">

                    {{-- STEP 3: Intent Guard — type DELETE --}}
                    <div class="delete-step">
                        <div class="delete-step-head">
                            <span class="delete-step-badge">3</span>
                            <span class="fw-semibold" style="color: var(--text-strong);">Confirm your intent</span>
                        </div>
                        <div class="mb-3">
                            <label for="del_confirmation" class="form-label fw-semibold">Type <code>DELETE</code> to confirm <span class="text-danger">*</span></label>
                            <input type="text" name="confirmation" id="del_confirmation" required class="form-control" placeholder="Type DELETE here" autocomplete="off">
                            <div class="form-text">Please type the word <strong>DELETE</strong> exactly as shown to confirm you understand.</div>
                        </div>

                        {{-- 4. Irreversibility acknowledgment --}}
                        <div class="delete-ack">
                            <input class="form-check-input" type="checkbox" name="agree_irreversible" value="1" id="del_agree_irreversible" required>
                            <label class="form-check-label small" for="del_agree_irreversible" style="color: var(--text-strong);">
                                I understand that this action is <strong>irreversible</strong> and my account and all data will be permanently deleted.
                            </label>
                        </div>
                    </div>

                    <hr class="delete-sep">

                    {{-- STEP 4: Optional feedback --}}
                    <div class="delete-step">
                        <div class="delete-step-head">
                            <span class="delete-step-badge"><i class="bi bi-chat-heart"></i></span>
                            <span class="fw-semibold" style="color: var(--text-strong);">Would you like to tell us why? <span class="text-muted fw-normal">(optional)</span></span>
                        </div>
                        <div class="mb-3">
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
                            <textarea name="feedback" id="del_feedback" rows="3" maxlength="500" class="form-control" placeholder="Tell us more (optional)..."></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer footer-delete">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: var(--radius-md); border: 1px solid var(--border-default);">
                        <i class="bi bi-arrow-left me-1"></i>Keep my account
                    </button>
                    <button type="button" class="btn btn-secondary" id="delete-step-back" style="border-radius: var(--radius-md);">
                        <i class="bi bi-arrow-left me-1"></i>Back
                    </button>
                    <button type="button" class="btn btn-primary" id="delete-step-next" style="border-radius: var(--radius-md);">
                        <i class="bi bi-arrow-right me-1"></i>Next step
                    </button>
                    <button type="submit" class="btn btn-danger btn-delete-solid" id="btn-delete-account" disabled>
                        <i class="bi bi-trash3 me-1"></i>Permanently Delete My Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--
============================================================
FRAGMENT SCROLLING: Update active sidebar link on scroll
============================================================
--}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.section-card[id]');
    const navLinks = document.querySelectorAll('.profile-sidebar .nav-link');

    function updateActiveLink() {
        let current = '';
        sections.forEach(section => {
            const rect = section.getBoundingClientRect();
            if (rect.top <= 150) {
                current = section.id;
            }
        });
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.dataset.section === current) {
                link.classList.add('active');
            }
        });
    }

    // Smooth scroll on sidebar click
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const target = document.getElementById(targetId);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // Update URL hash
                history.pushState(null, '', '#' + targetId);
            }
        });
    });

    // Update active link on scroll
    window.addEventListener('scroll', updateActiveLink, { passive: true });
    updateActiveLink();
 
    // Scroll to section if URL has hash on page load
    if (window.location.hash) {
        const target = document.querySelector(window.location.hash);
        if (target) {
            setTimeout(() => {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        }
    }
});
</script>
 
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteAccountModal');
    const stepPanels = Array.from(document.querySelectorAll('.delete-step-panel'));
    const progressSteps = Array.from(document.querySelectorAll('.modal-progress .progress-step'));
    const passwordInput = document.getElementById('del_current_password');
    const confirmationInput = document.getElementById('del_confirmation');
    const agreeCheckbox = document.getElementById('del_agree_irreversible');
    const backButton = document.getElementById('delete-step-back');
    const nextButton = document.getElementById('delete-step-next');
    const deleteButton = document.getElementById('btn-delete-account');
 
    let currentStep = 1;
    const totalSteps = stepPanels.length;
 
    function showStep(step) {
        currentStep = step;
        stepPanels.forEach(panel => {
            panel.classList.toggle('is-active', Number(panel.dataset.step) === step);
        });
        progressSteps.forEach((indicator, index) => {
            const stepIndex = index + 1;
            indicator.classList.toggle('is-active', stepIndex === step);
            indicator.classList.toggle('is-complete', stepIndex < step);
        });
 
        if (backButton) {
            backButton.style.display = step > 1 ? 'inline-flex' : 'none';
        }
        if (nextButton) {
            nextButton.style.display = step < totalSteps ? 'inline-flex' : 'none';
            nextButton.disabled = !canAdvance(step);
        }
        if (deleteButton) {
            deleteButton.style.display = step === totalSteps ? 'inline-flex' : 'none';
        }
 
        if (step === 2 && passwordInput) {
            passwordInput.focus();
        }
    }
 
    function canAdvance(step) {
        if (step === 1) {
            return true;
        }
        if (step === 2) {
            return passwordInput && passwordInput.value.trim().length > 0;
        }
        if (step === 3) {
            return confirmationInput && confirmationInput.value.trim().toUpperCase() === 'DELETE' && agreeCheckbox && agreeCheckbox.checked;
        }
        return true;
    }
 
    function updateDeleteActionState() {
        const hasPassword = passwordInput && passwordInput.value.trim().length > 0;
        const confirmed = confirmationInput && confirmationInput.value.trim().toUpperCase() === 'DELETE';
        const acknowledged = agreeCheckbox && agreeCheckbox.checked;
        if (deleteButton) {
            deleteButton.disabled = !(hasPassword && confirmed && acknowledged);
        }
        if (nextButton) {
            nextButton.disabled = !canAdvance(currentStep);
        }
    }
 
    if (backButton) {
        backButton.addEventListener('click', function () {
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        });
    }
 
    if (nextButton) {
        nextButton.addEventListener('click', function () {
            if (currentStep < totalSteps && canAdvance(currentStep)) {
                showStep(currentStep + 1);
            }
        });
    }
 
    [passwordInput, confirmationInput, agreeCheckbox].forEach(function (element) {
        if (!element) return;
        element.addEventListener('input', updateDeleteActionState);
        element.addEventListener('change', updateDeleteActionState);
    });
 
    if (deleteModal) {
        deleteModal.addEventListener('shown.bs.modal', function () {
            showStep(1);
        });
        deleteModal.addEventListener('hidden.bs.modal', function () {
            if (passwordInput) passwordInput.value = '';
            if (confirmationInput) confirmationInput.value = '';
            if (agreeCheckbox) agreeCheckbox.checked = false;
            updateDeleteActionState();
        });
    }
    showStep(1);
});
</script>
  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@include('partials.rank-tiers')

@livewireScripts
@include('partials.footer')
</body>
</html>
