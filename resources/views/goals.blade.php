<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $platformName ?? 'UniGrowth' }} — My Goals & Habits</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f5f7fa;
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
        .form-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.06), 0 1px 8px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.04);
        }
        .btn-gradient {
            padding: 10px 24px;
            border: none;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(99,102,241,0.35);
            color: #fff;
        }
        .btn-gradient-sm {
            padding: 5px 14px;
            font-size: 0.78rem;
            border-radius: 8px;
        }
        .btn-outline-custom {
            border: 2px solid #6366f1;
            color: #6366f1;
            background: transparent;
            border-radius: 10px;
            padding: 6px 16px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-outline-custom:hover {
            background: #6366f1;
            color: #fff;
        }
        .goal-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,0.06);
            padding: 1rem 1.25rem;
            transition: all 0.2s;
        }
        .goal-card:hover {
            border-color: rgba(99,102,241,0.2);
            box-shadow: 0 4px 16px rgba(99,102,241,0.06);
        }
        .goal-card.completed {
            background: #f0fdf4;
            border-color: #bbf7d0;
        }
        .goal-card.completed .goal-text {
            text-decoration: line-through;
            color: #6b7280;
        }
        .stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            background: #f3f4f6;
            color: #6b7280;
        }
        .input-field {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.9rem;
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
        .input-field::placeholder { color: #9ca3af; }
        .section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f3f4f6;
            margin-bottom: 1.25rem;
        }

        /* ===== Tabs ===== */
        .nav-tab-custom {
            border-bottom: 2px solid #eef0f3;
            gap: 2px;
        }
        .nav-tab-custom .nav-link {
            border: none;
            color: #6b7280;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 10px 22px;
            border-radius: 10px 10px 0 0;
            margin-bottom: -2px;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
        }
        .nav-tab-custom .nav-link:hover { color: #4f46e5; background: rgba(99,102,241,0.05); }
        .nav-tab-custom .nav-link.active {
            color: #4f46e5;
            background: transparent;
            border-bottom-color: #6366f1;
        }
        .nav-tab-custom .nav-link i { margin-right: 6px; }

        /* ===== Habit cards ===== */
        .habit-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,0.06);
            padding: 1rem 1.25rem;
            transition: all 0.2s;
        }
        .habit-card:hover {
            border-color: rgba(99,102,241,0.2);
            box-shadow: 0 4px 16px rgba(99,102,241,0.06);
        }
