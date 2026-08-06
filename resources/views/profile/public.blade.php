<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - UniGrowth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #7c3aed;
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f0f2f5;
        }
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
            transition: all 0.2s;
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
            transition: all 0.2s;
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
        .profile-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.06), 0 1px 8px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }
        .profile-cover {
            height: 120px;
            background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);
            position: relative;
        }
        .profile-cover::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(139, 92, 246, 0.15) 0%, transparent 50%);
        }
        .avatar-xl {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background: #fff;
        }
        .avatar-initial-xl {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 2.6rem;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: #fff;
            border: 4px solid #fff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        .stat-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        .stat-card .stat-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1f2937;
        }
        .stat-card .stat-label {
            font-size: 0.72rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }
        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            background: #eef2ff;
            color: #4f46e5;
            flex-shrink: 0;
        }
        .social-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            background: #f1f5f9;
            color: #334155;
            text-decoration: none;
            transition: all 0.2s;
        }
        .social-chip:hover {
            background: #eef2ff;
            color: #4f46e5;
        }
        .btn-back {
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            border: none;
            border-radius: 10px;
            padding: 8px 22px;
            font-weight: 600;
            color: #fff;
            transition: all 0.2s;
        }
        .btn-back:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.35);
            color: #fff;
        }
        .private-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.04);
            padding: 3rem 2rem;
            text-align: center;
        }
        .private-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            background: #fef2f2;
            color: #dc2626;
            margin: 0 auto 1rem;
        }
    </style>
</head>
<body>

{{-- Top Navigation --}}
<nav class="navbar navbar-expand-lg sticky-top navbar-unigrowth">
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

<div class="container py-4" style="max-width: 760px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-back">
            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>

    @if ($isPrivate)
        {{-- Private Profile Notice --}}
        <div class="private-card">
            <div class="private-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            <h4 class="fw-bold mb-2" style="color: #1f2937;">Profile is Private</h4>
            <p class="text-muted mb-0">
                <strong>{{ $username }}</strong> has decided to keep their profile private.
                You cannot view their profile information at this time.
            </p>
        </div>
    @else
{{-- Public Profile --}}
        @php $p = $profile; @endphp
        <div class="profile-card">
            <div class="profile-cover"></div>

            {{-- Profile Header (avatar + name + score, fully visible) --}}
            <div class="px-4 pb-4 pt-4">
                <div class="d-flex flex-column flex-sm-row align-items-center gap-4">
                    <div class="flex-shrink-0">
                        @if (!empty($p['avatar_path']))
                            <img src="{{ asset('storage/' . $p['avatar_path']) }}" alt="Avatar" class="avatar-xl">
                        @else
                            <div class="avatar-initial-xl">{{ strtoupper(substr($p['username'] ?? 'U', 0, 1)) }}</div>
                        @endif
                    </div>
                     <div class="text-center text-sm-start flex-grow-1">
                        <h4 class="fw-bold mb-1" style="color: #1f2937;">{{ $p['username'] ?? 'User' }}
                            @if (!empty($p['rank_title']))
                                <span data-bs-toggle="modal" data-bs-target="#rankTiersModal" style="cursor: pointer; color: #6366f1; font-weight: 600; font-size: 0.9rem;" title="View rank tiers">
                                    [{{ $p['rank_title'] }}]
                                </span>
                            @endif
                        </h4>
                        @if (!empty($p['major']) || !empty($p['university_name']))
                            <p class="text-muted small mb-1">
                                @if (!empty($p['major']))<i class="bi bi-mortarboard me-1"></i>{{ $p['major'] }}@endif
                                @if (!empty($p['university_name']))
                                    <span class="mx-1">&bull;</span><i class="bi bi-building me-1"></i>{{ $p['university_name'] }}
                                @endif
                            </p>
                        @endif
                        @if (!empty($p['academic_year']))
                            <p class="text-muted small mb-0"><i class="bi bi-book me-1"></i>{{ $p['academic_year'] }}</p>
                        @endif
                    </div>
                    <div class="flex-shrink-0">
                        <div class="stat-card">
                            <div class="stat-value">{{ number_format($p['platform_score'] ?? 0, 1) }}</div>
                            <div class="stat-label">Platform Score</div>
                        </div>
                    </div>
                </div>

                {{-- About / Description (prominent) --}}
                <div class="mt-4 p-4 rounded-3" style="background: linear-gradient(135deg, #eef2ff, #faf5ff); border: 1px solid #e0e7ff;">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-quote" style="color: #6366f1;"></i>
                        <span class="fw-semibold" style="color: #334155;">About</span>
                    </div>
                    @if (!empty($p['description']))
                        <p class="mb-0 text-muted small">{{ $p['description'] }}</p>
                    @else
                        <p class="mb-0 text-muted small fst-italic">This user hasn't added a description yet.</p>
                    @endif
                </div>

                {{-- Account Details & Profile Information --}}
                <div class="mt-4 rounded-3" style="background: #f8fafc; border: 1px solid #eef2f7;">
                    <div class="d-flex align-items-center gap-2 p-3 pb-2">
                        <i class="bi bi-person-gear" style="color: #6366f1;"></i>
                        <span class="fw-semibold small" style="color: #334155;">Account Details &amp; Profile Information</span>
                    </div>
                    <div class="p-3 pt-1">
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-person"></i></div>
                            <div>
                                <p class="mb-0 small fw-semibold" style="color: #334155;">Username</p>
                                <p class="mb-0 text-muted small">{{ $p['username'] ?? '—' }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-mortarboard"></i></div>
                            <div>
                                <p class="mb-0 small fw-semibold" style="color: #334155;">Major</p>
                                <p class="mb-0 text-muted small">{{ $p['major'] ?? 'Not set' }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-book"></i></div>
                            <div>
                                <p class="mb-0 small fw-semibold" style="color: #334155;">Academic Year</p>
                                <p class="mb-0 text-muted small">{{ $p['academic_year'] ?? 'Not set' }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-building"></i></div>
                            <div>
                                <p class="mb-0 small fw-semibold" style="color: #334155;">University</p>
                                <p class="mb-0 text-muted small">{{ $p['university_name'] ?? 'Not set' }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-trophy"></i></div>
                            <div>
                                <p class="mb-0 small fw-semibold" style="color: #334155;">Platform Score</p>
                                <p class="mb-0 text-muted small">{{ number_format($p['platform_score'] ?? 0, 1) }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-stars"></i></div>
                            <div>
                                <p class="mb-0 small fw-semibold" style="color: #334155;">Rank</p>
                                <p class="mb-0 text-muted small">
                                    <span data-bs-toggle="modal" data-bs-target="#rankTiersModal" style="cursor: pointer; color: #6366f1; font-weight: 600;" title="View rank tiers">
                                        {{ $p['rank_title'] ?? 'Beginner' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@include('partials.rank-tiers')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@include('partials.footer')
</body>
</html>
