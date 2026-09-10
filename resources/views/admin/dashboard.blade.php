@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    @php
        $m = $metrics ?? [];
    @endphp

    <!-- Metric Cards Row -->
    <div class="row g-3 mb-4">
        <!-- Signups -->
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: #ede9fe; color: #6d28d9;">
                    <i class="bi bi-person-plus"></i>
                </div>
                <div class="stat-value">{{ number_format($m['daily_new_users'] ?? 0) }}</div>
                <div class="stat-label">New Users Today</div>
                <div class="stat-trend text-muted">
                    <span class="text-primary">{{ number_format($m['weekly_new_users'] ?? 0) }}</span> this week &middot;
                    <span class="text-primary">{{ number_format($m['monthly_new_users'] ?? 0) }}</span> this month
                </div>
            </div>
        </div>

        <!-- Popular Skill -->
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: #fef3c7; color: #b45309;">
                    <i class="bi bi-star"></i>
                </div>
                <div class="stat-value" style="font-size: 1.15rem; word-break: break-word;">
                    {{ $m['popular_skill'] ?? 'N/A' }}
                </div>
                <div class="stat-label">Most Popular Skill</div>
                <div class="stat-trend text-muted">
                    {{ number_format($m['popular_skill_enrollments'] ?? 0) }} enrollments
                </div>
            </div>
        </div>

        <!-- Banned Users + Total Skills -->
        <div class="col-xl-4 col-lg-6 col-md-6">

<div class="stat-card d-flex flex-column justify-content-between" style="height: 100%;">

<div>

<div class="d-flex align-items-center gap-3 mb-3">

<div class="stat-icon" style="background: #fee2e2; color: #dc2626; margin-bottom: 0;">

<i class="bi bi-shield-exclamation"></i>

</div>

<div>

<div class="stat-value" style="font-size: 1.3rem;">{{ number_format($m['total_banned_users'] ?? 0) }}</div>

<div class="stat-label">Banned Users</div>

</div>

</div>

</div>

<div class="pt-3 border-top d-flex align-items-center gap-3">

<div class="stat-icon" style="background: #ecfdf5; color: #059669; width: 36px; height: 36px; font-size: 1rem; margin-bottom: 0;">

<i class="bi bi-book"></i>

</div>

<div>

<div class="fw-bold" style="color: #1a1a2e;">{{ number_format($m['total_skills'] ?? 0) }}</div>

<div class="stat-label">Total Skills</div>

</div>

</div>

</div>

</div>

