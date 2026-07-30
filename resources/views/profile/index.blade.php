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
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f8fafc;
        }
        .profile-sidebar {
            position: sticky;
            top: 90px;
            z-index: 1;
        }
        .profile-sidebar .nav-link {
            color: #475569;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 10px 16px;
            border-radius: 10px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .profile-sidebar .nav-link:hover {
            background: #eef2ff;
            color: #4f46e5;
        }
        .profile-sidebar .nav-link.active {
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: #fff;
        }
        .profile-sidebar .nav-link i {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
        }
        .section-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.04);
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            scroll-margin-top: 90px;
        }
        .section-card h5 {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.25rem;
        }
        .section-card .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-right: 12px;
        }
        .danger-zone-card {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 16px;
            padding: 1.75rem;
        }
        .danger-zone-card h5 {
            color: #b91c1c;
        }
        .btn-primary-gradient {
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            border: none;
            border-radius: 10px;
            padding: 8px 22px;
            font-weight: 600;
            font-size: 0.85rem;
            color: #fff;
            transition: all 0.2s;
        }
        .btn-primary-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99,102,241,0.3);
            color: #fff;
        }
        .btn-outline-danger-custom {
            border: 2px solid #fca5a5;
            color: #b91c1c;
            border-radius: 10px;
            padding: 8px 22px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        .btn-outline-danger-custom:hover {
            background: #dc2626;
            border-color: #dc2626;
            color: #fff;
        }
        .stat-display {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        .stat-display .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
        }
        .stat-display .stat-label {
            font-size: 0.75rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }
        .avatar-xl {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e0e7ff;
        }
        .avatar-initial-xl {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 2rem;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: #fff;
            border: 3px solid #e0e7ff;
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
        @media (max-width: 767.98px) {
            .profile-sidebar {
                position: static;
                margin-bottom: 1rem;
            }
            .profile-sidebar .nav {
                flex-direction: row !important;
                overflow-x: auto;
                flex-wrap: nowrap;
                gap: 4px;
                padding-bottom: 4px;
            }
            .profile-sidebar .nav-link {
                white-space: nowrap;
                font-size: 0.8rem;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>

{{--
============================================================
TOP NAVIGATION BAR (Same as Dashboard)
============================================================
--}}
<nav class="navbar navbar-expand-lg sticky-top" style="background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);">
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
                        <i class="bi bi-speedometer2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.show') }}" class="nav-link nav-link-custom" style="color: #fff; background: rgba(255,255,255,0.15);">
                        <i class="bi bi-person"></i>Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('assessment.test.index') }}" class="nav-link nav-link-custom">
                        <i class="bi bi-pencil-square"></i>Assessments
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('core-assets.skills') }}" class="nav-link nav-link-custom">
                        <i class="bi bi-book"></i>Browse Skills
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
                <div class="bg-white rounded-3 shadow-sm p-3 border" style="border-color: rgba(0,0,0,0.04) !important;">
                    <h6 class="fw-bold text-muted text-uppercase small mb-3 px-2" style="letter-spacing: 0.05em;">
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

            {{-- Profile Summary Header --}}
            <div class="section-card d-flex flex-wrap align-items-center gap-4">
                <div class="flex-shrink-0">
                    @if (!empty($profile['avatar_path']))
                        <img src="{{ asset('storage/' . $profile['avatar_path']) }}" alt="Avatar" class="avatar-xl">
                    @else
                        <div class="avatar-initial-xl">{{ strtoupper(substr($profile['username'] ?? 'U', 0, 1)) }}</div>
                    @endif
                </div>
                <div class="flex-grow-1">
                    <h4 class="fw-bold mb-1" style="color: #1e293b;">{{ $profile['username'] ?? 'User' }}</h4>
                    <p class="text-muted mb-1 small">
                        {{ $profile['major'] ?? 'No major set' }}
                        @if ($profile['academic_year'])
                            &bull; {{ $profile['academic_year'] }}
                        @endif
                    </p>
                    @if ($profile['university_name'])
                        <p class="text-muted mb-0 small"><i class="bi bi-building me-1"></i>{{ $profile['university_name'] }}</p>
                    @endif
                </div>
                <div class="text-end">
                    <div class="stat-display">
                        <div class="stat-value">{{ number_format($profile['platform_score'] ?? 0, 1) }}</div>
                        <div class="stat-label">Platform Score</div>
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
                    <div class="section-icon" style="background: #eef2ff; color: #4f46e5;">
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
                        <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                        <h5 class="mb-0">⚠️ Danger Zone</h5>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 py-2">
                        <div>
                            <p class="fw-semibold mb-0" style="color: #1e293b;">Password Reset</p>
                            <small class="text-muted">Reset your account password to a new one.</small>
                        </div>
                        <button type="button" class="btn btn-primary-gradient btn-sm" data-bs-toggle="modal" data-bs-target="#passwordResetModal">
                            <i class="bi bi-key me-1"></i>Password Reset
                        </button>
                    </div>
                    <hr class="my-3" style="border-color: #fecaca;">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 py-2">
                        <div>
                            <p class="fw-semibold mb-0" style="color: #1e293b;">Delete My Account</p>
                            <small class="text-muted">Permanently delete your account and all associated data.</small>
                        </div>
                        <form action="{{ route('profile.account.update') }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete your account? This action is irreversible.')">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="action" value="deactivate">
                            <button type="submit" class="btn btn-outline-danger-custom btn-sm">
                                <i class="bi bi-trash3 me-1"></i>Delete My Account
                            </button>
                        </form>
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
                    <div class="section-icon" style="background: #faf5ff; color: #7c3aed;">
                        <i class="bi bi-sliders"></i>
                    </div>
                    <h5 class="mb-0">🔒 Preferences & Communication Settings</h5>
                </div>

                <form action="{{ route('profile.preferences.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    {{-- Privacy & Visibility --}}
                    <div class="bg-light rounded-3 p-4 mb-4 border" style="border-color: #e2e8f0 !important;">
                        <h6 class="fw-bold mb-3" style="color: #334155;">
                            <i class="bi bi-shield-lock me-2"></i>Privacy & Visibility
                        </h6>
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="make_profile_private" value="1" role="switch"
                                       id="chk_private_profile"
                                       {{ ($profile['preferences']['make_profile_private'] ?? false) ? 'checked' : '' }}>
                            </div>
                            <div>
                                <label class="form-check-label fw-semibold" for="chk_private_profile" style="cursor: pointer;">
                                    Make my profile private
                                </label>
                                <p class="text-muted small mb-0">You can hide your profile from leaderboards, academic statistics, and external profile view lookups.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="privacy_hide_leaderboards" value="1" role="switch"
                                       id="chk_hide_leaderboard"
                                       {{ ($profile['preferences']['privacy_hide_leaderboards'] ?? false) ? 'checked' : '' }}>
                            </div>
                            <div>
                                <label class="form-check-label fw-semibold" for="chk_hide_leaderboard" style="cursor: pointer;">
                                    Hide from leaderboards
                                </label>
                                <p class="text-muted small mb-0">Your name and score will not appear on public leaderboards.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Communication Preferences --}}
                    <div class="bg-light rounded-3 p-4 mb-4 border" style="border-color: #e2e8f0 !important;">
                        <h6 class="fw-bold mb-3" style="color: #334155;">
                            <i class="bi bi-chat-dots me-2"></i>Communication Channels
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3 bg-white border rounded-3 p-3 shadow-sm" style="cursor: pointer;">
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="comm_email" value="1" role="switch"
                                               id="chk_comm_email"
                                               {{ ($profile['preferences']['comm_email'] ?? true) ? 'checked' : '' }}>
                                    </div>
                                    <div>
                                        <label class="form-check-label fw-semibold" for="chk_comm_email" style="cursor: pointer;">
                                            <i class="bi bi-envelope me-1 text-primary"></i>Email Notifications
                                        </label>
                                        <p class="text-muted small mb-0">Weekly platform score digests</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3 bg-white border rounded-3 p-3 shadow-sm" style="cursor: pointer;">
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="comm_telegram" value="1" role="switch"
                                               id="chk_comm_telegram"
                                               {{ ($profile['preferences']['comm_telegram'] ?? false) ? 'checked' : '' }}>
                                    </div>
                                    <div>
                                        <label class="form-check-label fw-semibold" for="chk_comm_telegram" style="cursor: pointer;">
                                            <i class="bi bi-telegram me-1" style="color: #0088cc;"></i>Telegram Bot
                                        </label>
                                        <p class="text-muted small mb-0">Instant notification updates</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary-gradient">
                            <i class="bi bi-check2-circle me-1"></i>Save Preferences
                        </button>
                    </div>
                </form>
            </div>

            {{--
            ============================================================
            SECTION 3: BUG REPORT
            ============================================================
            --}}
            <div id="bug-report" class="section-card">
                <div class="d-flex align-items-center mb-3">
                    <div class="section-icon" style="background: #fef3c7; color: #d97706;">
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
                        <button type="submit" class="btn" style="background: #dc2626; color: #fff; border-radius: 10px; padding: 8px 22px; font-weight: 600; font-size: 0.85rem;">
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
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Cancel</button>
                    <button type="submit" class="btn btn-primary-gradient">Change Password</button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@livewireScripts
</body>
</html>
