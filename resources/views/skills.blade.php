<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniGrowth — Browse Skills</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; background: #f5f7fa; }
        .nav-link-custom { color: rgba(255,255,255,0.75); font-size: 0.875rem; font-weight: 500; padding: 6px 14px !important; border-radius: 8px; transition: all 0.2s; }
        .nav-link-custom:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .nav-link-custom i { margin-right: 6px; font-size: 0.9rem; }
        .avatar-link { display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: #fff; padding: 4px 10px 4px 4px; border-radius: 30px; transition: all 0.2s; }
        .avatar-link:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .avatar-img { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.3); }
        .avatar-initial { width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; background: rgba(255,255,255,0.2); color: #fff; border: 2px solid rgba(255,255,255,0.3); }
        .form-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 30px rgba(0,0,0,0.06), 0 1px 8px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.04); }
        .skill-card { background: #fff; border-radius: 14px; border: 1px solid rgba(0,0,0,0.06); padding: 1.5rem; transition: all 0.3s ease; height: 100%; box-shadow: 0 2px 12px rgba(0,0,0,0.04); }
        .skill-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(99,102,241,0.12); border-color: rgba(99,102,241,0.15); }
        .skill-card.enrolled { border-color: #10b981; background: linear-gradient(135deg, #f0fdf4, #ecfdf5); }
        .tag-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; background: #eef2ff; color: #4f46e5; text-decoration: none; transition: all 0.2s; }
        .tag-badge:hover { background: #6366f1; color: #fff; }
        .btn-gradient { padding: 8px 22px; border: none; border-radius: 10px; font-size: 0.85rem; font-weight: 600; color: #fff; background: linear-gradient(135deg, #6366f1, #7c3aed); cursor: pointer; transition: all 0.2s; }
        .btn-gradient:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(99,102,241,0.35); color: #fff; }
        .btn-gradient-sm { padding: 6px 16px; font-size: 0.8rem; border-radius: 8px; }
        .btn-outline-custom { border: 2px solid #6366f1; color: #6366f1; background: transparent; border-radius: 10px; padding: 6px 16px; font-size: 0.8rem; font-weight: 600; transition: all 0.2s; }
        .btn-outline-custom:hover { background: #6366f1; color: #fff; }
        .stat-chip { display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 500; background: #f3f4f6; color: #6b7280; }
        .search-input { width: 100%; padding: 10px 16px 10px 40px; border: 1px solid #e5e7eb; border-radius: 12px; font-size: 0.9rem; outline: none; }
        .search-input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; }
        .sort-btn { padding: 6px 16px; border-radius: 8px; font-size: 0.8rem; font-weight: 500; text-decoration: none; color: #6b7280; background: #f3f4f6; }
        .sort-btn:hover { background: #e5e7eb; color: #374151; }
        .sort-btn.active { background: #6366f1; color: #fff; }
        @media (max-width: 767.98px) { .skill-card { padding: 1rem !important; } }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg sticky-top" style="background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="{{ route('dashboard') }}"><i class="bi bi-mortarboard-fill me-2"></i>UniGrowth</a>
        <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#skillsNav" style="color: rgba(255,255,255,0.7);"><i class="bi bi-list fs-4"></i></button>
        <div class="collapse navbar-collapse" id="skillsNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
                <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link nav-link-custom"><i class="bi bi-house-door"></i>Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('overview.index') }}" class="nav-link nav-link-custom"><i class="bi bi-bar-chart-line"></i>Overview</a></li>
                <li class="nav-item"><a href="{{ route('core-assets.skills') }}" class="nav-link nav-link-custom"><i class="bi bi-book"></i>Skills</a></li>
                <li class="nav-item"><a href="{{ route('assessment.test.index') }}" class="nav-link nav-link-custom"><i class="bi bi-pencil-square"></i>Quiz</a></li>
                <li class="nav-item"><a href="{{ route('core-assets.index') }}" class="nav-link nav-link-custom"><i class="bi bi-bullseye"></i>Goals</a></li>
                <li class="nav-item"><a href="{{ route('core.test-recommendations.index') }}" class="nav-link nav-link-custom"><i class="bi bi-stars"></i>Recommend</a></li>
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

{{-- MAIN CONTENT --}}
<div class="container py-4">

    @if (session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
        <i class="bi bi-check-circle-fill flex-shrink-0"></i> <span>{{ session('success') }}</span>
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
        <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i> <span>{{ session('error') }}</span>
    </div>
    @endif

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1f2937;"><i class="bi bi-book me-2" style="color: #6366f1;"></i>Browse Skills</h4>
            <p class="text-muted small mb-0">Discover and enroll in skill tracks to accelerate your growth</p>
        </div>
        <div class="d-flex gap-2">
            <span class="stat-chip"><i class="bi bi-grid-3x3-gap"></i> {{ count($availableSkills['skills'] ?? []) }} skills</span>
            @if ($availableSkills['selected_tag'])
            <span class="stat-chip" style="background: #eef2ff; color: #4f46e5;"><i class="bi bi-tag"></i> {{ $availableSkills['selected_tag'] }}
                <a href="{{ route('core-assets.skills', ['sort' => $availableSkills['sort_by']]) }}" class="text-decoration-none ms-1" style="color: inherit;"><i class="bi bi-x-circle"></i></a>
            </span>
            @endif
        </div>
    </div>

    <div class="form-card p-4 mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-12 col-md-6">
                <label for="tagSearch" class="form-label small fw-semibold text-secondary mb-2"><i class="bi bi-search me-1"></i>Search by tag:</label>
                <div class="position-relative">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" id="tagSearch" class="search-input" placeholder="Type a tag to filter skills..." oninput="filterSkillsByTag(this.value)">
                </div>
            </div>
            <div class="col-12 col-md-auto ms-auto">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="small fw-semibold text-secondary"><i class="bi bi-arrow-up-down me-1"></i>Sort:</span>
                    <a href="{{ route('core-assets.skills', ['sort' => 'newest']) }}" class="sort-btn {{ $availableSkills['sort_by'] === 'newest' ? 'active' : '' }}">Newest</a>
                    <a href="{{ route('core-assets.skills', ['sort' => 'most_enrolled']) }}" class="sort-btn {{ $availableSkills['sort_by'] === 'most_enrolled' ? 'active' : '' }}">Most Enrolled</a>
                </div>
            </div>
        </div>
        <div id="tagSuggestions" class="d-flex flex-wrap gap-2 mt-3" style="display: none !important;"></div>
    </div>

    <div class="d-flex align-items-center gap-2 mb-3">
        <span id="filteredCount" class="stat-chip"><i class="bi bi-grid-3x3-gap"></i> <span id="countValue">{{ count($availableSkills['skills'] ?? []) }}</span> skills</span>
        <span id="activeTagChip" class="stat-chip" style="background: #eef2ff; color: #4f46e5; display: none;"><i class="bi bi-tag"></i> Filtered: <span id="activeTagName"></span>
            <a href="#" onclick="clearTagFilter(); return false;" class="text-decoration-none ms-1" style="color: inherit;"><i class="bi bi-x-circle"></i></a>
        </span>
    </div>

    <div id="skillsGrid" class="row g-4">
        @forelse ($availableSkills['skills'] ?? [] as $skill)
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 skill-col" data-tags="{{ implode(' ', $skill['tags']) }}">
            <div class="skill-card {{ $skill['is_enrolled'] ? 'enrolled' : '' }} d-flex flex-column">
                @if ($skill['is_enrolled'])
                <div class="d-flex justify-content-end mb-1"><span class="badge rounded-pill" style="background: #10b981; font-size: 0.65rem;"><i class="bi bi-check-lg me-1"></i>Enrolled</span></div>
                @endif
                <div class="flex-grow-1">
                    <h5 class="fw-bold mb-2 text-truncate" style="color: #1f2937;">{{ $skill['title'] }}</h5>
                    <p class="small text-muted mb-3" style="line-height: 1.5;">{{ Str::limit($skill['description'], 100) }}</p>
                </div>
                @if (count($skill['tags']) > 0)
                <div class="d-flex flex-wrap gap-1 mb-3">@foreach ($skill['tags'] as $skillTag)<span class="tag-badge" style="font-size: 0.65rem; cursor: default;">{{ $skillTag }}</span>@endforeach</div>
                @endif
        <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                    <span class="stat-chip"><i class="bi bi-people"></i> {{ $skill['enrollments_count'] }} enrolled</span>
                    @if ($skill['is_enrolled'])
                    <span class="btn btn-sm" style="background: #d1fae5; color: #065f46; border: none; font-weight: 600; border-radius: 8px; cursor: default; font-size: 0.75rem;"><i class="bi bi-check2 me-1"></i>Enrolled</span>
                    @else
                    <form action="{{ route('core-assets.action') }}" method="POST" class="m-0">@csrf
                        <input type="hidden" name="type" value="skill"><input type="hidden" name="action" value="enroll"><input type="hidden" name="payload[skill_id]" value="{{ $skill['id'] }}">
                        <button type="submit" class="btn btn-gradient btn-gradient-sm"><i class="bi bi-plus-lg me-1"></i>Enroll</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="form-card p-5 text-center" id="emptyState">
                <div class="py-4"><i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db;"></i><h5 class="fw-bold mt-3 mb-1" style="color: #6b7280;">No skills available</h5><p class="small text-muted mb-0">No skills are available yet. Check back later!</p></div>
            </div>
        </div>
        @endforelse
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-custom" style="padding: 8px 24px;"><i class="bi bi-arrow-left me-1"></i>Back to Dashboard</a>
    </div>

</div>

<script>
const allTags = @json($availableSkills['all_tags'] ?? []);
function filterSkillsByTag(query) {
    const normalized = query.trim().toLowerCase();
    const skillCols = document.querySelectorAll('.skill-col');
    const emptyState = document.getElementById('emptyState');
    const countSpan = document.getElementById('countValue');
    const activeChip = document.getElementById('activeTagChip');
    const activeTagName = document.getElementById('activeTagName');
    const suggestions = document.getElementById('tagSuggestions');
    let visibleCount = 0;
    let matchedTag = '';
    if (normalized.length > 0) {
        const exact = allTags.find(t => t.toLowerCase() === normalized);
        const partial = allTags.find(t => t.toLowerCase().includes(normalized));
        matchedTag = exact || partial || '';
    }
    skillCols.forEach(col => {
        const tags = (col.dataset.tags || '').toLowerCase();
        const matches = matchedTag ? tags.includes(matchedTag.toLowerCase()) : true;
        col.style.display = matches ? '' : 'none';
        if (matches) visibleCount++;
    });
    countSpan.textContent = visibleCount;
    if (matchedTag) { activeTagName.textContent = matchedTag; activeChip.style.display = 'inline-flex'; } else { activeChip.style.display = 'none'; }
    if (normalized.length > 0 && !allTags.some(t => t.toLowerCase() === normalized)) {
        const matches = allTags.filter(t => t.toLowerCase().includes(normalized)).slice(0, 8);
        if (matches.length > 0) { suggestions.style.display = 'flex'; suggestions.innerHTML = matches.map(t => '<span class="tag-badge" style="cursor: pointer;" onclick="selectTag(\'' + t + '\')">' + t + '</span>').join(''); }
        else { suggestions.style.display = 'none'; }
    } else { suggestions.style.display = 'none'; }
    if (visibleCount === 0 && skillCols.length > 0) {
        if (!emptyState) {
            const grid = document.getElementById('skillsGrid');
            const emptyDiv = document.createElement('div'); emptyDiv.className = 'col-12'; emptyDiv.id = 'emptyState';
            emptyDiv.innerHTML = '<div class="form-card p-5 text-center"><div class="py-4"><i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db;"></i><h5 class="fw-bold mt-3 mb-1" style="color: #6b7280;">No skills match</h5><p class="small text-muted mb-0">No skills found with tag matching "<strong>' + (matchedTag || normalized) + '</strong>". Try a different search.</p></div>';
            grid.appendChild(emptyDiv);
        } else { emptyState.style.display = ''; const strong = emptyState.querySelector('strong'); if (strong) strong.textContent = matchedTag || normalized; }
    } else if (emptyState) { emptyState.style.display = 'none'; }
}
function selectTag(tag) { document.getElementById('tagSearch').value = tag; filterSkillsByTag(tag); }
function clearTagFilter() { document.getElementById('tagSearch').value = ''; filterSkillsByTag(''); document.getElementById('tagSearch').focus(); }
document.getElementById('tagSearch')?.addEventListener('focus', function() {
    if (this.value.trim() === '') {
        const s = document.getElementById('tagSuggestions');
        s.style.display = 'flex'; s.innerHTML = allTags.slice(0, 12).map(t => '<span class="tag-badge" style="cursor: pointer;" onclick="selectTag(\'' + t + '\')">' + t + '</span>').join('');
    }
});
document.getElementById('tagSearch')?.addEventListener('blur', function() { setTimeout(() => { document.getElementById('tagSuggestions').style.display = 'none'; }, 200); });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
