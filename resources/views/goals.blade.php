<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniGrowth — My Goals</title>
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
        @media (max-width: 575.98px) {
            .goal-card {
                padding: 0.85rem 1rem !important;
            }
            .goal-actions {
                flex-wrap: wrap;
                gap: 0.35rem !important;
            }
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
            <i class="bi bi-mortarboard-fill me-2"></i>UniGrowth
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
            </ul>

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

{{--
============================================================
MAIN CONTENT
============================================================
--}}
<div class="container py-4">

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
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1f2937;">
                <i class="bi bi-bullseye me-2" style="color: #059669;"></i>My Goals
            </h4>
            <p class="text-muted small mb-0">Set, track, and achieve your personal and academic goals</p>
        </div>
        <div class="d-flex gap-2">
            <span class="stat-chip">
                <i class="bi bi-list-check"></i>
                {{ count($profile['goals'] ?? []) }} total
            </span>
            <span class="stat-chip" style="background: #d1fae5; color: #065f46;">
                <i class="bi bi-check2-circle"></i>
                {{ collect($profile['goals'] ?? [])->where('status', 'completed')->count() }} done
            </span>
        </div>
    </div>

    {{--
    ============================================================
    CREATE GOAL FORM
    ============================================================
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
    ============================================================
    ACTIVE GOALS
    ============================================================
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
                            <form action="{{ route('core-assets.action') }}" method="POST"
                                  onsubmit="return confirm('Delete this goal?')" class="m-0">
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
    ============================================================
    COMPLETED GOALS
    ============================================================
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

    <!-- Bottom Navigation -->
    <div class="text-center mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-custom" style="padding: 8px 24px;">
            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
        <a href="{{ route('core-assets.skills') }}" class="btn btn-outline-custom ms-2" style="padding: 8px 24px;">
            <i class="bi bi-book me-1"></i>Browse Skills
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

