<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniGrowth — Skills & Recommendations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(180deg, #f8faff 0%, #f3f6ff 100%);
            color: #1f2937;
        }
        .nav-link-custom { color: rgba(255,255,255,0.75); font-size: 0.875rem; font-weight: 500; padding: 6px 14px !important; border-radius: 8px; transition: all 0.2s; }
        .nav-link-custom:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .nav-link-custom i { margin-right: 6px; font-size: 0.9rem; }
        .avatar-link { display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: #fff; padding: 4px 10px 4px 4px; border-radius: 30px; transition: all 0.2s; }
        .avatar-link:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .avatar-img { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.3); }
        .avatar-initial { width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; background: rgba(255,255,255,0.2); color: #fff; border: 2px solid rgba(255,255,255,0.3); }
        .hero-card, .panel-card { background: #fff; border-radius: 24px; box-shadow: 0 18px 45px rgba(15, 23, 42, 0.07); border: 1px solid rgba(99, 102, 241, 0.08); }
        .hero-card { background: linear-gradient(135deg, #f8fbff 0%, #eef2ff 100%); }
        .pill { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 999px; background: #eef2ff; color: #4338ca; font-size: 0.78rem; font-weight: 600; }
        .chip-link { display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; border-radius: 999px; background: #f8fafc; color: #475569; text-decoration: none; font-size: 0.8rem; border: 1px solid #e2e8f0; transition: all 0.2s; }
        .chip-link:hover { background: #eef2ff; color: #4338ca; border-color: #c7d2fe; }
        .chip-link.active { background: #4338ca; color: #fff; border-color: #4338ca; }
        .skill-card { background: #fff; border-radius: 18px; border: 1px solid rgba(15, 23, 42, 0.06); padding: 1.25rem; transition: all 0.2s ease; height: 100%; }
        .skill-card:hover { transform: translateY(-3px); box-shadow: 0 16px 30px rgba(99, 102, 241, 0.12); border-color: rgba(99, 102, 241, 0.18); }
        .skill-card.enrolled { background: linear-gradient(135deg, #f0fdf4, #ecfdf5); border-color: #a7f3d0; }
        .tag-badge { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 600; background: #eef2ff; color: #4338ca; }
        .btn-gradient { background: linear-gradient(135deg, #6366f1, #7c3aed); color: #fff; border: none; border-radius: 10px; font-weight: 600; }
        .btn-gradient:hover { color: #fff; box-shadow: 0 8px 20px rgba(99, 102, 241, 0.22); }
        .btn-outline-soft { border: 1px solid #cbd5e1; color: #475569; background: #fff; border-radius: 10px; font-weight: 600; }
        .btn-outline-soft:hover { background: #f8fafc; color: #0f172a; }
        .muted-label { color: #64748b; font-size: 0.78rem; }
        .recommend-card { border: 1px solid #e2e8f0; border-radius: 16px; padding: 1rem; background: #f8fafc; }
        .search-shell { position: relative; }
        .search-shell .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .search-input { width: 100%; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 14px 10px 42px; font-size: 0.92rem; outline: none; }
        .search-input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12); }
        .recommend-card .match-pill { background: #dcfce7; color: #166534; }
        .recommend-card .cold-pill { background: #fef3c7; color: #92400e; }
        .section-title { font-size: 1rem; font-weight: 700; color: #0f172a; }
        @media (max-width: 767.98px) {
            .hero-card { padding: 1.2rem !important; }
            .skill-card { padding: 1rem !important; }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top" style="background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="{{ route('dashboard') }}"><i class="bi bi-mortarboard-fill me-2"></i>UniGrowth</a>
        <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#skillsNav" style="color: rgba(255,255,255,0.7);"><i class="bi bi-list fs-4"></i></button>
        <div class="collapse navbar-collapse" id="skillsNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
                <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link nav-link-custom"><i class="bi bi-house-door"></i>Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('core-assets.skills') }}" class="nav-link nav-link-custom"><i class="bi bi-book"></i>Skills</a></li>
                <li class="nav-item"><a href="{{ route('assessment.test.index') }}" class="nav-link nav-link-custom"><i class="bi bi-pencil-square"></i>Quiz</a></li>
                <li class="nav-item"><a href="{{ route('core-assets.index') }}" class="nav-link nav-link-custom"><i class="bi bi-bullseye"></i>Goals</a></li>
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
                    <button type="submit" class="btn btn-sm text-white border-0" style="background: rgba(255,255,255,0.1); border-radius: 8px;"><i class="bi bi-box-arrow-right me-1"></i>Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container py-4">
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
            <i class="bi bi-check-circle-fill flex-shrink-0"></i><span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
            <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i><span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="hero-card p-4 p-lg-5 mb-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <span class="pill"><i class="bi bi-lightning-charge"></i> Smart learning path</span>
                <h2 class="fw-bold mt-3 mb-2" style="color: #111827;">Discover skill tracks and follow what fits you best</h2>
                <p class="text-muted mb-3" style="max-width: 680px;">Browse the platform’s skills, enroll in the ones that matter, and explore personalized recommendations curated from your current learning interests.</p>
                <div class="d-flex flex-wrap gap-2 mb-2">
                    <span class="pill"><i class="bi bi-bookmark-check"></i> {{ count($availableSkills['skills'] ?? []) }} skills available</span>
                    <span class="pill"><i class="bi bi-stars"></i> {{ count($recommendations) }} recommendations</span>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="panel-card p-3 h-100 text-center">
                            <div class="fs-3 fw-bold text-primary">{{ count($availableSkills['skills'] ?? []) }}</div>
                            <div class="muted-label">Skill tracks</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="panel-card p-3 h-100 text-center">
                            <div class="fs-3 fw-bold text-success">{{ count($recommendations) }}</div>
                            <div class="muted-label">Recommended</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="panel-card p-4 mb-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                    <div>
                        <div class="section-title"><i class="bi bi-compass me-2" style="color: #6366f1;"></i>Explore skills</div>
                        <p class="text-muted small mb-0">Filter by tag and enroll in skills that support your goals.</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('core-assets.skills', ['sort' => 'newest']) }}" class="chip-link {{ ($sortBy ?? 'newest') === 'newest' ? 'active' : '' }}">Newest</a>
                        <a href="{{ route('core-assets.skills', ['sort' => 'most_enrolled']) }}" class="chip-link {{ ($sortBy ?? 'newest') === 'most_enrolled' ? 'active' : '' }}">Most enrolled</a>
                    </div>
                </div>

                <form method="GET" action="{{ route('core-assets.skills') }}" class="d-flex flex-wrap gap-2 align-items-center mb-3">
                    <div class="search-shell flex-grow-1">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="tag" class="search-input" placeholder="Search tags, e.g. php, design, data..." value="{{ $selectedTag ?? '' }}">
                    </div>
                    <input type="hidden" name="sort" value="{{ $sortBy ?? 'newest' }}">
                    <button type="submit" class="btn btn-gradient"><i class="bi bi-funnel me-1"></i>Filter</button>
                    <a href="{{ route('core-assets.skills', ['sort' => $sortBy ?? 'newest']) }}" class="btn btn-outline-soft">Reset</a>
                </form>

                <div id="tagChips" class="d-flex flex-wrap gap-2 mb-3">
                    <a href="{{ route('core-assets.skills', ['sort' => $sortBy ?? 'newest']) }}" class="chip-link {{ empty($selectedTag) ? 'active' : '' }}">All skills</a>
                    @foreach ($availableSkills['all_tags'] ?? [] as $tag)
                        <a href="{{ route('core-assets.skills', ['tag' => $tag, 'sort' => $sortBy ?? 'newest']) }}" class="chip-link {{ ($selectedTag ?? '') === $tag ? 'active' : '' }}">{{ $tag }}</a>
                    @endforeach
                </div>

                @if (!empty($availableSkills['skills']))
                    <div class="row g-3">
                        @foreach ($availableSkills['skills'] as $skill)
                            <div class="col-12 col-md-6">
                                <div class="skill-card {{ $skill['is_enrolled'] ? 'enrolled' : '' }} d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div>
                                            <h5 class="fw-bold mb-2" style="color: #111827;">{{ $skill['title'] }}</h5>
                                            <p class="small text-muted mb-3">{{ Str::limit($skill['description'], 100) }}</p>
                                        </div>
                                        @if ($skill['is_enrolled'])
                                            <span class="badge rounded-pill bg-success-subtle text-success">Enrolled</span>
                                        @endif
                                    </div>
                                    @if (!empty($skill['tags']))
                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                            @foreach ($skill['tags'] as $skillTag)
                                                <span class="tag-badge">{{ $skillTag }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top">
                                        <span class="muted-label"><i class="bi bi-people me-1"></i>{{ $skill['enrollments_count'] }} enrolled</span>
                                        @if ($skill['is_enrolled'])
                                            <span class="btn btn-sm btn-outline-soft" style="cursor: default;">Ready</span>
                                        @else
                                            <form action="{{ route('core-assets.action') }}" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="type" value="skill">
                                                <input type="hidden" name="action" value="enroll">
                                                <input type="hidden" name="payload[skill_id]" value="{{ $skill['id'] }}">
                                                <button type="submit" class="btn btn-sm btn-gradient"><i class="bi bi-plus-lg me-1"></i>Enroll</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        <p class="mb-0">No skills found for this selection.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-xl-4">
            <div class="panel-card p-4">
                <div class="section-title mb-3"><i class="bi bi-stars me-2" style="color: #7c3aed;"></i>Recommended for you</div>
                <p class="text-muted small mb-3">Based on your enrolled skills and common tags, these are the next best options.</p>

                @if (!empty($recommendations))
                    <div class="d-grid gap-3">
                        @foreach ($recommendations as $recommendation)
                            <div class="recommend-card">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-1" style="color: #111827;">{{ $recommendation['title'] }}</h6>
                                        <p class="small text-muted mb-0">{{ Str::limit($recommendation['description'], 90) }}</p>
                                    </div>
                                    @if (($recommendation['matching_tags_count'] ?? 0) > 0)
                                        <span class="badge rounded-pill match-pill">{{ $recommendation['matching_tags_count'] }} match</span>
                                    @else
                                        <span class="badge rounded-pill cold-pill">Cold start</span>
                                    @endif
                                </div>
                                @if (!empty($recommendation['matching_tags']))
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        @foreach ($recommendation['matching_tags'] as $tag)
                                            <span class="tag-badge">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="muted-label"><i class="bi bi-percent me-1"></i>{{ number_format(($recommendation['score'] ?? 0) * 100, 1) }}% fit</span>
                                    @if (!empty($recommendation['resource_link']))
                                        <a href="{{ $recommendation['resource_link'] }}" class="btn btn-sm btn-outline-soft" target="_blank" rel="noopener noreferrer">Open</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-emoji-smile fs-2 d-block mb-2"></i>
                        <p class="mb-0">No recommendations yet. Enroll in a few skills to unlock this section.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
