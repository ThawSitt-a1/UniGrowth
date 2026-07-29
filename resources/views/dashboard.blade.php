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
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .bg-grid {
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
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
        }
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
        .nav-quick-link {
            color: rgba(255,255,255,0.7);
            font-size: 0.8rem;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .nav-quick-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.1);
        }
        @media (max-width: 767.98px) {
            .hero-title {
                font-size: 2.5rem !important;
            }
        }
    </style>
</head>
<body>

@if ($isAuthenticated)
    {{--
    ============================================================
    AUTHENTICATED VIEW
    ============================================================
    --}}
    <nav class="navbar navbar-expand-lg sticky-top" style="background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="/dashboard">
                <i class="bi bi-mortarboard-fill me-2"></i>UniGrowth
            </a>

            <!-- Toggler for mobile -->
            <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" style="color: rgba(255,255,255,0.7);">
                <i class="bi bi-list fs-4"></i>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <!-- Quick Links as Nav Items -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a href="{{ route('overview.index') }}" class="nav-link nav-link-custom">
                            <i class="bi bi-bar-chart-line"></i>Overview
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
                            <i class="bi bi-gear"></i>Assets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('core.test-recommendations.index') }}" class="nav-link nav-link-custom">
                            <i class="bi bi-stars"></i>Recommend
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('core-assets.index') }}#goals" class="nav-link nav-link-custom">
                            <i class="bi bi-bullseye"></i>Goals
                        </a>
                    </li>
                </ul>

                <!-- Right side: Avatar + Logout -->
                <div class="d-flex align-items-center gap-3">
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

        <!-- Status Messages (from email verification, password reset, etc.) -->
        @if (session('status'))
            <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
                <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                <span>{{ session('status') }}</span>
            </div>
        @else
            <!-- Welcome back message (shown on normal login, not after email verification) -->
            <div class="d-flex align-items-center gap-2 mb-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 42px; height: 42px; background: linear-gradient(135deg, #6366f1, #7c3aed); font-size: 1rem;">
                    <i class="bi bi-hand-wave"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="color: #1f2937;">Welcome back, {{ auth()->user()->username }}!</h5>
                    <small class="text-muted">{{ $hasActiveSeason ? 'Season active — ' . $currentSeasonName : 'No active season' }}</small>
                </div>
            </div>
        @endif

        <!-- Email Verification Notice -->
        @if (!auth()->user()->hasVerifiedEmail())
            <div class="alert alert-warning d-flex align-items-start gap-3 py-3 px-4 mb-4 rounded-3 small" role="alert">
                <i class="bi bi-shield-exclamation flex-shrink-0 mt-1"></i>
                <div>
                    <p class="fw-semibold mb-1">Your email is not yet verified.</p>
                    <p class="mb-2">Please check your inbox for the verification link.</p>
                    <form action="{{ route('verification.send') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm text-decoration-underline p-0 border-0 bg-transparent" style="color: #856404;">
                            <i class="bi bi-send me-1"></i>Resend verification email
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Dashboard Stats Row -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card text-center">
                    <div class="fs-3 fw-bold" style="color: #6366f1;">{{ count($leaderboard) }}</div>
                    <div class="small text-muted">Leaderboard Entries</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card text-center">
                    <div class="fs-3 fw-bold" style="color: #7c3aed;">{{ $hasActiveSeason ? 'Active' : 'Inactive' }}</div>
                    <div class="small text-muted">Current Season</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card text-center">
                    <div class="fs-3 fw-bold" style="color: #0891b2;">{{ auth()->user()->username ?? '—' }}</div>
                    <div class="small text-muted">Signed in as</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card text-center">
                    <div class="fs-3 fw-bold" style="color: #059669;">{{ date('M d') }}</div>
                    <div class="small text-muted">Today's Date</div>
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
                    <a href="{{ route('overview.index') }}" class="badge text-decoration-none" style="background: rgba(255,255,255,0.2); color: #fff; font-size: 0.75rem; padding: 6px 14px; border-radius: 8px;">
                        Full Overview <i class="bi bi-arrow-right ms-1"></i>
                    </a>
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
                                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width: 32px; height: 32px; background: #f59e0b;">🥇</span>
                                        @elseif ($entry['rank'] === 2)
                                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width: 32px; height: 32px; background: #9ca3af;">🥈</span>
                                        @elseif ($entry['rank'] === 3)
                                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width: 32px; height: 32px; background: #d97706;">🥉</span>
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
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    <p class="fw-semibold mb-1">No scores yet this season.</p>
                    <p class="small mb-3">Take a quiz to get on the leaderboard!</p>
                    <a href="{{ route('assessment.test.index') }}" class="btn btn-primary-custom btn-sm">
                        <i class="bi bi-pencil-square me-1"></i>Take a Quiz
                    </a>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-pause-circle fs-1 d-block mb-2"></i>
                    <p class="fw-semibold mb-1">No active season running.</p>
                    <p class="small mb-0">Contact an administrator to start a season.</p>
                </div>
            @endif
        </div>

        <!-- Recent Enrolled Skills + Recent Goals Row -->
        <div class="row g-4 mb-4">

            <!-- Recent Enrolled Skills -->
            <div class="col-md-6">
                <div class="form-card p-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold mb-0" style="color: #1f2937;">
                            <i class="bi bi-bookmark-check me-2" style="color: #7c3aed;"></i>Recent Enrolled Skills
                        </h5>
                        <a href="{{ route('core-assets.skills') }}" class="small text-decoration-none" style="color: #6366f1;">
                            View all <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    @if ($recentEnrolledSkills->count() > 0)
                        <ul class="list-unstyled mb-0">
                            @foreach ($recentEnrolledSkills as $enrollment)
                                <li class="d-flex align-items-center gap-3 py-2 border-bottom border-light">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0" style="width: 36px; height: 36px; background: linear-gradient(135deg, #6366f1, #7c3aed); font-size: 0.8rem;">
                                        <i class="bi bi-book"></i>
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <p class="fw-semibold mb-0 text-truncate" style="color: #1f2937; font-size: 0.9rem;">
                                            {{ $enrollment->skill->title ?? 'Unknown Skill' }}
                                        </p>
                                        <small class="text-muted">Enrolled {{ $enrollment->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span class="badge rounded-pill" style="background: #eef2ff; color: #4f46e5; font-size: 0.7rem;">
                                        {{ $enrollment->skill->tags[0] ?? 'General' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-book fs-2 d-block mb-2"></i>
                            <p class="small mb-0">No skills enrolled yet.</p>
                            <a href="{{ route('core-assets.skills') }}" class="btn btn-sm mt-2" style="background: #eef2ff; color: #4f46e5; border-radius: 8px;">
                                <i class="bi bi-search me-1"></i>Browse Skills
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Goals -->
            <div class="col-md-6">
                <div class="form-card p-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold mb-0" style="color: #1f2937;">
                            <i class="bi bi-bullseye me-2" style="color: #059669;"></i>Recent Goals
                        </h5>
                        <a href="{{ route('core-assets.index') }}#goals" class="small text-decoration-none" style="color: #6366f1;">
                            View all <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    @if ($recentGoals->count() > 0)
                        <ul class="list-unstyled mb-0">
                            @foreach ($recentGoals as $goal)
                                <li class="d-flex align-items-center gap-3 py-2 border-bottom border-light">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: #ecfdf5; color: #059669; font-size: 0.8rem;">
                                        <i class="bi bi-check2-circle"></i>
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <p class="fw-semibold mb-0 text-truncate" style="color: #1f2937; font-size: 0.9rem;">
                                            {{ $goal->text }}
                                        </p>
                                        <small class="text-muted">{{ $goal->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span class="badge rounded-pill" style="background: #fef3c7; color: #d97706; font-size: 0.7rem;">
                                        {{ $goal->status }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-bullseye fs-2 d-block mb-2"></i>
                            <p class="small mb-0">No goals created yet.</p>
                            <a href="{{ route('core-assets.index') }}#goals" class="btn btn-sm mt-2" style="background: #ecfdf5; color: #059669; border-radius: 8px;">
                                <i class="bi bi-plus-circle me-1"></i>Create a Goal
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

@else
    {{--
    ============================================================
    GUEST / UNAUTHENTICATED VIEW — Landing Page
    ============================================================
    --}}

    <!-- Hero Section -->
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

            <!-- Hero Content -->
            <div class="row align-items-center" style="min-height: 80vh;">
                <div class="col-lg-7 text-white py-5">
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
                <div class="col-lg-5 d-none d-lg-flex justify-content-center">
                    <div class="text-center">
                        <div style="width: 280px; height: 280px; border-radius: 40px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; flex-direction: column; padding: 2rem; backdrop-filter: blur(8px);">
                            <i class="bi bi-mortarboard-fill" style="font-size: 4rem; color: rgba(165,180,252,0.3);"></i>
                            <p class="text-white-50 small mt-3 mb-0" style="color: rgba(199,210,254,0.5) !important;">Empowering student growth</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
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
    </div>

    <!-- CTA Section -->
    <div style="background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);" class="py-5">
        <div class="container text-center py-4">
            <h2 class="fw-bold text-white mb-2">Ready to start your journey?</h2>
            <p class="text-white-50 mb-4" style="color: rgba(199,210,254,0.7) !important;">Join students who are already growing with UniGrowth.</p>
            <a href="/register" class="btn btn-primary-custom btn-lg px-5">
                <i class="bi bi-rocket-takeoff me-2"></i>Get Started Free
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4 text-center small text-muted" style="background: #f9fafb;">
        &copy; {{ date('Y') }} UniGrowth. All rights reserved.
    </footer>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

