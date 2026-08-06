<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniGrowth — Skill Assessment</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --indigo: #6366f1;
            --indigo-dark: #4f46e5;
            --purple: #7c3aed;
            --teal: #0891b2;
            --emerald: #059669;
            --amber: #d97706;
            --rose: #e11d48;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--gray-50);
        }

        /* ===== Navigation ===== */
        .navbar-gradient {
            background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);
        }
        .nav-link-custom {
            color: rgba(255,255,255,0.75);
            font-size: 0.875rem;
            font-weight: 500;
            padding: 6px 14px !important;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .nav-link-custom:hover {
            color: #fff;
            background: rgba(255,255,255,0.1);
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
            transition: all 0.2s;
        }
        .avatar-link:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .avatar-img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.3);
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
            background: rgba(255,255,255,0.2);
            color: #fff;
            border: 2px solid rgba(255,255,255,0.3);
        }
        .btn-logout-nav {
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            color: #fff;
            border: none;
            font-size: 0.85rem;
        }
        .btn-logout-nav:hover {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        /* ===== Cards ===== */
        .form-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.06), 0 1px 8px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }
        .form-card:hover {
            box-shadow: 0 8px 40px rgba(0,0,0,0.08), 0 2px 12px rgba(0,0,0,0.03);
        }
        .stat-card {
            padding: 1.25rem;
            border-radius: 12px;
            background: #fff;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        /* ===== Buttons ===== */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--indigo), var(--purple));
            border: none;
            border-radius: 10px;
            padding: 10px 28px;
            font-weight: 600;
            color: #fff;
            transition: all 0.2s;
        }
        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(99,102,241,0.35);
            color: #fff;
        }
        .btn-primary-custom:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .btn-outline-custom {
            border: 2px solid var(--gray-200);
            color: var(--gray-700);
            border-radius: 10px;
            padding: 10px 28px;
            font-weight: 600;
            transition: all 0.2s;
            background: transparent;
        }
        .btn-outline-custom:hover {
            border-color: var(--indigo);
            color: var(--indigo);
            background: rgba(99,102,241,0.05);
        }

        /* ===== Form Elements ===== */
        .input-field {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            font-size: 0.9375rem;
            color: var(--gray-700);
            background: var(--gray-50);
            transition: all 0.2s;
            outline: none;
        }
        .input-field:focus {
            border-color: var(--indigo);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .select-custom {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%236b7280' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        /* ===== Badges ===== */
        .badge-difficulty {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.025em;
            text-transform: uppercase;
        }
        .badge-difficulty.easy {
            background: #d1fae5;
            color: #065f46;
        }
        .badge-difficulty.medium {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-difficulty.hard {
            background: #fee2e2;
            color: #991b1b;
        }
        .badge-result {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .badge-result.passed {
            background: #d1fae5;
            color: #065f46;
        }
        .badge-result.failed {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ===== Question & Option Cards ===== */
        .question-card {
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: 14px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.2s;
        }
        .question-card:focus-within {
            border-color: var(--indigo);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .option-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s;
            background: #fff;
        }
        .option-item:hover {
            border-color: var(--indigo);
            background: rgba(99,102,241,0.03);
        }
        .option-item input[type="radio"] {
            width: 20px;
            height: 20px;
            accent-color: var(--indigo);
            flex-shrink: 0;
            margin: 0;
            cursor: pointer;
        }
        .option-item.selected {
            border-color: var(--indigo);
            background: rgba(99,102,241,0.06);
        }
        .option-item.correct {
            border-color: var(--emerald);
            background: rgba(5,150,105,0.06);
        }
        .option-item.incorrect {
            border-color: var(--rose);
            background: rgba(225,29,72,0.06);
        }

        /* ===== Progress Bar ===== */
        .progress-custom {
            height: 8px;
            border-radius: 10px;
            background: var(--gray-200);
            overflow: hidden;
        }
        .progress-custom .progress-bar {
            border-radius: 10px;
            background: linear-gradient(90deg, var(--indigo), var(--purple));
            transition: width 0.5s ease;
        }

        /* ===== Score Circle ===== */
        .score-circle {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            position: relative;
            margin: 0 auto;
        }
        .score-circle svg {
            position: absolute;
            top: 0;
            left: 0;
            transform: rotate(-90deg);
        }
        .score-circle .score-value {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1;
        }
        .score-circle .score-label {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-weight: 500;
        }

        /* ===== Alert Styles ===== */
        .alert-custom {
            border-radius: 12px;
            padding: 14px 20px;
            border: none;
        }
        .alert-custom.success {
            background: #ecfdf5;
            color: #065f46;
        }
        .alert-custom.error {
            background: #fef2f2;
            color: #991b1b;
        }
        .alert-custom.info {
            background: #eef2ff;
            color: #4338ca;
        }

        /* ===== Animations ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to   { opacity: 1; transform: scale(1); }
        }
        .animate-fade-up {
            animation: fadeInUp 0.4s ease forwards;
        }
        .animate-scale {
            animation: scaleIn 0.35s ease forwards;
        }
        .stagger-1 { animation-delay: 0.05s; }
        .stagger-2 { animation-delay: 0.1s; }
        .stagger-3 { animation-delay: 0.15s; }
        .stagger-4 { animation-delay: 0.2s; }
        .stagger-5 { animation-delay: 0.25s; }

/* ===== Motivational Quote Banners ===== */
        .quote-banner {
            background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);
            border-radius: 18px;
            padding: 1.5rem 1.75rem;
            position: relative;
            overflow: hidden;
            color: #fff;
            box-shadow: 0 12px 30px rgba(30,27,75,0.18);
        }
        .quote-banner::before {
            content: '';
            position: absolute;
            top: -60%;
            right: -10%;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .quote-banner::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: 5%;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,0.2) 0%, transparent 70%);
            pointer-events: none;
        }
        .quote-banner-alt { background: linear-gradient(135deg, #0f172a, #1e1b4b, #4c1d95); }
        .quote-banner-amber { background: linear-gradient(135deg, #78350f, #b45309, #d97706); }
        .quote-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #a5b4fc;
            flex-shrink: 0;
            backdrop-filter: blur(8px);
        }
        .quote-text {
            font-size: 1.05rem;
            font-weight: 600;
            line-height: 1.5;
            color: #fff;
            position: relative;
            z-index: 1;
            margin-bottom: 0.75rem;
        }
        .quote-author {
            display: inline-flex;
            align-items: center;
            font-weight: 700;
            color: #c7d2fe;
        }
        .quote-occupation {
            display: inline-flex;
            align-items: center;
            font-size: 0.82rem;
            color: rgba(199,210,254,0.7);
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            padding: 4px 12px;
            border-radius: 999px;
        }

        /* ===== Misc ===== */
        .card-header-gradient {
            background: linear-gradient(135deg, var(--indigo), var(--purple));
            border-radius: 16px 16px 0 0;
            padding: 1rem 1.5rem;
        }
        .section-title {
            font-weight: 700;
            color: var(--gray-800);
        }
        .section-title i {
            margin-right: 8px;
        }
        .text-muted-subtle {
            color: var(--gray-400);
        }
        .hover-lift {
            transition: all 0.2s;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
        }
        .table-custom th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--gray-500);
            font-weight: 600;
            border-bottom-width: 1px;
        }
        .table-custom td {
            font-size: 0.9rem;
            vertical-align: middle;
        }
        .leaderboard-rank {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 700;
            font-size: 0.9rem;
        }
.no-quiz-illustration {
            opacity: 0.4;
            font-size: 4rem;
        }

/* ===== Motivational Quote Banners ===== */
        .quote-banner {
            background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);
            border-radius: 20px;
            padding: 1.75rem 2rem;
            position: relative;
            overflow: hidden;
            color: #fff;
            box-shadow: 0 12px 30px rgba(30,27,75,0.18);
        }
        .quote-banner::before {
            content: '';
            position: absolute;
            top: -60%;
            right: -10%;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .quote-banner-alt { background: linear-gradient(135deg, #0f172a, #1e1b4b, #4c1d95); }
        .quote-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: #a5b4fc;
            flex-shrink: 0;
            backdrop-filter: blur(8px);
        }
        .quote-text {
            font-size: 1.15rem;
            font-weight: 600;
            line-height: 1.5;
            color: #fff;
            position: relative;
            z-index: 1;
            margin-bottom: 0.75rem;
        }
        .quote-author {
            display: inline-flex;
            align-items: center;
            font-weight: 700;
            color: #c7d2fe;
        }
        .quote-occupation {
            display: inline-flex;
            align-items: center;
            font-size: 0.85rem;
            color: rgba(199,210,254,0.75);
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            padding: 4px 12px;
            border-radius: 999px;
        }

        @media (max-width: 767.98px) {
            .score-circle {
                width: 110px;
                height: 110px;
            }
            .score-circle .score-value {
                font-size: 1.6rem;
            }
            .question-card {
                padding: 1rem;
            }
            .option-item {
                padding: 10px 14px;
            }
        }
        @media (max-width: 400px) {
            body { overflow-x: hidden; }
            .question-card { padding: 0.75rem !important; }
            .question-card h6 { font-size: 0.95rem !important; }
            .option-item { padding: 0.5rem !important; }
            .option-item span { font-size: 0.8rem !important; }
            .btn-primary-custom { font-size: 0.85rem !important; padding: 8px 16px !important; }
            .stat-card { padding: 0.5rem !important; }
            .stat-card .fs-4 { font-size: 1rem !important; }
            .stat-card small { font-size: 0.65rem !important; }
            .card-header-gradient { padding: 0.75rem 1rem !important; }
        }
    </style>
</head>
<body>

{{--
====================================================================
NAVIGATION — Matches dashboard's gradient navbar
====================================================================
--}}
<nav class="navbar navbar-expand-lg sticky-top navbar-gradient">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="{{ route('dashboard') }}">
            <i class="bi bi-mortarboard-fill me-2"></i>UniGrowth
        </a>

        <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" style="color: rgba(255,255,255,0.7);">
            <i class="bi bi-list fs-4"></i>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link nav-link-custom">
                        <i class="bi bi-speedometer2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('core-assets.skills') }}" class="nav-link nav-link-custom">
                        <i class="bi bi-book"></i>Skills
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('assessment.test.index') }}" class="nav-link nav-link-custom active" style="background: rgba(255,255,255,0.15);">
                        <i class="bi bi-pencil-square"></i>Quiz
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('core-assets.index') }}#goals" class="nav-link nav-link-custom">
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
                    <button type="submit" class="btn btn-sm btn-logout-nav">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