</div>

    <!-- Second Row: Quick Stats -->
    <div class="row g-3 mb-4">
        <!-- Total Registered Users -->
        <div class="col-xl-6 col-lg-6">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background: #e0f2fe; color: #0369a1; margin-bottom: 0;">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="stat-value" style="font-size: 1.3rem;">{{ number_format($m['total_registered_users'] ?? 0) }}</div>
                    <div class="stat-label">Total Registered Users</div>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="col-xl-6 col-lg-6">
            <div class="stat-card d-flex align-items-center gap-3">
                <div class="stat-icon" style="background: #d1fae5; color: #065f46; margin-bottom: 0;">
                    <i class="bi bi-person-check"></i>
                </div>
                <div>
                    <div class="stat-value" style="font-size: 1.3rem;">{{ number_format($m['active_users'] ?? 0) }}</div>
                    <div class="stat-label">Active Users (Last 30 days)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Time Frame Filter -->
    <div class="d-flex justify-content-end mb-4">
        <div class="d-flex align-items-center gap-2">
            <span class="small text-muted">Time frame:</span>
            <a href="{{ route('admin.dashboard', ['time_frame' => '7d']) }}"
               class="btn-admin-action {{ ($timeFrame ?? 'all') === '7d' ? 'view' : '' }}">7d</a>
            <a href="{{ route('admin.dashboard', ['time_frame' => '30d']) }}"
               class="btn-admin-action {{ ($timeFrame ?? 'all') === '30d' ? 'view' : '' }}">30d</a>
            <a href="{{ route('admin.dashboard', ['time_frame' => 'all']) }}"
               class="btn-admin-action {{ ($timeFrame ?? 'all') === 'all' ? 'view' : '' }}">All</a>
        </div>
    </div>

    <!-- Registration Metrics -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-lg-6">
            <div class="content-card h-100">
                <div class="card-header-custom">
                    <h5><i class="bi bi-building me-2"></i>Top Universities</h5>
                </div>
                <div class="card-body-custom">
                    @if(!empty($metrics['university_distribution']))
                        <div class="d-flex flex-column gap-2">
                            @foreach($metrics['university_distribution'] as $university => $count)
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="small text-truncate" style="max-width: 70%;">{{ $university }}</span>
                                    <span class="badge bg-primary">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="small text-muted mb-0">No university data available yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6">
            <div class="content-card h-100">
                <div class="card-header-custom">
                    <h5><i class="bi bi-calendar-check me-2"></i>Academic Year</h5>
                </div>
                <div class="card-body-custom">
                    @if(!empty($metrics['academic_year_distribution']))
                        <div class="d-flex flex-column gap-2">
                            @foreach($metrics['academic_year_distribution'] as $year => $count)
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="small">{{ $year }}</span>
                                    <span class="badge bg-success">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="small text-muted mb-0">No academic year data available yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-12">
            <div class="content-card h-100">
                <div class="card-header-custom">
                    <h5><i class="bi bi-book me-2"></i>Majors</h5>
                </div>
                <div class="card-body-custom">
                    @if(!empty($metrics['major_distribution']))
                        <div class="d-flex flex-column gap-2">
                            @foreach($metrics['major_distribution'] as $major => $count)
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="small text-truncate" style="max-width: 70%;">{{ $major }}</span>
                                    <span class="badge bg-info">{{ $count }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="small text-muted mb-0">No major data available yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Season Management Section -->
    <div class="content-card mb-4">
        <div class="card-header-custom d-flex flex-wrap align-items-center justify-content-between gap-3">
            <h5><i class="bi bi-calendar-event me-2"></i>Season Management</h5>
            @if(!empty($seasonStatus['has_active_season']))
                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#startSeasonModal">
                    <i class="bi bi-stop-circle me-1"></i>End Current Season
                </button>
            @else
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#startSeasonModal">
                    <i class="bi bi-play-fill me-1"></i>Start New Season
                </button>
            @endif
        </div>
        <div class="card-body-custom">
            @if(!empty($seasonStatus['has_active_season']))
                <div class="row g-4 align-items-center">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="season-badge active"><i class="bi bi-fire"></i>Active</span>
                            <span class="fw-semibold" style="color: #1a1a2e;">{{ $seasonStatus['name'] }}</span>
                        </div>
                        <div class="small text-muted">
                            Started: {{ $seasonStatus['started_at'] ? \Carbon\Carbon::parse($seasonStatus['started_at'])->format('M j, Y') : 'N/A' }}<br>
                            Ends: {{ $seasonStatus['ends_at'] ? \Carbon\Carbon::parse($seasonStatus['ends_at'])->format('M j, Y g:i A') : 'N/A' }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if(!empty($seasonStatus['image']))
                            <div class="p-2 bg-light rounded-3 d-inline-block">
                                <img src="{{ asset('storage/' . $seasonStatus['image']) }}" alt="Current season" style="max-height: 80px; max-width: 160px; border-radius: 6px; object-fit: cover;">
                            </div>
                        @else
                            <div class="text-muted small fst-italic">No season image uploaded</div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @if(!empty($seasonStatus['image']))
                            <form method="POST" action="{{ route('admin.seasons.image') }}" enctype="multipart/form-data" class="d-flex align-items-center gap-2 flex-wrap">
                                @csrf
                                <input type="hidden" name="season_id" value="{{ $seasonStatus['season_id'] }}">
                                <input type="file" name="season_image" class="form-control form-control-admin" style="width: auto;" accept="image/*" required>
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-arrow-repeat me-1"></i>Change
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.seasons.image') }}" class="d-inline mt-2" onsubmit="return confirm('Remove current season image?')">
                                @csrf
                                <input type="hidden" name="season_id" value="{{ $seasonStatus['season_id'] }}">
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash me-1"></i>Remove
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.seasons.image') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="season_id" value="{{ $seasonStatus['season_id'] }}">
                                <div class="mb-2">
                                    <label class="form-label-admin small" for="seasonImage">Season Image</label>
                                    <input type="file" name="season_image" id="seasonImage" class="form-control form-control-admin" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-upload me-1"></i>Upload Image
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @else
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <p class="small text-muted mb-0">No active season running. Start a new season to enable competition features.</p>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#startSeasonModal">
                        <i class="bi bi-play-fill me-1"></i>Start New Season
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Start Season Modal -->
    <div class="modal fade modal-admin" id="startSeasonModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="POST" action="{{ route('admin.seasons.start') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">Start New Season</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label-admin" for="seasonName">Season Name</label>
                        <input type="text" name="name" id="seasonName" class="form-control form-control-admin" required placeholder="e.g. Fall 2026">
                    </div>
                    <div class="mb-3">
                        <label class="form-label-admin" for="seasonEndsAt">Ends At</label>
                        <input type="datetime-local" name="ends_at" id="seasonEndsAt" class="form-control form-control-admin" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-admin" for="seasonImage">Season Image</label>
                        <input type="file" name="season_image" id="seasonImage" class="form-control form-control-admin" accept="image/*">
                        <div class="form-text">Optional. Recommended size: 1200x400px.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-play-fill me-1"></i>Start Season
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
