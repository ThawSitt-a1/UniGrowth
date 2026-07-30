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

        <!-- Status Messages (from email verification, password reset, season actions, etc.) -->
        @if (session('status'))
            <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
                <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

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

        @if (!session('status') && !session('success') && !session('error'))
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

        <!-- ============================================================ -->
        <!-- OVERVIEW SECTIONS (Rendered server-side for authenticated users) -->
        <!-- ============================================================ -->

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

        <!-- Season Status Banner -->
        <div id="season-banner" class="form-card p-4 mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-calendar-event fs-4" style="color: #6366f1;"></i>
                <h5 class="fw-bold mb-0" style="color: #1f2937;">Current Season</h5>
            </div>
            <div class="row g-3">
                @if (!empty($seasonInfo['is_active']))
                    <div class="col-6 col-md-3">
                        <div class="rounded p-3 text-center" style="background: #eef2ff;">
                            <p class="fs-5 fw-bold mb-0" style="color: #4f46e5;">{{ $seasonInfo['season_name'] ?? 'Unnamed' }}</p>
                            <p class="small text-muted mb-0">Season Name</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="rounded p-3 text-center" style="background: #ecfdf5;">
                            <p class="fs-5 fw-bold mb-0" style="color: #059669;">{{ $seasonInfo['days_remaining'] ?? 0 }}</p>
                            <p class="small text-muted mb-0">Days Remaining</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="rounded p-3 text-center" style="background: #faf5ff;">
                            <p class="fs-5 fw-bold mb-0" style="color: #7c3aed;">#{{ $seasonRank ?? '—' }}</p>
                            <p class="small text-muted mb-0">Your Rank</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="rounded p-3 text-center" style="background: #fef3c7;">
                            <p class="fs-5 fw-bold mb-0" style="color: #d97706;">{{ number_format((float) $totalSeasonScore, 1) }}</p>
                            <p class="small text-muted mb-0">Season Score</p>
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

        <!-- Performance Analytics & Charts -->
        <div class="form-card p-4 mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-graph-up-arrow fs-4" style="color: #7c3aed;"></i>
                <h5 class="fw-bold mb-0" style="color: #1f2937;">Performance Analytics</h5>
            </div>
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
        </div>

        <!-- Overview Grid: Goals + Quiz Stats | Enrolled Skills + Quick Links -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
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
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: #eef2ff; color: #4f46e5; font-size: 0.8rem;">
                                        <i class="bi bi-pin-angle-fill"></i>
                                    </div>
                                    <div class="flex-grow-1 min-width-0">
                                        <p class="fw-semibold mb-0" style="color: #1f2937; font-size: 0.9rem;">{{ $goal['text'] ?? 'Goal' }}</p>
                                        <small class="text-muted">{{ !empty($goal['created_at']) ? \Carbon\Carbon::parse($goal['created_at'])->diffForHumans() : 'Recently added' }}</small>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-3 text-muted">
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
                                <div class="space-y-2">
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
                                </div>
                            @else
                                <p class="text-muted small mb-0">No completed goals yet.</p>
                            @endif
                        </div>
                    </details>
                </div>

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
                        <div class="space-y-2">
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
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="bi bi-book fs-2 d-block mb-2"></i>
                            <p class="small mb-0">Not enrolled in any skills yet. <a href="{{ route('core-assets.skills') }}" class="text-decoration-none" style="color: #6366f1;">Browse skills</a>.</p>
                        </div>
                    @endif
                </div>

                <div class="form-card p-4 mb-4">
                    <h5 class="fw-bold mb-3" style="color: #1f2937;">
                        <i class="bi bi-calendar-event me-2" style="color: #d97706;"></i>Season Actions
                    </h5>
                    @if ($hasActiveSeason)
                        <form action="{{ route('overview.season.end') }}" method="POST" onsubmit="return confirm('End the current season? This will snapshot scores and reset platform scores for all users.')">
                            @csrf
                            <button type="submit" class="btn btn-sm w-100" style="background: #fee2e2; color: #b91c1c; border-radius: 8px;">
                                <i class="bi bi-stop-circle me-1"></i>End Current Season
                            </button>
                        </form>
                        <p class="small text-muted mt-2 mb-0">Snapshot scores, reset platform scores, and create a new season.</p>
                    @else
                        <p class="small text-muted mb-0">No active season to end.</p>
                    @endif
                </div>

                <div class="form-card p-4">
                    <h5 class="fw-bold mb-3" style="color: #1f2937;">
                        <i class="bi bi-link-45deg me-2" style="color: #6366f1;"></i>Quick Links
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('assessment.test.index') }}" class="btn btn-sm" style="background: #eef2ff; color: #4f46e5; border-radius: 8px;">
                            <i class="bi bi-pencil-square me-1"></i>Take a Quiz
                        </a>
                        <a href="{{ route('core-assets.index') }}#goals" class="btn btn-sm" style="background: #ecfdf5; color: #059669; border-radius: 8px;">
                            <i class="bi bi-plus-circle me-1"></i>Create Goal
                        </a>
                        <a href="{{ route('core-assets.skills') }}" class="btn btn-sm" style="background: #faf5ff; color: #7c3aed; border-radius: 8px;">
                            <i class="bi bi-search me-1"></i>Browse Skills
                        </a>
                        <a href="{{ route('core.test-recommendations.index') }}" class="btn btn-sm" style="background: #fef3c7; color: #d97706; border-radius: 8px;">
                            <i class="bi bi-stars me-1"></i>Recommendations
                        </a>
                        <a href="{{ route('profile.show') }}" class="btn btn-sm" style="background: #f3e8ff; color: #9333ea; border-radius: 8px;">
                            <i class="bi bi-person me-1"></i>My Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const stats = @json($quizStats);
        const seasonInfo = @json($seasonInfo);

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
                                    if (context.dataIndex === 3) {
                                        return label + ': ' + val.toFixed(1) + '%';
                                    }
                                    return label + ': ' + val.toFixed(1);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        const doughnutCtx = document.getElementById('scoreDistributionChart');
        if (doughnutCtx) {
            const totalScore = stats.total_score || 0;
            const maxPossible = Math.max(totalScore * 2, 100);
            const remaining = Math.max(0, maxPossible - totalScore);

            new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Your Score', 'Remaining Potential'],
                    datasets: [{
                        data: [totalScore, remaining],
                        backgroundColor: [
                            'rgba(99, 102, 241, 0.8)',
                            'rgba(229, 231, 235, 0.6)'
                        ],
                        borderColor: [
                            'rgba(99, 102, 241, 1)',
                            'rgba(229, 231, 235, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 12,
                                font: { size: 11 }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed.toFixed(1);
                                }
                            }
                        }
                    }
                }
            });
        }
    });
    </script>

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