{{--
====================================================================
MAIN CONTENT
====================================================================
--}}
<div class="container py-4">

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-custom success d-flex align-items-center gap-2 mb-4 animate-fade-up">
            <i class="bi bi-check-circle-fill flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
@if (session('error'))
        <div class="alert alert-custom error d-flex align-items-center gap-2 mb-4 animate-fade-up">
            <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{--
    ================================================================
    MOTIVATIONAL QUOTES (Right Under Header)
    ================================================================
    --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="quote-banner h-100 animate-fade-up">
                <div class="d-flex align-items-start gap-3 flex-wrap">
                    <div class="quote-icon"><i class="bi bi-quote"></i></div>
                    <div class="flex-grow-1 min-width-0">
                        <p class="quote-text mb-2">
                            "I've failed over and over and over again in my life. And that is why I succeed."
                        </p>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="quote-author"><i class="bi bi-person-fill me-1"></i>Michael Jordan</span>
                            <span class="quote-occupation">Basketball Player</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="quote-banner quote-banner-alt h-100 animate-fade-up stagger-1">
                <div class="d-flex align-items-start gap-3 flex-wrap">
                    <div class="quote-icon"><i class="bi bi-quote"></i></div>
                    <div class="flex-grow-1 min-width-0">
                        <p class="quote-text mb-2">
                            "Success is never final, failure is never fatal. It is courage that counts."
                        </p>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="quote-author"><i class="bi bi-person-fill me-1"></i>John Wooden</span>
                            <span class="quote-occupation">Basketball Coach</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--
    ================================================================
    HERO / HEADER — Skill Selector
    ================================================================
    --}}
    <div class="form-card overflow-hidden mb-4 animate-fade-up">
        <div class="card-header-gradient">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h2 class="h4 fw-bold text-white mb-0">
                        <i class="bi bi-pencil-square me-2"></i>Skill Assessment
                    </h2>
                    <p class="text-white-50 small mb-0 mt-1">Test your knowledge and track your progress</p>
                </div>
                <span class="badge text-decoration-none" style="background: rgba(255,255,255,0.2); color: #fff; font-size: 0.75rem; padding: 6px 14px; border-radius: 8px;">
                    <i class="bi bi-layers me-1"></i>{{ count($skills) }} Skills Available
                </span>
            </div>
        </div>
        <div class="p-4">
            <form method="GET" action="{{ route('assessment.test.index') }}" id="skill-select-form">
                <label for="skill_id" class="form-label fw-semibold" style="color: var(--gray-700);">
                    <i class="bi bi-bookmark me-1" style="color: var(--indigo);"></i>Select a Skill to Begin
                </label>
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <select name="skill_id" id="skill_id"
                                class="form-select input-field select-custom"
                                onchange="document.getElementById('skill-select-form').submit()">
                            <option value="">— Choose a skill —</option>
                            @foreach ($skills as $skill)
                                <option value="{{ $skill->id }}" {{ $selectedSkillId === $skill->id ? 'selected' : '' }}>
                                    {{ $skill->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
<div class="col-md-4">
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="bi bi-arrow-right me-1"></i>Start Quiz
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

{{--
    ================================================================
    TWO-COLUMN LAYOUT: Quiz (Left) | Dashboard + Leaderboard (Right)
    ================================================================
    --}}
    <div class="row g-4">

        {{-- ============================================================ --}}
{{-- LEFT COLUMN: Quiz & Result Section --}}
        {{-- ============================================================ --}}
        <div class="col-lg-7">

            {{-- QUIZ SECTION --}}
            @if ($quiz)
                @php
                    $totalQuestions = count($quiz['questions']);
                    $totalMarks = 0;
                    foreach ($quiz['questions'] as $q) {
                        $totalMarks += (float) ($q['marks'] ?? 0);
                    }
                @endphp

                <div class="form-card overflow-hidden mb-4 animate-fade-up stagger-1">
                    <div class="card-header-gradient">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <h3 class="h5 fw-bold text-white mb-0">
                                    <i class="bi bi-journal-text me-2"></i>{{ $quiz['skill_title'] }}
                                </h3>
                                <p class="text-white-50 small mb-0 mt-1">
                                    {{ $totalQuestions }} {{ Str::plural('question', $totalQuestions) }}
                                </p>
                            </div>
                            <span class="badge" style="background: rgba(255,255,255,0.2); color: #fff; font-size: 0.75rem; padding: 6px 14px; border-radius: 8px;">
                                <i class="bi bi-clock me-1"></i>Unseen Questions
                            </span>
                        </div>
                    </div>

                    <div class="p-4">
                        <form method="POST" action="{{ route('assessment.test.submit') }}" id="quiz-form">
                            @csrf
                            <input type="hidden" name="skill_id" value="{{ $selectedSkillId }}">

                            {{-- Progress Bar --}}
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <small class="fw-semibold" style="color: var(--gray-500);">
                                    <i class="bi bi-bar-chart-fill me-1" style="color: var(--indigo);"></i>Progress
                                </small>
                                <small class="fw-semibold" style="color: var(--gray-500);">
                                    <span id="answered-count">0</span> / {{ $totalQuestions }} answered
                                </small>
                            </div>
                            <div class="progress-custom mb-4">
                                <div class="progress-bar" id="quiz-progress" role="progressbar" style="width: 0%;"
                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="{{ $totalQuestions }}">
                                </div>
                            </div>

                            {{-- Questions --}}
                            @foreach ($quiz['questions'] as $qIndex => $question)
                                <div class="question-card animate-fade-up stagger-{{ min($qIndex + 1, 5) }}">
                                    <div class="d-flex align-items-start justify-content-between mb-3">
                                        <h6 class="fw-bold mb-0" style="color: var(--gray-800);">
                                            <span style="color: var(--indigo);">Q{{ $qIndex + 1 }}.</span>
                                            {{ $question['question_text'] }}
                                        </h6>
                                        <div class="d-flex align-items-center gap-2 flex-shrink-0 ms-2">
                                            <span class="badge" style="background: #eef2ff; color: #4338ca; font-size: 0.7rem; padding: 3px 10px; border-radius: 20px;">
                                                <i class="bi bi-{{ $question['question_type'] === 'true_false' ? 'toggle2-on' : 'list-ul' }} me-1"></i>
                                                {{ $question['question_type'] === 'true_false' ? 'True/False' : 'Multiple Choice' }}
                                            </span>
                                            <span class="badge" style="background: #fef3c7; color: #92400e; font-size: 0.7rem; padding: 3px 10px; border-radius: 20px;">
                                                <i class="bi bi-star-fill me-1"></i>{{ number_format((float) ($question['marks'] ?? 0), 1) }} marks
                                            </span>
                                            <span class="badge-difficulty {{ $question['difficulty'] }}">
                                                <i class="bi bi-signal"></i>{{ $question['difficulty'] }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="options-group" data-question-id="{{ $question['id'] }}">
                                        @foreach ($question['options'] as $option)
                                            <label class="option-item" for="q_{{ $question['id'] }}_o_{{ $option['id'] }}">
                                                <input type="radio"
                                                       name="answers[{{ $question['id'] }}]"
                                                       value="{{ $option['id'] }}"
                                                       id="q_{{ $question['id'] }}_o_{{ $option['id'] }}"
                                                       class="option-radio"
                                                       data-question-id="{{ $question['id'] }}"
                                                       required>
                                                <span>{{ $option['option_text'] }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            {{-- Submit Button --}}
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-3">
                                <small class="text-muted" id="submit-hint">
                                    <i class="bi bi-info-circle me-1"></i>Answer all questions to submit
                                </small>
                                <button type="submit" class="btn btn-primary-custom" id="submit-quiz-btn">
                                    <i class="bi bi-check2-circle me-1"></i>Submit Quiz
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            @elseif ($selectedSkillId)
                {{-- No quiz available --}}
                <div class="form-card p-5 text-center animate-fade-up stagger-1">
                    <div class="no-quiz-illustration mb-3">
                        <i class="bi bi-journal-x" style="color: var(--gray-300);"></i>
                    </div>
                    <h5 class="fw-bold" style="color: var(--gray-700);">No Unseen Questions</h5>
                    <p class="text-muted small mb-0">
                        You may have already answered all questions for this skill.
                        Try another skill or check back later for new questions.
                    </p>
                </div>
            @endif

            {{-- QUIZ RESULT --}}
            @if (session('result'))
                @php $r = session('result'); @endphp
                <div class="form-card overflow-hidden mb-4 animate-scale">
                    <div class="card-header-gradient">
                        <h3 class="h5 fw-bold text-white mb-0">
                            <i class="bi bi-bar-chart-line me-2"></i>Quiz Results
                        </h3>
                    </div>

                    <div class="p-4">
                        {{-- Score Circle --}}
                        @php
                            $percentage = (float) $r['percentage'];
                            $scoreCircleColor = $r['passed'] ? '#059669' : '#e11d48';
                            $circumference = 2 * 22/7 * 58;
                            $offset = $circumference - ($percentage / 100) * $circumference;
                        @endphp

                        <div class="row g-4 align-items-center mb-4">
                            <div class="col-md-5 text-center">
                                <div class="score-circle">
                                    <svg width="140" height="140" viewBox="0 0 140 140">
                                        <circle cx="70" cy="70" r="58" fill="none" stroke="#e5e7eb" stroke-width="8"/>
                                        <circle cx="70" cy="70" r="58" fill="none"
                                                stroke="{{ $scoreCircleColor }}"
                                                stroke-width="8"
                                                stroke-linecap="round"
                                                stroke-dasharray="{{ $circumference }}"
                                                stroke-dashoffset="{{ $circumference }}"
                                                id="score-circle-anim"/>
                                    </svg>
                                    <div class="score-value" style="color: {{ $scoreCircleColor }};">
                                        {{ number_format($percentage, 0) }}%
                                    </div>
                                    <div class="score-label">Score</div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge-result {{ $r['passed'] ? 'passed' : 'failed' }}">
                                        <i class="bi {{ $r['passed'] ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                                        {{ $r['passed'] ? 'PASSED' : 'FAILED' }}
                                    </span>
                                    <span class="badge" style="background: #eef2ff; color: #4338ca; font-size: 0.8rem; padding: 6px 14px; border-radius: 20px;">
                                        <i class="bi bi-trophy me-1"></i>Proficiency: {{ $r['proficiency_score'] }}
                                    </span>
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="bg-light rounded-3 p-3 text-center">
                                            <p class="fs-4 fw-bold mb-0" style="color: var(--indigo);">{{ number_format((float) $r['score'], 1) }}</p>
                                            <small class="text-muted">Marks Earned</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-light rounded-3 p-3 text-center">
                                            <p class="fs-4 fw-bold mb-0" style="color: var(--gray-400);">{{ number_format((float) ($r['max_score'] - $r['score']), 1) }}</p>
                                            <small class="text-muted">Marks Lost</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Question Breakdown --}}
                        <details class="mt-3">
                            <summary class="fw-semibold" style="color: var(--indigo); cursor: pointer; font-size: 0.9rem;">
                                <i class="bi bi-list-check me-1"></i>View Question Details
                            </summary>
                            <div class="mt-3">
                                @foreach ($r['question_results'] as $qr)
                                    <div class="d-flex align-items-center gap-3 py-2 px-3 rounded-3 mb-2"
                                         style="background: {{ $qr['correct'] ? '#ecfdf5' : '#fef2f2' }}; border-left: 4px solid {{ $qr['correct'] ? '#059669' : '#e11d48' }};">
                                        <span class="fw-bold" style="color: {{ $qr['correct'] ? '#059669' : '#e11d48' }}; font-size: 1.1rem;">
                                            <i class="bi {{ $qr['correct'] ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                                        </span>
                                        <div class="flex-grow-1">
                                            <small class="fw-semibold" style="color: var(--gray-700);">
                                                Question #{{ $qr['question_id'] }}
                                            </small>
                                            <small class="d-block text-muted">
                                                {{ $qr['correct'] ? 'Correct answer' : 'Incorrect answer' }}
                                            </small>
                                        </div>
                                        <span class="badge" style="background: {{ $qr['correct'] ? '#d1fae5' : '#fee2e2' }}; color: {{ $qr['correct'] ? '#065f46' : '#991b1b' }}; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px;">
                                            <i class="bi bi-star-fill me-1"></i>{{ number_format((float) ($qr['marks'] ?? 0), 1) }} marks
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </details>
                    </div>
                </div>
            @endif

        </div>{{-- END left column --}}

{{-- ============================================================ --}}
        {{-- RIGHT COLUMN: Dashboard & Leaderboard --}}
        {{-- ============================================================ --}}
        <div class="col-lg-5">

            {{-- DASHBOARD STATS --}}
            @if ($dashboard)
                <div class="form-card overflow-hidden mb-4 animate-fade-up stagger-2">
                    <div class="card-header-gradient">
<h3 class="h5 fw-bold text-white mb-0">
                            <i class="bi bi-person-circle me-2"></i>{{ $dashboard['username'] }}
                            <span class="badge ms-2" style="background: rgba(255,255,255,0.2); color: #fff; font-size: 0.7rem;">
                                Rank #{{ $seasonRank }}
                            </span>
                        </h3>
                    </div>

                    <div class="p-4">
                        {{-- Season Score (matches dashboard) --}}
                        <div class="text-center mb-4">
                            <p class="display-4 fw-bold mb-0" style="color: var(--indigo);">
                                {{ number_format((float) $seasonScore, 1) }}
                            </p>
                            <small class="text-muted fw-semibold">
                                {{ $currentSeasonName ? $currentSeasonName . ' Score' : 'Season Score' }}
                            </small>
                        </div>

                        {{-- Stats Grid --}}
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="stat-card text-center p-3">
                                    <p class="fs-4 fw-bold mb-0" style="color: var(--purple);">{{ (int) ($dashboard['stats']['total_attempts'] ?? 0) }}</p>
                                    <small class="text-muted">Attempts</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card text-center p-3">
                                    <p class="fs-4 fw-bold mb-0" style="color: var(--teal);">{{ number_format((float) ($dashboard['stats']['average_score'] ?? 0), 1) }}%</p>
                                    <small class="text-muted">Avg Score</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- SKILL PROFICIENCY --}}
            @if ($dashboard && !empty($dashboard['skill_progress']))
                <div class="form-card overflow-hidden mb-4 animate-fade-up stagger-3">
                    <div class="card-header-gradient">
                        <h3 class="h5 fw-bold text-white mb-0">
                            <i class="bi bi-bar-chart-steps me-2"></i>Skill Proficiency
                        </h3>
                    </div>
                    <div class="p-0">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4">Skill</th>
                                    <th class="px-4 text-end">Score</th>
                                    <th class="px-4 text-end">Attempts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dashboard['skill_progress'] as $sp)
                                    <tr>
                                        <td class="px-4">
                                            <span class="fw-semibold" style="color: var(--gray-700); font-size: 0.85rem;">
                                                {{ $sp['skill_title'] }}
                                            </span>
                                        </td>
                                        <td class="px-4 text-end">
                                            <span class="fw-bold" style="color: var(--indigo);">
                                                {{ number_format((float) ($sp['proficiency_score'] ?? 0), 1) }}
                                            </span>
                                        </td>
                                        <td class="px-4 text-end">
                                            <span class="badge" style="background: #eef2ff; color: #4338ca; font-size: 0.75rem;">
                                                {{ (int) ($sp['attempts_count'] ?? 0) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

{{-- LEADERBOARD (season-based, matches /dashboard) --}}
            @if (!empty($leaderboard))
                <div class="form-card overflow-hidden mb-4 animate-fade-up stagger-4">
                    <div class="card-header-gradient">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                            <div>
                                <h3 class="h5 fw-bold text-white mb-0">
                                    <i class="bi bi-trophy-fill me-2"></i>Top 10 Leaderboard
                                </h3>
                                <p class="text-white-50 small mb-0 mt-1">{{ $currentSeasonName }}</p>
                            </div>
                            <span class="badge" style="background: rgba(255,255,255,0.2); color: #fff; font-size: 0.7rem; padding: 4px 12px; border-radius: 8px;">
                                <i class="bi bi-trophy-fill me-1"></i>Season Standings
                            </span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small text-muted text-uppercase">
                                <tr>
                                    <th class="px-4" style="width: 60px;">#</th>
                                    <th class="px-4">User</th>
                                    <th class="px-4 text-end">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaderboard as $entry)
                                    <tr @if ($entry['rank'] === 1) style="background: linear-gradient(90deg, #fef3c7, #fde68a, #fef3c7);" @elseif ($entry['rank'] === 2) style="background: linear-gradient(90deg, #f1f5f9, #e2e8f0, #f1f5f9);" @elseif ($entry['rank'] === 3) style="background: linear-gradient(90deg, #fef3c7, #ffedd5, #fef3c7);" @endif>
                                        <td class="px-4">
                                            @if ($entry['rank'] === 1)
                                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width: 32px; height: 32px; background: #f59e0b; box-shadow: 0 0 20px rgba(245,158,11,0.2);">🥇</span>
                                            @elseif ($entry['rank'] === 2)
                                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width: 32px; height: 32px; background: #9ca3af; box-shadow: 0 0 20px rgba(156,163,175,0.2);">🥈</span>
                                            @elseif ($entry['rank'] === 3)
                                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width: 32px; height: 32px; background: #d97706; box-shadow: 0 0 20px rgba(217,119,6,0.2);">🥉</span>
                                            @else
                                                <span class="d-inline-flex align-items-center justify-content-center text-muted fw-bold" style="width: 32px; height: 32px;">{{ $entry['rank'] }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4">
                                            @if ($entry['is_hidden_leaderboards'])
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-muted border" style="width: 36px; height: 36px; background: #f1f5f9;">
                                                        <i class="bi bi-eye-slash"></i>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 fst-italic text-muted small">This user decided to hide their presence.</p>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center gap-3">
                                                    @if (!empty($entry['avatar_path']))
                                                        <img src="{{ asset('storage/' . $entry['avatar_path']) }}" alt="avatar" class="rounded-circle object-fit-cover border" style="width: 36px; height: 36px;">
                                                    @else
                                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white" style="width: 36px; height: 36px; background: linear-gradient(135deg, #6366f1, #7c3aed); font-size: 0.85rem;">
                                                            {{ strtoupper(substr($entry['username'], 0, 1)) }}
                                                        </div>
                                                    @endif
                                                <div>
                                                        @if ($entry['is_profile_viewable'])
                                                            <a href="{{ route('profile.public', $entry['user_id']) }}" class="fw-semibold mb-0 text-decoration-none" style="color: #1f2937;">{{ $entry['username'] }}
                                                                @if (!empty($entry['rank_title']))
                                                                    <span data-bs-toggle="modal" data-bs-target="#rankTiersModal" style="cursor: pointer; color: #6366f1; font-weight: 600;" onclick="event.preventDefault(); event.stopPropagation();" title="View rank tiers">
                                                                        [{{ $entry['rank_title'] }}]
                                                                    </span>
                                                                @endif
                                                            </a>
                                                        @else
                                                            <p class="fw-semibold mb-0" style="color: #1f2937;">
                                                                {{ $entry['username'] }}
                                                                @if (!empty($entry['rank_title']))
                                                                    <span data-bs-toggle="modal" data-bs-target="#rankTiersModal" style="cursor: pointer; color: #6366f1; font-weight: 600;" onclick="event.preventDefault(); event.stopPropagation();" title="View rank tiers">
                                                                        [{{ $entry['rank_title'] }}]
                                                                    </span>
                                                                @endif
                                                                @if ($entry['is_profile_private'])
                                                                    <i class="bi bi-lock-fill ms-1" style="color: #94a3b8; font-size: 0.8rem;" title="Private profile"></i>
                                                                @endif
                                                            </p>
                                                        @endif
                                                        @if (!empty($entry['university_name']))
                                                            <small class="text-muted">{{ $entry['university_name'] }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 text-end">
                                            @if ($entry['is_hidden_leaderboards'])
                                                <span class="text-muted fst-italic small">Hidden</span>
                                            @else
                                                <span class="fw-bold fs-5" style="color: {{ $entry['rank'] === 1 ? '#d97706' : ($entry['rank'] === 2 ? '#64748b' : ($entry['rank'] === 3 ? '#b45309' : '#4f46e5')) }};">
                                                    {{ number_format((float) ($entry['season_score'] ?? 0), 1) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="form-card overflow-hidden mb-4 animate-fade-up stagger-4">
                    <div class="card-header-gradient">
                        <h3 class="h5 fw-bold text-white mb-0"><i class="bi bi-trophy-fill me-2"></i>Leaderboard</h3>
                    </div>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        <p class="fw-semibold mb-1">No scores yet this season.</p>
                        <p class="small mb-0">Take a quiz to get on the leaderboard!</p>
                    </div>
                </div>
            @endif

        </div>{{-- END right column --}}
    </div>{{-- END row --}}

</div>

{{--
====================================================================
RAMK TIERS MODAL
====================================================================
--}}
@include('partials.rank-tiers')

{{--
====================================================================
SCRIPTS
====================================================================
--}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function() {
    'use strict';

    // ===== 1. Progress Tracker =====
    const radios = document.querySelectorAll('.option-radio');
    const totalQuestions = {{ $quiz ? count($quiz['questions']) : 0 }};
    const progressBar = document.getElementById('quiz-progress');
    const answeredCount = document.getElementById('answered-count');
    const submitBtn = document.getElementById('submit-quiz-btn');
    const submitHint = document.getElementById('submit-hint');

    function updateProgress() {
        if (!progressBar || !answeredCount) return;

        const checked = document.querySelectorAll('.option-radio:checked').length;
        const percent = totalQuestions > 0 ? (checked / totalQuestions) * 100 : 0;

        progressBar.style.width = Math.min(percent, 100) + '%';
        progressBar.setAttribute('aria-valuenow', checked);
        answeredCount.textContent = checked;

        // Update option item selected state
        document.querySelectorAll('.option-item').forEach(item => {
            const radio = item.querySelector('input[type="radio"]');
            item.classList.toggle('selected', radio && radio.checked);
        });

        // Update submit button & hint
        if (submitBtn && submitHint) {
            if (checked === totalQuestions) {
                submitBtn.disabled = false;
                submitHint.innerHTML = '<i class="bi bi-check-circle me-1" style="color: #059669;"></i><span style="color: #059669;">All questions answered!</span>';
            } else {
                submitBtn.disabled = true;
                submitHint.innerHTML = '<i class="bi bi-info-circle me-1"></i>Answer all questions to submit (' + checked + '/' + totalQuestions + ')';
            }
        }
    }

    // Listen to all radio changes
    radios.forEach(radio => {
        radio.addEventListener('change', updateProgress);
    });

    // Initial progress update
    updateProgress();

    // ===== 2. Score Circle Animation =====
    const scoreCircle = document.getElementById('score-circle-anim');
    if (scoreCircle) {
        const circumference = parseFloat(scoreCircle.getAttribute('stroke-dasharray'));
        // Animate from full to final offset
        setTimeout(() => {
            scoreCircle.style.transition = 'stroke-dashoffset 1.2s ease-out';
            scoreCircle.setAttribute('stroke-dashoffset', '{{ $offset ?? 0 }}');
        }, 300);
    }

    // ===== 3. Smooth scroll to quiz on start =====
    @if ($quiz)
        setTimeout(() => {
            const firstQuestion = document.querySelector('.question-card');
            if (firstQuestion) {
                firstQuestion.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }, 500);
    @endif

    // ===== 4. Auto-submit prevention (double-click guard) =====
    const quizForm = document.getElementById('quiz-form');
    if (quizForm) {
        quizForm.addEventListener('submit', function(e) {
            const btn = document.getElementById('submit-quiz-btn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span>Submitting...';
            }
        });
    }

})();
</script>

@include('partials.footer')
</body>
</html>
