<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniGrowth — Student Development Platform</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #7c3aed;
            --accent: #a5b4fc;
            --dark-bg: #1e1b4b;
            --card-shadow: 0 4px 30px rgba(0,0,0,0.06);
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f0f2f5;
        }
        .bg-grid {
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .bg-dots {
            background-image: radial-gradient(rgba(99,102,241,0.08) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        .glow-1 {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            top: -150px;
            right: -100px;
            pointer-events: none;
        }
        .glow-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,0.12) 0%, transparent 70%);
            bottom: -100px;
            left: -80px;
            pointer-events: none;
        }
        .glow-3 {
            position: absolute;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(34,211,238,0.08) 0%, transparent 70%);
            top: 40%;
            right: 20%;
            pointer-events: none;
        }

        /* Hero illustration container */
.hero-illustration {
            position: relative;
            width: 100%;
            max-width: 420px;
            aspect-ratio: 5/4;
            max-height: 340px;
        }
        .hero-illustration svg {
            width: 100%;
            height: 100%;
        }
        .hero-illustration .floating-badge {
            position: absolute;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 8px 14px;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            animation: float 3s ease-in-out infinite;
        }
        .hero-illustration .floating-badge:nth-child(2) { top: 5%; right: -10%; animation-delay: 0.5s; }
        .hero-illustration .floating-badge:nth-child(3) { bottom: 15%; left: -15%; animation-delay: 1s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .badge-eco {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            background: rgba(255,255,255,0.08);
            color: #a5b4fc;
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(4px);
        }
        .tech-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 500;
            background: rgba(255,255,255,0.06);
            color: rgba(199,210,254,0.6);
            border: 1px solid rgba(255,255,255,0.06);
        }
        .tech-badge i { font-size: 0.85rem; }

        .feature-card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem 1.5rem;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 4px 24px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            border-radius: 16px 16px 0 0;
        }
        .feature-card:nth-child(1)::before { background: linear-gradient(90deg, #6366f1, #818cf8); }
        .feature-card:nth-child(2)::before { background: linear-gradient(90deg, #7c3aed, #a78bfa); }
        .feature-card:nth-child(3)::before { background: linear-gradient(90deg, #059669, #34d399); }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(99,102,241,0.12);
            border-color: rgba(99,102,241,0.15);
        }
        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .btn-outline-light-custom {
            border: 2px solid rgba(255,255,255,0.3);
            color: #fff;
            border-radius: 10px;
            padding: 10px 28px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-outline-light-custom:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.5);
            color: #fff;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #6366f1, #7c3aed);
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
        .input-field {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.9375rem;
            color: #1f2937;
            background: #f9fafb;
            transition: all 0.2s;
            outline: none;
        }
        .input-field:focus {
            border-color: #6366f1;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .form-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.06), 0 1px 8px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.04);
        }
        .stat-card {
            padding: 1.25rem;
            border-radius: 12px;
            background: #fff;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            transition: all 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99,102,241,0.1);
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

        /* Auth card with left image panel */
        .auth-image-panel {
            background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);
            position: relative;
            overflow: hidden;
            min-height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .auth-image-panel svg {
            max-width: 280px;
            height: auto;
            opacity: 0.9;
        }

        /* Season status card enhancement */
        .season-stat-item {
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            transition: all 0.2s;
            border: 1px solid transparent;
        }
        .season-stat-item:hover {
            transform: translateY(-2px);
            border-color: rgba(99,102,241,0.15);
        }

        /* Leaderboard gold/silver/bronze glow */
        .rank-glow-1 { box-shadow: 0 0 20px rgba(245,158,11,0.2); }
        .rank-glow-2 { box-shadow: 0 0 20px rgba(156,163,175,0.2); }
        .rank-glow-3 { box-shadow: 0 0 20px rgba(217,119,6,0.2); }

        /* Feature image background cards */
        .img-bg-card {
            position: relative;
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }
        .img-bg-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(30,27,75,0.7), rgba(55,48,163,0.5));
            z-index: 1;
        }
        .img-bg-card > * { position: relative; z-index: 2; }

        /* CTA section with background image feel */
        .cta-section {
            background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(99,102,241,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(139,92,246,0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Welcome banner with avatar */
        .welcome-banner {
            background: linear-gradient(135deg, #1e1b4b, #3730a3);
            border-radius: 20px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, transparent 70%);
        }
        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: 10%;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,0.15) 0%, transparent 70%);
        }

@media (max-width: 767.98px) {
            .hero-title { font-size: 2.5rem !important; }
            .hero-illustration .floating-badge { display: none; }
            .stat-card { padding: 0.75rem !important; }
            .stat-card .fs-5 { font-size: 1rem !important; }
        }
        @media (max-width: 400px) {
            body { overflow-x: hidden; }
            .hero-title { font-size: 1.8rem !important; }
            .welcome-banner { padding: 1.25rem !important; }
            .welcome-banner .col-4 { width: 30% !important; }
            .welcome-banner .col-8 { width: 70% !important; }
            .stat-card { padding: 0.5rem !important; }
            .stat-card .fs-5 { font-size: 0.85rem !important; }
            .stat-card .small { font-size: 0.65rem !important; }
            .form-card { padding: 0.75rem !important; }
            .table-admin td { font-size: 0.75rem !important; padding: 0.4rem !important; }
        }
    </style>
</head>
<body>

@if ($isAuthenticated)
    {{--
    ============================================================
    AUTHENTICATED VIEW — Dashboard
    ============================================================
    --}}
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top" style="background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="/dashboard">
                <i class="bi bi-mortarboard-fill me-2"></i>UniGrowth
            </a>
            <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" style="color: rgba(255,255,255,0.7);">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
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
                        <a href="{{ route('core-assets.index') }}#goals" class="nav-link nav-link-custom">
                            <i class="bi bi-bullseye"></i>Goals
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('core-assets.index') }}#pane-habits" class="nav-link nav-link-custom">
                            <i class="bi bi-calendar2-check"></i>Habits
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

    <div class="container py-4">
        <!-- Status Messages -->
        @if (session('status'))
            <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
                <i class="bi bi-check-circle-fill shrink-0"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
                <i class="bi bi-check-circle-fill shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
                <i class="bi bi-exclamation-triangle-fill shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Welcome Banner with Image on Left -->
        <div class="welcome-banner mb-4">
            <div class="row align-items-center position-relative">
                <div class="col-md-2 col-4 text-center mb-3 mb-md-0">
                    @php $user = auth()->user(); @endphp
                    @if (!empty($user->avatar_path))
                        <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="avatar"
                             class="rounded-circle border border-3 border-white shadow-lg" style="width: 90px; height: 90px; object-fit: cover;">
                    @else
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold border border-3 border-white shadow-lg"
                             style="width: 90px; height: 90px; background: linear-gradient(135deg, #6366f1, #7c3aed); font-size: 2.2rem;">
                            {{ strtoupper(substr($user->username, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="col-md-7 col-8">
                    <h3 class="fw-bold text-white mb-1">Welcome back, {{ $user->username }}!</h3>
                    <p class="text-white-50 small mb-0">
                        <i class="bi bi-calendar-event me-1"></i>
                        {{ $hasActiveSeason ? 'Season active — ' . $currentSeasonName : 'No active season' }}
                        &middot; <i class="bi bi-clock ms-1"></i> {{ date('l, M d, Y') }}
                    </p>
                </div>
                <div class="col-md-3 d-none d-md-flex justify-content-end">
                    <div style="width: 80px; height: 80px; opacity: 0.15;">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                    </div>
                </div>
            </div>
        </div>

<!-- Dashboard Stats Row with Icons -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 44px; height: 44px; background: #eef2ff;">
                        <i class="bi bi-calendar-event fs-5" style="color: #4f46e5;"></i>
                    </div>
                    <div class="fs-5 fw-bold" style="color: #1f2937;">{{ $hasActiveSeason ? $currentSeasonName : 'Inactive' }}</div>
                    <div class="small text-muted">Current Season</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 44px; height: 44px; background: #faf5ff;">
                        <i class="bi bi-person-circle fs-5" style="color: #7c3aed;"></i>
                    </div>
                    <div class="fs-5 fw-bold" style="color: #1f2937;">{{ auth()->user()->username ?? '—' }}</div>
                    <div class="small text-muted">Signed in as</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 44px; height: 44px; background: #ecfdf5;">
                        <i class="bi bi-trophy fs-5" style="color: #059669;"></i>
                    </div>
                    <div class="fs-5 fw-bold" style="color: #1f2937;">{{ $overviewData['season_rank'] ?? '—' }}</div>
                    <div class="small text-muted">Your Rank</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 44px; height: 44px; background: #fef3c7;">
                        <i class="bi bi-star fs-5" style="color: #d97706;"></i>
                    </div>
                    <div class="fs-5 fw-bold" style="color: #1f2937;">{{ date('M d') }}</div>
                    <div class="small text-muted">Today's Date</div>
                </div>
            </div>
        </div>

<!-- ===== Image-Text Alternating Sections (Auth View) ===== -->

        <!-- Section 1: Image Left, Text Right -->
        <div class="row g-0 align-items-center mb-4 overflow-hidden rounded-4" style="background: #f8fafc; border: 1px solid rgba(0,0,0,0.04);">
            <div class="col-md-5 p-0">
                <div style="background: linear-gradient(135deg, #eef2ff, #faf5ff); padding: 3rem 2rem; min-height: 280px; display: flex; align-items: center; justify-content: center;">
                    <div style="max-width: 220px; opacity: 0.8;">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-7 p-4 p-md-5">
                <span class="badge bg-light text-primary fw-semibold mb-2 px-3 py-2">Your Hub</span>
                <h3 class="fw-bold mb-3" style="color: #1f2937; font-size: 1.5rem;">Everything in one place</h3>
                <p class="text-muted mb-3">Your dashboard brings together goals, enrolled skills, quiz performance, and season standings — giving you a complete view of your learning journey at a glance.</p>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1" style="color: #6366f1;"></i>
                            <div><span class="fw-semibold d-block small" style="color: #1f2937;">Active Goals</span><small class="text-muted">Track progress</small></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1" style="color: #6366f1;"></i>
                            <div><span class="fw-semibold d-block small" style="color: #1f2937;">Enrolled Skills</span><small class="text-muted">Learn & grow</small></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1" style="color: #6366f1;"></i>
                            <div><span class="fw-semibold d-block small" style="color: #1f2937;">Quiz Stats</span><small class="text-muted">Measure mastery</small></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1" style="color: #6366f1;"></i>
                            <div><span class="fw-semibold d-block small" style="color: #1f2937;">Leaderboard</span><small class="text-muted">Compete & win</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Image Right, Text Left (alternating) -->
        <div class="row g-0 align-items-center mb-4 overflow-hidden rounded-4" style="background: #f8fafc; border: 1px solid rgba(0,0,0,0.04);">
            <div class="col-md-7 p-4 p-md-5 order-2 order-md-1">
                <span class="badge bg-light text-success fw-semibold mb-2 px-3 py-2">Skill Development</span>
                <h3 class="fw-bold mb-3" style="color: #1f2937; font-size: 1.5rem;">Master skills through quizzes</h3>
                <p class="text-muted mb-3">Take quizzes on your enrolled skills to test your knowledge, earn scores, and track your progress. Each quiz is dynamically generated from unseen questions, ensuring a fresh challenge every time.</p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <span class="badge" style="background: #eef2ff; color: #4f46e5; font-size: 0.8rem; padding: 6px 14px;">
                        <i class="bi bi-pencil-square me-1"></i>5 Questions
                    </span>
                    <span class="badge" style="background: #faf5ff; color: #7c3aed; font-size: 0.8rem; padding: 6px 14px;">
                        <i class="bi bi-shuffle me-1"></i>Randomized
                    </span>
                    <span class="badge" style="background: #ecfdf5; color: #059669; font-size: 0.8rem; padding: 6px 14px;">
                        <i class="bi bi-star me-1"></i>Scored
                    </span>
                </div>
            </div>
            <div class="col-md-5 p-0 order-1 order-md-2">
                <div style="background: linear-gradient(135deg, #faf5ff, #f3e8ff); padding: 3rem 2rem; min-height: 280px; display: flex; align-items: center; justify-content: center;">
                    <div style="max-width: 220px; opacity: 0.8;">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Image Left, Text Right -->
        <div class="row g-0 align-items-center mb-4 overflow-hidden rounded-4" style="background: #f8fafc; border: 1px solid rgba(0,0,0,0.04);">
            <div class="col-md-5 p-0">
                <div style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); padding: 3rem 2rem; min-height: 280px; display: flex; align-items: center; justify-content: center;">
                    <div style="max-width: 220px; opacity: 0.8;">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-7 p-4 p-md-5">
                <span class="badge bg-light text-success fw-semibold mb-2 px-3 py-2" style="color: #059669 !important;">Seasonal Growth</span>
                <h3 class="fw-bold mb-3" style="color: #1f2937; font-size: 1.5rem;">Climb the ranks each season</h3>
                <p class="text-muted mb-3">Every season brings a fresh start. Earn scores through quizzes, compete on the leaderboard, and track your rank throughout the season. Your performance carries forward with archived snapshots.</p>
                <div class="d-flex align-items-center gap-4 mt-3">
                    <div class="text-center">
                        <div class="fw-bold fs-4" style="color: #6366f1;">🏆</div>
                        <small class="text-muted">Top Rankings</small>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold fs-4" style="color: #059669;">📊</div>
                        <small class="text-muted">Score Tracking</small>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold fs-4" style="color: #7c3aed;">🎯</div>
                        <small class="text-muted">Skill Mastery</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 10 Leaderboard -->
        <div class="form-card overflow-hidden mb-4">
            <div class="px-4 py-3" style="background: linear-gradient(135deg, #6366f1, #7c3aed);">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h2 class="h5 fw-bold text-white mb-0">
                            <i class="bi bi-trophy-fill me-2"></i>Top 10 Leaderboard
                        </h2>
                        <p class="text-white-50 small mb-0 mt-1">{{ $currentSeasonName }}</p>
                    </div>
                    <span class="badge text-decoration-none" style="background: rgba(255,255,255,0.2); color: #fff; font-size: 0.75rem; padding: 6px 14px; border-radius: 8px;">
                        <i class="bi bi-trophy-fill me-1"></i>Season Standings
                    </span>
                </div>
            </div>

            @if ($hasActiveSeason && count($leaderboard) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small text-muted text-uppercase">
                            <tr>
                                <th class="px-4" style="width: 60px;">#</th>
                                <th class="px-4">User</th>
                                <th class="px-4 text-end">Score</th>
                                <th class="px-4 text-end">Skills</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaderboard as $entry)
                                <tr class="{{ $entry['rank'] <= 3 ? 'table-warning' : '' }}">
                                    <td class="px-4">
                                        @if ($entry['rank'] === 1)
                                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold rank-glow-1" style="width: 32px; height: 32px; background: #f59e0b;">🥇</span>
                                        @elseif ($entry['rank'] === 2)
                                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold rank-glow-2" style="width: 32px; height: 32px; background: #9ca3af;">🥈</span>
                                        @elseif ($entry['rank'] === 3)
                                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold rank-glow-3" style="width: 32px; height: 32px; background: #d97706;">🥉</span>
                                        @else
                                            <span class="d-inline-flex align-items-center justify-content-center text-muted fw-bold" style="width: 32px; height: 32px;">{{ $entry['rank'] }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center gap-3">
                                            @if ($entry['is_public'] && !empty($entry['avatar_path']))
                                                <img src="{{ asset('storage/' . $entry['avatar_path']) }}" alt="avatar"
                                                     class="rounded-circle object-fit-cover border" style="width: 36px; height: 36px;">
                                            @else
                                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white" style="width: 36px; height: 36px; background: linear-gradient(135deg, #6366f1, #7c3aed); font-size: 0.85rem;">
                                                    {{ strtoupper(substr($entry['username'], 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <p class="fw-semibold mb-0" style="color: #1f2937;">{{ $entry['username'] }}</p>
                                                @if ($entry['is_public'] && !empty($entry['university_name']))
                                                    <small class="text-muted">{{ $entry['university_name'] }}</small>
                                                @elseif (!$entry['is_public'])
                                                    <small class="text-muted fst-italic">Private profile</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 text-end">
                                        <span class="fw-bold fs-5 {{ $entry['rank'] === 1 ? 'text-warning' : ($entry['rank'] === 2 ? 'text-secondary' : ($entry['rank'] === 3 ? 'text-danger' : 'text-dark')) }}">
                                            {{ number_format($entry['season_score'], 1) }}
                                        </span>
                                    </td>
                                    <td class="px-4 text-end text-muted">{{ $entry['skill_count'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif ($hasActiveSeason && count($leaderboard) === 0)
                <div class="text-center py-5 text-muted bg-dots">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    <p class="fw-semibold mb-1">No scores yet this season.</p>
                    <p class="small mb-3">Take a quiz to get on the leaderboard!</p>
                    <a href="{{ route('assessment.test.index') }}" class="btn btn-primary-custom btn-sm">
                        <i class="bi bi-pencil-square me-1"></i>Take a Quiz
                    </a>
                </div>
            @else
                <div class="text-center py-5 text-muted bg-dots">
                    <i class="bi bi-pause-circle fs-1 d-block mb-2"></i>
                    <p class="fw-semibold mb-1">No active season running.</p>
                    <p class="small mb-0">Contact an administrator to start a season.</p>
                </div>
            @endif
        </div>

        @php
            $overview = $overviewData ?? [];
            $seasonInfo = $overview['season'] ?? [];
            $activeGoalsList = $overview['active_goals'] ?? [];
            $completedGoalsList = $overview['completed_goals'] ?? [];
            $quizStats = $overview['quiz_statistics'] ?? [];
            $enrolledSkillsList = $overview['enrolled_skills'] ?? [];
            $seasonRank = $overview['season_rank'] ?? null;
            $totalSeasonScore = $overview['total_season_score'] ?? 0;
        @endphp

        <!-- Season Status Banner with Image Accent -->
        <div id="season-banner" class="form-card overflow-hidden mb-4 position-relative">
            <div class="row g-0">
                <div class="col-md-9 p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-calendar-event fs-4" style="color: #6366f1;"></i>
                        <h5 class="fw-bold mb-0" style="color: #1f2937;">Current Season</h5>
                    </div>
                    <div class="row g-3">
                        @if (!empty($seasonInfo['is_active']))
                            <div class="col-6 col-md-3">
                                <div class="season-stat-item" style="background: #eef2ff;">
                                    <p class="fs-5 fw-bold mb-0" style="color: #4f46e5;">{{ $seasonInfo['season_name'] ?? 'Unnamed' }}</p>
                                    <p class="small text-muted mb-0">Season Name</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="season-stat-item" style="background: #ecfdf5;">
                                    <p class="fs-5 fw-bold mb-0" style="color: #059669;">{{ $seasonInfo['days_remaining'] ?? 0 }}</p>
                                    <p class="small text-muted mb-0">Days Remaining</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="season-stat-item" style="background: #faf5ff;">
                                    <p class="fs-5 fw-bold mb-0" style="color: #7c3aed;">#{{ $seasonRank ?? '—' }}</p>
                                    <p class="small text-muted mb-0">Your Rank</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="season-stat-item" style="background: #fef3c7;">
                                    <p class="fs-5 fw-bold mb-0" style="color: #d97706;">{{ number_format((float) $totalSeasonScore, 1) }}</p>
                                    <p class="small text-muted mb-0">Your Score</p>
                                </div>
                            </div>
                        @else
                            <div class="col-12">
                                <div class="alert d-flex align-items-center gap-2 py-3 px-4 mb-0 rounded-3" style="background: #fef3c7; color: #92400e;">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    <span><strong>No active season running.</strong> Quizzes are only available during an active season. Contact an administrator to start one.</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-3 d-none d-md-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #eef2ff, #faf5ff);">
                    <div style="width: 100px; height: 100px; opacity: 0.4;">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Analytics & Charts -->
        <div class="form-card p-4 mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-graph-up-arrow fs-4" style="color: #7c3aed;"></i>
                <h5 class="fw-bold mb-0" style="color: #1f2937;">Performance Analytics</h5>
            </div>
            @if (!empty($seasonInfo['is_active']))
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="bg-light rounded-3 p-3" style="min-height: 260px;">
                            <canvas id="quizPerformanceChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded-3 p-3" style="min-height: 260px;">
                            <canvas id="scoreDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5 text-muted bg-dots rounded-3">
                    <i class="bi bi-pause-circle fs-1 d-block mb-3"></i>
                    <p class="fw-semibold mb-1">No active season running.</p>
                    <p class="small mb-0">Performance analytics will be available once an administrator starts a new season.</p>
                </div>
            @endif
        </div>

        <!-- Overview Grid: Goals + Quiz Stats | Enrolled Skills + Quick Links -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <!-- Goals -->
                <div class="form-card p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold mb-0" style="color: #1f2937;">
                            <i class="bi bi-bullseye me-2" style="color: #059669;"></i>My Goals
                        </h5>
                        <a href="{{ route('core-assets.index') }}#goals" class="small text-decoration-none" style="color: #6366f1;">
                            Manage <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    @if (!empty($activeGoalsList))
                        <ul class="list-unstyled mb-0">
                            @foreach ($activeGoalsList as $goal)
                                <li class="d-flex align-items-start gap-3 py-2 border-bottom border-light">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center shrink-0" style="width: 36px; height: 36px; background: #eef2ff; color: #4f46e5; font-size: 0.8rem;">
                                        <i class="bi bi-pin-angle-fill"></i>
                                    </div>
                                    <div class="grow min-width-0">
                                        <p class="fw-semibold mb-0" style="color: #1f2937; font-size: 0.9rem;">{{ $goal['text'] ?? 'Goal' }}</p>
                                        <small class="text-muted">{{ !empty($goal['created_at']) ? \Carbon\Carbon::parse($goal['created_at'])->diffForHumans() : 'Recently added' }}</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted bg-dots rounded-3">
                            <i class="bi bi-bullseye fs-2 d-block mb-2"></i>
                            <p class="small mb-0">No active goals. <a href="{{ route('core-assets.index') }}#goals" class="text-decoration-none" style="color: #6366f1;">Create one</a>.</p>
                        </div>
                    @endif

                    <details class="mt-3">
                        <summary class="text-sm fw-semibold text-muted cursor-pointer" style="font-size: 0.85rem;">
                            Completed Goals ({{ count($completedGoalsList) }})
                        </summary>
                        <div class="mt-2">
                            @if (!empty($completedGoalsList))
                                @foreach ($completedGoalsList as $goal)
                                    <div class="d-flex align-items-start gap-3 py-2 border-bottom border-light">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: #ecfdf5; color: #059669; font-size: 0.8rem;">
                                            <i class="bi bi-check2-circle"></i>
                                        </div>
                                        <div class="flex-grow-1 min-width-0">
                                            <p class="fw-semibold mb-0 text-decoration-line-through text-muted" style="font-size: 0.9rem;">{{ $goal['text'] ?? 'Goal' }}</p>
                                            <small class="text-muted">Completed {{ !empty($goal['completed_at']) ? \Carbon\Carbon::parse($goal['completed_at'])->diffForHumans() : 'recently' }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted small mb-0">No completed goals yet.</p>
                            @endif
                        </div>
                    </details>
                </div>

                <!-- Habits Summary -->
                <div class="form-card p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold mb-0" style="color: #1f2937;">
                            <i class="bi bi-calendar2-check me-2" style="color: #7c3aed;"></i>My Habits
                        </h5>
                        <a href="{{ route('core-assets.index') }}#pane-habits" class="small text-decoration-none" style="color: #6366f1;">
                            Manage <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <p class="fs-3 fw-bold mb-0" style="color: #7c3aed;">{{ $habitSummary['total'] }}</p>
                                <p class="small text-muted mb-0">Habits</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <p class="fs-3 fw-bold mb-0" style="color: #059669;">{{ $habitSummary['completed_today'] }}</p>
                                <p class="small text-muted mb-0">Done Today</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <p class="fs-3 fw-bold mb-0" style="color: #d97706;">{{ $habitSummary['best_streak'] }}</p>
                                <p class="small text-muted mb-0">Best Streak</p>
                            </div>
                        </div>
                    </div>
                    @if ($habitSummary['total'] === 0)
                        <div class="text-center py-3 mt-3 text-muted bg-dots rounded-3">
                            <i class="bi bi-calendar2-check fs-4 d-block mb-1"></i>
                            <p class="small mb-0">No habits yet. <a href="{{ route('core-assets.index') }}#pane-habits" class="text-decoration-none" style="color: #6366f1;">Create one</a>.</p>
                        </div>
                    @endif
                </div>

                <!-- Quiz Stats -->
                <div class="form-card p-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-pencil-square fs-4" style="color: #6366f1;"></i>
                        <h5 class="fw-bold mb-0" style="color: #1f2937;">Quiz Statistics</h5>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <p class="fs-3 fw-bold mb-0" style="color: #6366f1;">{{ (int) ($quizStats['total_questions_answered'] ?? 0) }}</p>
                                <p class="small text-muted mb-0">Questions Answered</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <p class="fs-3 fw-bold mb-0" style="color: #7c3aed;">{{ (int) ($quizStats['total_attempts'] ?? 0) }}</p>
                                <p class="small text-muted mb-0">Quiz Attempts</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <p class="fs-3 fw-bold mb-0" style="color: #0891b2;">{{ number_format((float) ($quizStats['total_score'] ?? 0), 1) }}</p>
                                <p class="small text-muted mb-0">Total Score</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <p class="fs-3 fw-bold mb-0" style="color: #059669;">{{ number_format((float) ($quizStats['average_score_per_attempt'] ?? 0), 1) }}%</p>
                                <p class="small text-muted mb-0">Avg Score/Attempt</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Enrolled Skills -->
                <div class="form-card p-4 mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold mb-0" style="color: #1f2937;">
                            <i class="bi bi-bookmark-check me-2" style="color: #7c3aed;"></i>Enrolled Skills
                            <span class="badge rounded-pill ms-1" style="background: #eef2ff; color: #4f46e5; font-size: 0.7rem;">{{ count($enrolledSkillsList) }}</span>
                        </h5>
                        <a href="{{ route('core-assets.skills') }}" class="small text-decoration-none" style="color: #6366f1;">
                            Browse <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    @if (!empty($enrolledSkillsList))
                        @foreach ($enrolledSkillsList as $skill)
                            <div class="d-flex align-items-center justify-content-between py-2 border-bottom border-light">
                                <div class="flex-grow-1 min-width-0 me-2">
                                    <p class="fw-semibold mb-0 text-truncate" style="color: #1f2937; font-size: 0.9rem;">
                                        <i class="bi bi-book me-1" style="color: #7c3aed;"></i>{{ $skill['skill_title'] ?? 'Skill' }}
                                    </p>
                                    <small class="text-muted">Enrolled {{ !empty($skill['enrolled_at']) ? \Carbon\Carbon::parse($skill['enrolled_at'])->diffForHumans() : 'recently' }}</small>
                                </div>
                                <a href="{{ route('assessment.test.index') }}?skill_id={{ $skill['skill_id'] ?? '' }}" class="btn btn-sm flex-shrink-0" style="background: #6366f1; color: #fff; border-radius: 8px; font-size: 0.75rem;">
                                    <i class="bi bi-pencil-square me-1"></i>Quiz
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted bg-dots rounded-3">
                            <i class="bi bi-book fs-2 d-block mb-2"></i>
                            <p class="small mb-0">Not enrolled in any skills yet. <a href="{{ route('core-assets.skills') }}" class="text-decoration-none" style="color: #6366f1;">Browse skills</a>.</p>
                        </div>
                    @endif
                </div>

</div>
            </div>
</div>

    @include('partials.footer')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const stats = @json($quizStats);
        const seasonInfo = @json($seasonInfo);
        const maxMarks = seasonInfo.highest_score || 0;

        const barCtx = document.getElementById('quizPerformanceChart');
        if (barCtx) {
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Questions Answered', 'Quiz Attempts', 'Total Score', 'Avg Score/Attempt'],
                    datasets: [{
                        label: 'Performance Metrics',
                        data: [
                            stats.total_questions_answered || 0,
                            stats.total_attempts || 0,
                            stats.total_score || 0,
                            stats.average_score_per_attempt || 0
                        ],
                        backgroundColor: [
                            'rgba(99, 102, 241, 0.7)',
                            'rgba(124, 58, 237, 0.7)',
                            'rgba(8, 145, 178, 0.7)',
                            'rgba(5, 150, 105, 0.7)'
                        ],
                        borderColor: [
                            'rgba(99, 102, 241, 1)',
                            'rgba(124, 58, 237, 1)',
                            'rgba(8, 145, 178, 1)',
                            'rgba(5, 150, 105, 1)'
                        ],
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataset.label || '';
                                    const val = context.parsed.y;
                                    if (context.dataIndex === 3) return label + ': ' + val.toFixed(1) + '%';
                                    if (context.dataIndex === 2) return label + ': ' + val.toFixed(1) + ' of ' + maxMarks.toFixed(1) + ' max marks';
                                    return label + ': ' + val.toFixed(1);
                                }
                            }
                        }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        const doughnutCtx = document.getElementById('scoreDistributionChart');
        if (doughnutCtx) {
            const totalScore = stats.total_score || 0;
            const maxPossible = maxMarks > 0 ? maxMarks : Math.max(totalScore * 2, 100);
            const remaining = Math.max(0, maxPossible - totalScore);

            new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Your Score', 'Remaining Potential'],
                    datasets: [{
                        data: [totalScore, remaining],
                        backgroundColor: ['rgba(99, 102, 241, 0.8)', 'rgba(229, 231, 235, 0.6)'],
                        borderColor: ['rgba(99, 102, 241, 1)', 'rgba(229, 231, 235, 1)'],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, padding: 12, font: { size: 11 } } },
                        tooltip: { callbacks: { label: function(context) { return context.label + ': ' + context.parsed.toFixed(1); } } }
                    }
                }
            });
        }
    });
    </script>

@else
    {{--
    ============================================================
    GUEST / UNAUTHENTICATED VIEW — Landing Page with SVG Illustration
    ============================================================
    --}}

    <!-- Hero Section with SVG Illustration -->
    <div class="position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87); min-height: 90vh;">
        <div class="glow-1"></div>
        <div class="glow-2"></div>
        <div class="glow-3"></div>
        <div class="bg-grid position-absolute top-0 start-0 w-100 h-100"></div>

        <div class="container position-relative" style="z-index: 10;">
            <!-- Top Navigation -->
            <nav class="navbar navbar-dark p-0 pt-3">
                <div class="container-fluid px-0">
                    <span class="navbar-brand fw-bold fs-4">
                        <i class="bi bi-mortarboard-fill me-2"></i>UniGrowth
                    </span>
                    <div class="d-flex gap-2">
                        <a href="/login" class="btn btn-outline-light-custom btn-sm">Sign In</a>
                        <a href="/register" class="btn btn-primary-custom btn-sm">Get Started</a>
                    </div>
                </div>
            </nav>

            <!-- Hero Content: Text Left, SVG Illustration Right -->
            <div class="row align-items-center" style="min-height: 80vh;">
                <div class="col-lg-6 text-white py-5">
                    <div class="mb-4">
                        <span class="badge-eco">
                            <i class="bi bi-mortarboard-fill" style="font-size: 0.8rem;"></i>
                            Student Development Platform
                        </span>
                    </div>
                    <h1 class="display-3 fw-bold mb-3 hero-title" style="line-height: 1.1;">
                        Grow Your Skills.<br>
                        <span style="background: linear-gradient(90deg, #a5b4fc, #c4b5fd); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Track Your Journey.</span>
                    </h1>
                    <p class="fs-5 mb-4" style="color: rgba(199,210,254,0.8); max-width: 540px;">
                        UniGrowth is the all-in-one platform for university students to set goals,
                        develop new skills, and track personal growth throughout their academic journey.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <span class="tech-badge"><i class="bi bi-bootstrap-fill"></i> Bootstrap 5</span>
                        <span class="tech-badge"><i class="bi bi-filetype-php"></i> PHP / Laravel</span>
                        <span class="tech-badge"><i class="bi bi-code-slash"></i> Blade Engine</span>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="/register" class="btn btn-primary-custom">
                            <i class="bi bi-person-plus me-2"></i>Create Free Account
                        </a>
                        <a href="/login" class="btn btn-outline-light-custom">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center">
                    <div class="hero-illustration">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                        <!-- Floating badges over illustration -->
                        <div class="floating-badge">
                            <i class="bi bi-star-fill" style="color: #fbbf24;"></i> Top 10%
                        </div>
                        <div class="floating-badge">
                            <i class="bi bi-graph-up-arrow" style="color: #34d399;"></i> +45% Growth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section with Image-Text pattern -->
    <div class="container py-5 my-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #1f2937;">Everything you need to grow</h2>
            <p class="text-muted">A complete ecosystem for student development</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: #eef2ff; color: #6366f1;">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h5 class="fw-bold" style="color: #1f2937;">Set Goals</h5>
                    <p class="text-muted small mb-0">Define academic and personal goals, track progress, and celebrate achievements throughout your university journey.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: #faf5ff; color: #7c3aed;">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h5 class="fw-bold" style="color: #1f2937;">Develop Skills</h5>
                    <p class="text-muted small mb-0">Enroll in skill tracks, take quizzes, and build competencies that matter for your career and personal development.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon" style="background: #ecfdf5; color: #059669;">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <h5 class="fw-bold" style="color: #1f2937;">Track Growth</h5>
                    <p class="text-muted small mb-0">Monitor your progress with detailed analytics, seasonal leaderboards, and personalized insights.</p>
                </div>
            </div>
        </div>

<!-- ===== Image-Text Alternating Sections ===== -->

        <!-- Section 1: Image Left, Text Right -->
        <div class="row g-0 align-items-center mt-5 overflow-hidden rounded-4" style="background: #f8fafc; border: 1px solid rgba(0,0,0,0.04);">
            <div class="col-md-5 p-0">
                <div style="background: linear-gradient(135deg, #eef2ff, #faf5ff); padding: 3rem 2rem; min-height: 300px; display: flex; align-items: center; justify-content: center;">
                    <div style="max-width: 240px; opacity: 0.8;">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-7 p-4 p-md-5">
                <span class="badge bg-light text-primary fw-semibold mb-2 px-3 py-2">Why UniGrowth?</span>
                <h3 class="fw-bold mb-3" style="color: #1f2937; font-size: 1.6rem;">Built for university students, by developers</h3>
                <p class="text-muted mb-3">Track your skill development journey with personalized recommendations, leaderboards, and detailed analytics — all in one platform designed for academic growth.</p>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1" style="color: #059669;"></i>
                            <div><span class="fw-semibold d-block" style="color: #1f2937;">Goal Setting</span><small class="text-muted">Define and track goals</small></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1" style="color: #059669;"></i>
                            <div><span class="fw-semibold d-block" style="color: #1f2937;">Skill Quizzes</span><small class="text-muted">Test your knowledge</small></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1" style="color: #059669;"></i>
                            <div><span class="fw-semibold d-block" style="color: #1f2937;">Leaderboards</span><small class="text-muted">Compete with peers</small></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1" style="color: #059669;"></i>
                            <div><span class="fw-semibold d-block" style="color: #1f2937;">Analytics</span><small class="text-muted">Track your progress</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Image Right, Text Left (alternating) -->
        <div class="row g-0 align-items-center mt-4 overflow-hidden rounded-4" style="background: #f8fafc; border: 1px solid rgba(0,0,0,0.04);">
            <div class="col-md-7 p-4 p-md-5 order-2 order-md-1">
                <span class="badge bg-light text-success fw-semibold mb-2 px-3 py-2">Personalized Learning</span>
                <h3 class="fw-bold mb-3" style="color: #1f2937; font-size: 1.6rem;">Smart recommendations tailored to you</h3>
                <p class="text-muted mb-3">Our recommendation engine analyzes your enrolled skills, interests, and performance to suggest the most relevant skills and learning paths — helping you discover new areas to grow.</p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <span class="badge" style="background: #eef2ff; color: #4f46e5; font-size: 0.8rem; padding: 6px 14px;">
                        <i class="bi bi-stars me-1"></i>Jaccard Similarity
                    </span>
                    <span class="badge" style="background: #faf5ff; color: #7c3aed; font-size: 0.8rem; padding: 6px 14px;">
                        <i class="bi bi-tag me-1"></i>Tag Intersection
                    </span>
                    <span class="badge" style="background: #ecfdf5; color: #059669; font-size: 0.8rem; padding: 6px 14px;">
                        <i class="bi bi-graph-up me-1"></i>Performance Based
                    </span>
                </div>
            </div>
            <div class="col-md-5 p-0 order-1 order-md-2">
                <div style="background: linear-gradient(135deg, #faf5ff, #f3e8ff); padding: 3rem 2rem; min-height: 300px; display: flex; align-items: center; justify-content: center;">
                    <div style="max-width: 240px; opacity: 0.8;">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Image Left, Text Right -->
        <div class="row g-0 align-items-center mt-4 overflow-hidden rounded-4" style="background: #f8fafc; border: 1px solid rgba(0,0,0,0.04);">
            <div class="col-md-5 p-0">
                <div style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); padding: 3rem 2rem; min-height: 300px; display: flex; align-items: center; justify-content: center;">
                    <div style="max-width: 240px; opacity: 0.8;">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-7 p-4 p-md-5">
                <span class="badge bg-light text-success fw-semibold mb-2 px-3 py-2" style="color: #059669 !important;">Track & Compete</span>
                <h3 class="fw-bold mb-3" style="color: #1f2937; font-size: 1.6rem;">Seasonal competitions and leaderboards</h3>
                <p class="text-muted mb-3">Participate in seasonal competitions where you can earn scores, climb the leaderboard, and compare your progress with peers. Each season brings fresh opportunities to showcase your skills.</p>
                <div class="d-flex align-items-center gap-4 mt-3">
                    <div class="text-center">
                        <div class="fw-bold fs-4" style="color: #6366f1;">🏆</div>
                        <small class="text-muted">Top Rankings</small>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold fs-4" style="color: #059669;">📊</div>
                        <small class="text-muted">Score Tracking</small>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold fs-4" style="color: #7c3aed;">🎯</div>
                        <small class="text-muted">Skill Mastery</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section with Background Image Feel -->
    <div class="cta-section py-5">
        <div class="container text-center py-4 position-relative">
            <h2 class="fw-bold text-white mb-2">Ready to start your journey?</h2>
            <p class="text-white-50 mb-4" style="color: rgba(199,210,254,0.7) !important;">Join students who are already growing with UniGrowth.</p>
            <a href="/register" class="btn btn-primary-custom btn-lg px-5">
                <i class="bi bi-rocket-takeoff me-2"></i>Get Started Free
            </a>
        </div>
    </div>

<!-- Footer -->
    @include('partials.footer', ['hideQuickLinks' => true])
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