.habit-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #fff;
            flex-shrink: 0;
        }

        /* ===== Calendars ===== */
        .cal-head {
            font-weight: 700;
            font-size: 0.8rem;
            color: #1f2937;
            text-align: center;
            margin-bottom: 6px;
        }
        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }
        .cal-dow {
            text-align: center;
            font-size: 0.65rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            padding: 2px 0;
        }
        .cal-cell {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            color: #374151;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            position: relative;
        }
        .cal-cell.cal-today { box-shadow: 0 0 0 2px #6366f1 inset; font-weight: 800; }
        .cal-cell.cal-done { color: #fff; font-weight: 700; border: none; }
        .cal-mini .cal-cell { font-size: 0.65rem; border-radius: 4px; }
        .cal-mini .cal-cell.cal-today:not(.cal-done) { box-shadow: 0 0 0 2px #6366f1 inset; }
        .cal-standalone .cal-cell {
            flex-direction: column;
            gap: 2px;
            padding: 4px;
            aspect-ratio: auto;
            min-height: 58px;
        }
        .cal-num { font-size: 0.72rem; font-weight: 600; }
        .cal-dots { display: flex; flex-wrap: wrap; gap: 2px; justify-content: center; }
        .cal-dot { width: 9px; height: 9px; border-radius: 50%; display: inline-block; }
        .cal-more { font-size: 0.6rem; color: #6b7280; font-weight: 700; }
        .cal-empty { background: transparent; border: none; }
        .cal-nav-btn {
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            color: #4f46e5;
            border-radius: 8px;
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .cal-nav-btn:hover { background: #eef2ff; border-color: #6366f1; }

.habit-stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }

        /* ===== Motivational Quote Banners ===== */
        .quote-banner {
            background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);
            border-radius: 18px;
            padding: 1.5rem 1.75rem;
            position: relative;
            overflow: hidden;
            color: #fff;
            box-shadow: 0 12px 30px rgba(30,27,75,0.15);
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
.quote-banner-alt { background: linear-gradient(135deg, #0f172a, #1e1b4b, #4c1d95); }
        .quote-banner-green { background: linear-gradient(135deg, #064e3b, #065f46, #047857); }
        .quote-banner-cyan { background: linear-gradient(135deg, #164e63, #155e75, #0e7490); }
        .quote-banner-teal { background: linear-gradient(135deg, #134e4a, #0f766e, #0891b2); }
        .quote-banner-emerald { background: linear-gradient(135deg, #064e3b, #047857, #059669); }
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
            margin-bottom: 0.65rem;
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
            font-size: 0.8rem;
            color: rgba(199,210,254,0.75);
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            padding: 3px 12px;
            border-radius: 999px;
        }

        @media (max-width: 575.98px) {
            .goal-card {
                padding: 0.85rem 1rem !important;
            }
            .goal-actions {
                flex-wrap: wrap;
                gap: 0.35rem !important;
            }
            .nav-tab-custom .nav-link { padding: 8px 12px; font-size: 0.8rem; }
        }
        @media (max-width: 400px) {
            body { overflow-x: hidden; }
            .goal-card { padding: 0.65rem 0.75rem !important; }
            .goal-card .fw-bold { font-size: 0.85rem !important; }
            .goal-card small { font-size: 0.7rem !important; }
            .input-field { font-size: 0.85rem !important; padding: 8px 10px !important; }
            .btn-gradient { font-size: 0.85rem !important; padding: 8px 14px !important; }
            .btn-gradient-sm { font-size: 0.7rem !important; padding: 4px 10px !important; }
            .btn-outline-custom { font-size: 0.75rem !important; padding: 5px 12px !important; }
            .form-card { padding: 1rem !important; }
            .habit-card { padding: 0.75rem 0.85rem !important; }
            .cal-standalone .cal-cell { min-height: 44px; }
        }
    </style>
</head>
<body>

{{--
============================================================
NAVBAR — same as dashboard
============================================================
--}}
<nav class="navbar navbar-expand-lg sticky-top" style="background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="{{ route('dashboard') }}">
            <i class="bi bi-mortarboard-fill me-2"></i>{{ $platformName ?? 'UniGrowth' }}
        </a>

        <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#goalsNav" style="color: rgba(255,255,255,0.7);">
            <i class="bi bi-list fs-4"></i>
        </button>

        <div class="collapse navbar-collapse" id="goalsNav">
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

{{--
============================================================
MAIN CONTENT
============================================================
--}}
<div class="container py-4">

    <div class="row g-3 mb-5">
        <div class="col-12">
            <div class="row row-cols-1 row-cols-md-3 g-3">
                <div class="col">
                    <div class="quote-banner quote-banner">
                        <p class="quote-text">“Style is a way to say who you are without having to speak.”</p>
                        <div class="quote-author">Rachel Zoe</div>
                    </div>
                </div>
                <div class="col">
                    <div class="quote-banner quote-banner-alt">
                        <p class="quote-text">“Design is not just what it looks like and feels like. Design is how it works.”</p>
                        <div class="quote-author">Steve Jobs</div>
                    </div>
                </div>
                <div class="col">
                    <div class="quote-banner quote-banner-green">
                        <p class="quote-text">“Good design is obvious. Great design is transparent.”</p>
                        <div class="quote-author">Joe Sparano</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
            <i class="bi bi-check-circle-fill flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
            <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Page Header -->
    @php
        $allHabits = $profile['habits'] ?? [];
        $habitsDoneToday = collect($allHabits)->where('completed_today', true)->count();
        $bestHabitStreak = collect($allHabits)->max('longest_streak') ?? 0;
    @endphp
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1f2937;">
                <i class="bi bi-bullseye me-2" style="color: #059669;"></i>My Goals & Habits
            </h4>
            <p class="text-muted small mb-0">Set goals, build daily habits, and track your consistency</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <span class="stat-chip">
                <i class="bi bi-list-check"></i>
                {{ count($profile['goals'] ?? []) }} goals
            </span>
            <span class="stat-chip" style="background: #d1fae5; color: #065f46;">
                <i class="bi bi-check2-circle"></i>
                {{ collect($profile['goals'] ?? [])->where('status', 'completed')->count() }} done
            </span>
            <span class="stat-chip" style="background: #eef2ff; color: #4f46e5;">
                <i class="bi bi-calendar2-check"></i>
                {{ count($allHabits) }} habits
            </span>
            <span class="stat-chip" style="background: #fef3c7; color: #92400e;">
                <i class="bi bi-fire"></i>
                {{ $bestHabitStreak }} best streak
            </span>
        </div>
    </div>

    {{--
    ============================================================
    TABS — Goals | Habits
    ============================================================
    --}}
    <ul class="nav nav-tab-custom mb-4" id="assetsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="goals-tab" data-bs-toggle="tab" data-bs-target="#pane-goals" type="button" role="tab" aria-controls="pane-goals" aria-selected="true">
                <i class="bi bi-bullseye"></i>Goals
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="habits-tab" data-bs-toggle="tab" data-bs-target="#pane-habits" type="button" role="tab" aria-controls="pane-habits" aria-selected="false">
                <i class="bi bi-calendar2-check"></i>Habits
                @if (count($allHabits) > 0)
                    <span class="badge rounded-pill ms-1" style="background: #eef2ff; color: #4f46e5; font-size: 0.65rem;">{{ $habitsDoneToday }}/{{ count($allHabits) }} today</span>
                @endif
            </button>
        </li>
</ul>

<div class="tab-content">

        {{--
        ============================================================
        GOALS TAB
        ============================================================
        --}}
        <div class="tab-pane fade show active" id="pane-goals" role="tabpanel" aria-labelledby="goals-tab">

            {{--
            CREATE GOAL FORM
            --}}
            <div class="form-card p-4 p-lg-5 mb-4">
                <div class="section-header">
                    <div class="d-flex align-items-center justify-content-center rounded-circle text-white flex-shrink-0" style="width: 40px; height: 40px; background: linear-gradient(135deg, #059669, #10b981);">
                        <i class="bi bi-plus-lg"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0" style="color: #1f2937;">Create New Goal</h5>
                        <small class="text-muted">What do you want to accomplish?</small>
                    </div>
                </div>

                <form action="{{ route('core-assets.action') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="goal">
                    <input type="hidden" name="action" value="create">

                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-8 col-lg-9">
                            <label for="goalText" class="form-label small fw-semibold text-secondary">Goal Description</label>
                            <input type="text" name="payload[text]" id="goalText"
                                   class="input-field"
                                   placeholder="e.g. Complete Laravel certification, Read 12 books this semester…"
                                   required maxlength="255">
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            <button type="submit" class="btn btn-gradient w-100">
                                <i class="bi bi-plus-circle me-1"></i>Add Goal
                            </button>
                        </div>
                    </div>
                </form>
</div>

            {{--
            ACTIVE GOALS
            --}}
            @php
                $activeGoals = collect($profile['goals'] ?? [])->where('status', '!=', 'completed')->values();
                $completedGoals = collect($profile['goals'] ?? [])->where('status', 'completed')->values();
            @endphp

            @if ($activeGoals->count() > 0)
                <div class="form-card p-4 p-lg-5 mb-4">
                    <div class="section-header">
                        <div class="d-flex align-items-center justify-content-center rounded-circle text-white flex-shrink-0" style="width: 40px; height: 40px; background: linear-gradient(135deg, #6366f1, #7c3aed);">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <div class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2">
                            <div>
                                <h5 class="fw-bold mb-0" style="color: #1f2937;">Active Goals</h5>
                                <small class="text-muted">{{ $activeGoals->count() }} goal{{ $activeGoals->count() !== 1 ? 's' : '' }} in progress</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @foreach ($activeGoals as $goal)
                            <div class="goal-card d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div class="d-flex align-items-start gap-3 flex-grow-1 min-width-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width: 38px; height: 38px; background: #eef2ff; color: #4f46e5;">
                                        <i class="bi bi-check2-circle"></i>
                                    </div>
                                    <div class="min-width-0 flex-grow-1">
                                        <p class="fw-semibold mb-0 goal-text text-truncate" style="color: #1f2937; font-size: 0.95rem;">
                                            {{ $goal['text'] }}
                                        </p>
                                        <small class="text-muted">
                                            Created {{ \Carbon\Carbon::parse($goal['created_at'] ?? now())->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 goal-actions flex-shrink-0">
                                    <form action="{{ route('core-assets.action') }}" method="POST" class="m-0">
                                        @csrf
                                        <input type="hidden" name="type" value="goal">
                                        <input type="hidden" name="action" value="complete">
                                        <input type="hidden" name="payload[goal_id]" value="{{ $goal['id'] }}">
                                        <button type="submit" class="btn btn-sm" style="background: #d1fae5; color: #065f46; border: none; border-radius: 8px; font-weight: 600;">
                                            <i class="bi bi-check2 me-1"></i>Complete
                                        </button>
                                    </form>
                                    <form action="{{ route('core-assets.action') }}" method="POST" class="m-0">
                                        @csrf
                                        <input type="hidden" name="type" value="goal">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="payload[goal_id]" value="{{ $goal['id'] }}">
                                        <button type="submit" class="btn btn-sm" style="background: #fef2f2; color: #dc2626; border: none; border-radius: 8px; font-weight: 600;">
                                            <i class="bi bi-trash3 me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="form-card p-5 text-center mb-4">
                    <div class="py-3">
                        <i class="bi bi-bullseye" style="font-size: 3rem; color: #d1d5db;"></i>
                        <h5 class="fw-bold mt-3 mb-1" style="color: #6b7280;">No active goals</h5>
                        <p class="small text-muted mb-0">Create a goal above to start tracking your progress!</p>
                    </div>
                </div>
            @endif

            {{--
            COMPLETED GOALS
            --}}
            @if ($completedGoals->count() > 0)
                <div class="form-card p-4 p-lg-5">
                    <div class="section-header">
                        <div class="d-flex align-items-center justify-content-center rounded-circle text-white flex-shrink-0" style="width: 40px; height: 40px; background: #059669;">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0" style="color: #1f2937;">Completed Goals</h5>
                            <small class="text-muted">{{ $completedGoals->count() }} goal{{ $completedGoals->count() !== 1 ? 's' : '' }} achieved 🎉</small>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @foreach ($completedGoals as $goal)
                            <div class="goal-card completed d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div class="d-flex align-items-start gap-3 flex-grow-1 min-width-0">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width: 38px; height: 38px; background: #d1fae5; color: #059669;">
                                        <i class="bi bi-check2-all"></i>
                                    </div>
                                    <div class="min-width-0 flex-grow-1">
                                        <p class="fw-semibold mb-0 goal-text text-truncate" style="font-size: 0.95rem;">
                                            {{ $goal['text'] }}
                                        </p>
                                        <small class="text-muted">
                                            @if ($goal['completed_at'])
                                                Completed {{ \Carbon\Carbon::parse($goal['completed_at'])->diffForHumans() }}
                                            @else
                                                Completed
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <span class="badge rounded-pill flex-shrink-0" style="background: #d1fae5; color: #065f46; font-size: 0.75rem; padding: 6px 12px;">
                                    <i class="bi bi-check-circle me-1"></i>Done
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{--
        ============================================================
        HABITS TAB
        ============================================================
        --}}
        <div class="tab-pane fade" id="pane-habits" role="tabpanel" aria-labelledby="habits-tab">


            {{--
            CREATE HABIT FORM
            --}}
            <div class="form-card p-4 p-lg-5 mb-4">
                <div class="section-header">
                    <div class="d-flex align-items-center justify-content-center rounded-circle text-white flex-shrink-0" style="width: 40px; height: 40px; background: linear-gradient(135deg, #6366f1, #7c3aed);">
                        <i class="bi bi-calendar2-check"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0" style="color: #1f2937;">Create New Habit</h5>
                        <small class="text-muted">Repeat daily — check it off every day to build a streak</small>
                    </div>
                </div>

                <form action="{{ route('core-assets.action') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="habit">
                    <input type="hidden" name="action" value="create">

                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-5">
                            <label for="habitName" class="form-label small fw-semibold text-secondary">Habit Name</label>
                            <input type="text" name="payload[name]" id="habitName"
                                   class="input-field"
                                   placeholder="e.g. Drink 8 glasses of water, Read 30 minutes…"
                                   required maxlength="100">
                        </div>
                        <div class="col-12 col-md-5">
                            <label for="habitDesc" class="form-label small fw-semibold text-secondary">Description <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="text" name="payload[description]" id="habitDesc"
                                   class="input-field"
                                   placeholder="e.g. Morning routine, before lunch…"
                                   maxlength="255">
                        </div>
                        <div class="col-12 col-md-2">
                            <button type="submit" class="btn btn-gradient w-100">
                                <i class="bi bi-plus-circle me-1"></i>Add Habit
                            </button>
                        </div>
                    </div>
                </form>
            </div>

@if (count($allHabits) > 0)
                {{--
                HABIT STATS
                --}}
                <div class="row g-3 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="habit-stat-card">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 40px; height: 40px; background: #eef2ff;">
                                <i class="bi bi-calendar2-check" style="color: #4f46e5;"></i>
                            </div>
                            <div class="fs-5 fw-bold" style="color: #1f2937;">{{ count($allHabits) }}</div>
                            <div class="small text-muted">Total Habits</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="habit-stat-card">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 40px; height: 40px; background: #d1fae5;">
                                <i class="bi bi-check2-circle" style="color: #059669;"></i>
                            </div>
                            <div class="fs-5 fw-bold" style="color: #1f2937;">{{ $habitsDoneToday }}</div>
                            <div class="small text-muted">Done Today</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="habit-stat-card">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 40px; height: 40px; background: #fef3c7;">
                                <i class="bi bi-fire" style="color: #d97706;"></i>
                            </div>
                            <div class="fs-5 fw-bold" style="color: #1f2937;">{{ $bestHabitStreak }}</div>
                            <div class="small text-muted">Best Streak (days)</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="habit-stat-card">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" style="width: 40px; height: 40px; background: #faf5ff;">
                                <i class="bi bi-stars" style="color: #7c3aed;"></i>
                            </div>
                            <div class="fs-5 fw-bold" style="color: #1f2937;">{{ collect($allHabits)->sum('total_completions') }}</div>
                            <div class="small text-muted">Total Check-ins</div>
                        </div>
                    </div>
                </div>

                {{--
                HABIT LIST WITH PER-HABIT MINI CALENDARS
                --}}
                <div class="form-card p-4 p-lg-5 mb-4">
                    <div class="section-header">
                        <div class="d-flex align-items-center justify-content-center rounded-circle text-white flex-shrink-0" style="width: 40px; height: 40px; background: linear-gradient(135deg, #6366f1, #7c3aed);">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0" style="color: #1f2937;">Your Habits</h5>
                            <small class="text-muted">Check in daily — this month's calendar is shown for each habit</small>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @foreach ($allHabits as $habit)
                            <div class="habit-card">
                                <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
                                    <div class="d-flex align-items-start gap-3 flex-grow-1 min-width-0">
                                        <div class="habit-icon" style="background: {{ $habit['color'] }};">
                                            <i class="bi {{ $habit['icon'] }}"></i>
                                        </div>
                                        <div class="min-width-0 flex-grow-1">
                                            <p class="fw-semibold mb-0 text-truncate" style="color: #1f2937; font-size: 0.95rem;">
                                                {{ $habit['name'] }}
                                            </p>
                                            @if (!empty($habit['description']))
                                                <small class="text-muted d-block text-truncate">{{ $habit['description'] }}</small>
                                            @endif
<div class="d-flex flex-wrap gap-2 mt-2">
                                                <span class="stat-chip" style="background: #fef3c7; color: #b45309;">
                                                    <i class="bi bi-fire"></i>{{ $habit['current_streak'] }} day streak
                                                </span>
                                                <span class="stat-chip">
                                                    <i class="bi bi-trophy"></i>{{ $habit['longest_streak'] }} longest
                                                </span>
                                                <span class="stat-chip">
                                                    <i class="bi bi-check2-circle"></i>{{ $habit['total_completions'] }} total
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 flex-shrink-0">
                                        <button type="button" class="btn btn-sm habit-toggle-cal" data-habit-id="{{ $habit['id'] }}" style="background: #eef2ff; color: #4f46e5; border: none; border-radius: 8px; font-weight: 600;">
                                            <i class="bi bi-calendar3 me-1"></i>Calendar
                                        </button>
                                        @if ($habit['completed_today'])
                                            <button type="button" class="btn btn-sm" disabled style="background: #d1fae5; color: #065f46; border: none; border-radius: 8px; font-weight: 600;">
                                                <i class="bi bi-check2-all me-1"></i>Done Today
                                            </button>
                                        @else
                                            <form action="{{ route('core-assets.action') }}" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="type" value="habit">
                                                <input type="hidden" name="action" value="complete">
                                                <input type="hidden" name="payload[habit_id]" value="{{ $habit['id'] }}">
                                                <button type="submit" class="btn btn-sm" style="background: {{ $habit['color'] }}; color: #fff; border: none; border-radius: 8px; font-weight: 600;">
                                                    <i class="bi bi-check2 me-1"></i>Complete Today
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('core-assets.action') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="type" value="habit">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="payload[habit_id]" value="{{ $habit['id'] }}">
                                            <button type="submit" class="btn btn-sm" style="background: #fef2f2; color: #dc2626; border: none; border-radius: 8px; font-weight: 600;">
                                                <i class="bi bi-trash3 me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="mt-3 habit-calendar-wrap" id="habit-cal-{{ $habit['id'] }}" style="display: none;">
                                    <div class="mini-calendar" data-habit="{{ json_encode($habit, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{--
                STANDALONE (NON-AFFILIATED) CALENDAR — all habits at a glance
                --}}
                <div class="form-card p-4 p-lg-5">
                    <div class="section-header">
                        <div class="d-flex align-items-center justify-content-center rounded-circle text-white flex-shrink-0" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0891b2, #06b6d4);">
                            <i class="bi bi-calendar-month"></i>
                        </div>
                        <div class="d-flex flex-wrap align-items-center justify-content-between w-100 gap-2">
                            <div>
                                <h5 class="fw-bold mb-0" style="color: #1f2937;">Habit Calendar</h5>
                                <small class="text-muted">Every habit's check-ins across the month — each dot is a completed habit</small>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($allHabits as $habit)
                                    <span class="stat-chip">
                                        <span class="d-inline-block rounded-circle me-1" style="width: 9px; height: 9px; background: {{ $habit['color'] }};"></span>
                                        {{ $habit['name'] }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div id="standaloneCalendar"></div>
                </div>
            @else
                <div class="form-card p-5 text-center mb-4">
                    <div class="py-3">
                        <i class="bi bi-calendar2-check" style="font-size: 3rem; color: #d1d5db;"></i>
                        <h5 class="fw-bold mt-3 mb-1" style="color: #6b7280;">No habits yet</h5>
                        <p class="small text-muted mb-0">Create a habit above to start tracking your daily consistency!</p>
                    </div>
                </div>
            @endif

        </div>
    </div>

    </div>

    <!-- Bottom Navigation -->
    <div class="text-center mt-4 mb-5">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-custom" style="padding: 8px 24px;">
            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
        <a href="{{ route('core-assets.skills') }}" class="btn btn-outline-custom ms-2" style="padding: 8px 24px;">
            <i class="bi bi-book me-1"></i>Browse Skills
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ============ Tab activation from URL hash ============
    const hash = window.location.hash;
    if (hash) {
        const trigger = document.querySelector('[data-bs-target="' + hash + '"]');
        if (trigger && window.bootstrap) {
            bootstrap.Tab.getOrCreateInstance(trigger).show();
        }
    }

// ============ Toggle per-habit calendar ============
    document.querySelectorAll('.habit-toggle-cal').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.dataset.habitId;
            const wrap = document.getElementById('habit-cal-' + id);
            if (!wrap) return;
            const isHidden = wrap.style.display === 'none';
            wrap.style.display = isHidden ? 'block' : 'none';
            // On first open, build the mini-calendar if not already rendered
            if (isHidden && !wrap.querySelector('.cal-grid')) {
                const el = wrap.querySelector('.mini-calendar');
                if (el) buildMiniCalendar(el);
            }
        });
    });

    function buildMiniCalendar(el) {
        const habit = JSON.parse(el.dataset.habit);
        const now = new Date();
        const cells = buildMonthGrid(now.getFullYear(), now.getMonth());
        const done = new Set(habit.completion_dates || []);
        const todayKey = dateKey(now);
        const monthName = now.toLocaleString('default', { month: 'long' });

        let html = '<div class="cal-head">' + monthName + ' ' + now.getFullYear() + '</div>';
        html += '<div class="cal-grid cal-mini">';
        html += 'SMTWTFS'.split('').map(function (l) { return '<span class="cal-dow">' + l + '</span>'; }).join('');
        cells.forEach(function (c) {
            if (!c) { html += '<span></span>'; return; }
            const key = dateKey(c);
            const isDone = done.has(key);
            const isToday = key === todayKey;
            html += '<span class="cal-cell' + (isDone ? ' cal-done' : '') + (isToday ? ' cal-today' : '') + '"'
                + ' style="' + (isDone ? 'background:' + habit.color + ';' : 'border-color:' + habit.color + ';') + '"'
                + ' title="' + key + (isDone ? ' — completed' : '') + '">' + c.getDate() + '</span>';
        });
        html += '</div>';
        el.innerHTML = html;
    }

    // ============ Calendar helpers ============
const HABIT_DATA = @json(collect($allHabits)->values()->all());

    function pad(n) { return String(n).padStart(2, '0'); }
    function dateKey(d) { return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()); }

    function buildMonthGrid(year, month) {
        const first = new Date(year, month, 1);
        const offset = first.getDay(); // 0 = Sunday
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const cells = [];
        for (let i = 0; i < offset; i++) cells.push(null);
        for (let d = 1; d <= daysInMonth; d++) cells.push(new Date(year, month, d));
        return cells;
    }

// ============ Standalone (non-affiliated) calendar ============
    let calYear = new Date().getFullYear();
    let calMonth = new Date().getMonth();

    function habitsForDate(key) {
        return HABIT_DATA.filter(function (h) { return (h.completion_dates || []).indexOf(key) !== -1; });
    }

    function renderStandalone() {
        const cells = buildMonthGrid(calYear, calMonth);
        const monthName = new Date(calYear, calMonth, 1).toLocaleString('default', { month: 'long' });
        const todayKey = dateKey(new Date());
        const dows = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        let html = '<div class="d-flex justify-content-between align-items-center mb-3">'
            + '<button type="button" class="cal-nav-btn" id="calPrev" aria-label="Previous month"><i class="bi bi-chevron-left"></i></button>'
            + '<h6 class="fw-bold mb-0" style="color:#1f2937;">' + monthName + ' ' + calYear + '</h6>'
            + '<button type="button" class="cal-nav-btn" id="calNext" aria-label="Next month"><i class="bi bi-chevron-right"></i></button>'
            + '</div>';

        html += '<div class="cal-grid cal-standalone">';
        dows.forEach(function (d) { html += '<span class="cal-dow">' + d + '</span>'; });
        cells.forEach(function (c) {
            if (!c) { html += '<span class="cal-cell cal-empty"></span>'; return; }
            const key = dateKey(c);
            const habits = habitsForDate(key);
            const isToday = key === todayKey;
            html += '<span class="cal-cell' + (isToday ? ' cal-today' : '') + '" title="' + key + '">';
            html += '<span class="cal-num">' + c.getDate() + '</span>';
            if (habits.length) {
                html += '<span class="cal-dots">';
                habits.slice(0, 4).forEach(function (h) {
                    html += '<span class="cal-dot" style="background:' + h.color + ';" title="' + h.name + '"></span>';
                });
                if (habits.length > 4) {
                    html += '<span class="cal-more">+' + (habits.length - 4) + '</span>';
                }
                html += '</span>';
            }
            html += '</span>';
        });
        html += '</div>';
        html += '<p class="small text-muted mt-3 mb-0"><i class="bi bi-info-circle me-1"></i>Today is outlined. Colored dots show habits completed on each day.</p>';

        document.getElementById('standaloneCalendar').innerHTML = html;

        document.getElementById('calPrev').addEventListener('click', function () {
            calMonth--;
            if (calMonth < 0) { calMonth = 11; calYear--; }
            renderStandalone();
        });
        document.getElementById('calNext').addEventListener('click', function () {
            calMonth++;
            if (calMonth > 11) { calMonth = 0; calYear++; }
            renderStandalone();
        });
    }

    if (document.getElementById('standaloneCalendar')) {
        renderStandalone();
    }
});
</script>
@include('partials.footer')
</body>
</html>

