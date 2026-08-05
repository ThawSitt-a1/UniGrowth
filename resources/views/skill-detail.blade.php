<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $skill->title }} — {{ $platformName ?? 'UniGrowth' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; background: #f8fafc; color: #1f2937; }
        .nav-link-custom { color: rgba(255,255,255,0.75); font-size: 0.875rem; font-weight: 500; padding: 6px 14px !important; border-radius: 8px; transition: all 0.2s; }
        .nav-link-custom:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .nav-link-custom i { margin-right: 6px; }
        .avatar-link { display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: #fff; padding: 4px 10px 4px 4px; border-radius: 30px; transition: all 0.2s; }
        .avatar-link:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .avatar-img { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.3); }
        .avatar-initial { width: 34px; height: 34px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; background: rgba(255,255,255,0.2); color: #fff; border: 2px solid rgba(255,255,255,0.3); }
        .tag-badge { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 0.7rem; font-weight: 600; background: #eef2ff; color: #4338ca; }
        .btn-gradient { background: linear-gradient(135deg, #6366f1, #7c3aed); color: #fff; border: none; border-radius: 10px; font-weight: 600; }
        .btn-gradient:hover { color: #fff; box-shadow: 0 8px 20px rgba(99, 102, 241, 0.22); }
        .btn-gradient-success { background: linear-gradient(135deg, #059669, #10b981); color: #fff; border: none; border-radius: 10px; font-weight: 600; }
        .btn-gradient-success:hover { color: #fff; box-shadow: 0 8px 20px rgba(5, 150, 105, 0.22); }
        .detail-header { background: #fff; border-radius: 20px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); border: 1px solid rgba(0,0,0,0.04); }
        .sidebar-toc { position: sticky; top: 90px; max-height: calc(100vh - 110px); overflow-y: auto; }
        .sidebar-toc .toc-link { display: block; padding: 0.4rem 0.75rem; border-radius: 8px; color: #64748b; text-decoration: none; font-size: 0.85rem; transition: all 0.15s; border-left: 3px solid transparent; }
        .sidebar-toc .toc-link:hover { background: #f1f5f9; color: #1e293b; }
        .sidebar-toc .toc-link.active { background: #eef2ff; color: #4338ca; font-weight: 600; border-left-color: #4338ca; }
        .sidebar-toc .toc-link.h3 { padding-left: 1.5rem; font-size: 0.8rem; }
        .reading-content { max-width: 720px; line-height: 1.7; font-size: 1.05rem; color: #334155; }
        .reading-content h2 { font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-top: 2.5rem; margin-bottom: 1rem; scroll-margin-top: 80px; }
        .reading-content h3 { font-size: 1.2rem; font-weight: 600; color: #1e293b; margin-top: 2rem; margin-bottom: 0.75rem; scroll-margin-top: 80px; }
        .reading-content p { margin-bottom: 1.1rem; }
        .reading-content code { background: #f1f5f9; padding: 0.2rem 0.5rem; border-radius: 6px; font-size: 0.9em; font-family: 'SF Mono', Monaco, monospace; }
        .reading-content pre { background: #1e293b; color: #e2e8f0; padding: 1.25rem; border-radius: 12px; overflow-x: auto; margin: 1.5rem 0; }
        .reading-content pre code { background: none; padding: 0; color: inherit; font-size: 0.9rem; }
        .reading-content .callout { padding: 1.25rem; border-radius: 12px; margin: 1.75rem 0; border-left: 4px solid; }
        .reading-content .callout.info { background: #ecfdf5; border-left-color: #10b981; }
        .reading-content .callout.warning { background: #fffbeb; border-left-color: #f59e0b; }
        .reading-content .callout-title { font-weight: 600; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem; }
        .reading-content img { max-width: 100%; height: auto; border-radius: 12px; margin: 1.75rem 0; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .reading-content .ratio { margin: 1.75rem 0; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .reading-content ul, .reading-content ol { margin-bottom: 1.1rem; padding-left: 1.5rem; }
        .reading-content li { margin-bottom: 0.4rem; }
        .reading-content blockquote { border-left: 4px solid #6366f1; padding-left: 1rem; margin: 1.5rem 0; color: #475569; font-style: italic; }
        .detail-card { background: #fff; border-radius: 16px; border: 1px solid rgba(0,0,0,0.04); box-shadow: 0 2px 12px rgba(0,0,0,0.04); }
        .suspended-banner { background: #fef3c7; border: 1px solid #fcd34d; border-radius: 16px; padding: 2rem; margin-bottom: 1.5rem; }
        .suspended-banner h2 { color: #92400e; }
        .suspended-banner p { color: #92400e; }
        .suspended-banner { background: #fffbeb; border: 1px solid #facc15; border-radius: 20px; }
        .suspended-banner .banner-body { padding: 2rem; }
        .suspended-banner h2 { color: #92400e; }
        .suspended-banner p { color: #92400e; }
        .suspended-banner .badge-warning { background: #fef3c7; color: #713f12; }
        .locked-overlay { position: relative; }
        .locked-overlay::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 40%, rgba(255,255,255,0.95)); pointer-events: none; border-radius: 16px; }
        .progress-indicator { position: fixed; top: 0; left: 0; height: 3px; background: linear-gradient(90deg, #6366f1, #7c3aed); z-index: 1050; transition: width 0.1s; }@media (max-width: 991.98px) { .sidebar-toc { position: static; max-height: none; margin-bottom: 1.5rem; } }
        @media (max-width: 400px) {
            body { overflow-x: hidden; }
            .detail-header { padding: 1rem !important; }
            .detail-header h1 { font-size: 1.5rem !important; }
            .detail-header .fs-5 { font-size: 0.95rem !important; }
            .detail-card { padding: 1rem !important; }
            .reading-content { font-size: 0.95rem !important; }
            .reading-content h2 { font-size: 1.2rem !important; }
            .reading-content h3 { font-size: 1rem !important; }
            .tag-badge { font-size: 0.6rem !important; padding: 3px 8px !important; }
            .btn-gradient { font-size: 0.85rem !important; padding: 8px 16px !important; }
        }
        .section-anchor { opacity: 0; margin-left: 0.5rem; font-size: 0.85em; color: #6366f1; text-decoration: none; transition: opacity 0.2s; }
        h2:hover .section-anchor, h3:hover .section-anchor { opacity: 1; }
    </style>
</head>
<body>
    <div class="progress-indicator" id="readingProgress"></div>

    <nav class="navbar navbar-expand-lg sticky-top" style="background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="{{ route('dashboard') }}"><i class="bi bi-mortarboard-fill me-2"></i>{{ $platformName ?? 'UniGrowth' }}</a>
            <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#nav" style="color: rgba(255,255,255,0.7);"><i class="bi bi-list fs-4"></i></button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link nav-link-custom"><i class="bi bi-house-door"></i>Dashboard</a></li>
                    <li class="nav-item"><a href="{{ route('core-assets.skills') }}" class="nav-link nav-link-custom"><i class="bi bi-book"></i>Skills</a></li>
                    <li class="nav-item"><a href="{{ route('assessment.test.index') }}" class="nav-link nav-link-custom"><i class="bi bi-pencil-square"></i>Quiz</a></li>
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
                    <form action="/logout" method="POST" class="m-0">@csrf<button type="submit" class="btn btn-sm text-white border-0" style="background: rgba(255,255,255,0.1); border-radius: 8px;"><i class="bi bi-box-arrow-right me-1"></i>Logout</button></form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert"><i class="bi bi-check-circle-fill flex-shrink-0"></i><span>{{ session('success') }}</span></div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert"><i class="bi bi-exclamation-circle-fill flex-shrink-0"></i><span>{{ session('error') }}</span></div>
        @endif

        <a href="{{ route('core-assets.skills') }}" class="text-decoration-none small mb-3 d-inline-flex align-items-center" style="color: #6b7280;"><i class="bi bi-arrow-left me-1"></i>Back to all skills</a>

        <!-- ===== STAGE 1: Pre-Enrollment Header (Always Visible) ===== -->
        <div class="detail-header p-4 p-lg-5 mb-4">
            <div class="row g-4 align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @if(!empty($skill->tags) && is_array($skill->tags))
                            @foreach($skill->tags as $tag)
                                <span class="tag-badge">{{ $tag }}</span>
                            @endforeach
                        @endif
                    </div>
                    <h1 class="display-5 fw-bold mb-3" style="color: #0f172a;">{{ $skill->title }}</h1>
                    <p class="fs-5 text-muted mb-4" style="max-width: 640px;">{{ $skill->description }}</p>
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-0">
                        <span class="d-flex align-items-center gap-2 small text-muted"><i class="bi bi-people"></i>{{ number_format($skill->enrollments_count) }} enrolled</span>
                        @if(($skill->content ?? '') !== '')
                            <span class="d-flex align-items-center gap-2 small text-muted"><i class="bi bi-file-text"></i>Full curriculum included</span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    @if(!empty($isSuspended))
                        <span class="badge bg-warning text-dark mb-2 px-3 py-2"><i class="bi bi-slash-circle me-1"></i>Suspended</span>
                    @elseif($isEnrolled)
                        <span class="badge bg-success mb-2 px-3 py-2"><i class="bi bi-check-circle me-1"></i>Enrolled</span>
                    @else
                        <form action="{{ route('core-assets.action') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="skill">
                            <input type="hidden" name="action" value="enroll">
                            <input type="hidden" name="payload[skill_id]" value="{{ $skill->id }}">
                            <input type="hidden" name="redirect" value="{{ route('core-assets.skills.detail', $skill->slug) }}">
                            <button type="submit" class="btn btn-gradient btn-lg px-5"><i class="bi bi-plus-circle me-2"></i>Enroll Now</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        @if(!empty($isSuspended))
            <div class="suspended-banner detail-card mb-4">
                <div class="banner-body text-center">
                    <span class="badge badge-warning mb-3"><i class="bi bi-slash-circle me-1"></i>Suspended</span>
                    <h2 class="fw-bold mt-3 mb-3">This skill is suspended</h2>
                    <p class="fs-5 mb-4" style="max-width: 680px; margin: 0 auto; line-height: 1.7;">
                        {{ $suspensionReason }}
                    </p>
                    <p class="small mb-0">
                        The learning content for this skill is temporarily disabled and cannot be accessed until it is restored by an administrator.
                    </p>
                </div>
            </div>
        @elseif($isEnrolled)
            <!-- ===== STAGE 2: Post-Enrollment View (Full Content) ===== -->
            <div class="row g-4">
                <!-- Sidebar TOC -->
                <div class="col-lg-3">
                    <div class="sidebar-toc detail-card p-3">
                        <h6 class="fw-bold mb-3 px-2" style="color: #0f172a;"><i class="bi bi-list-ul me-2"></i>On this page</h6>
                        <div id="toc-links">
                            @if(!empty($headings))
                                @foreach($headings as $heading)
                                    <a href="#{{ $heading['id'] }}" class="toc-link {{ $heading['type'] === 'h3' ? 'h3' : '' }}" data-target="{{ $heading['id'] }}">
                                        @if($heading['type'] === 'h3')<i class="bi bi-dot me-2"></i>@endif
                                        {{ $heading['content'] }}
                                    </a>
                                @endforeach
                            @else
                                <a href="#content" class="toc-link active"><i class="bi bi-file-text me-2"></i>Content</a>
                            @endif
                            @if(!empty($skill->resource_link))
                                <a href="#resources" class="toc-link"><i class="bi bi-link-45deg me-2"></i>Resources</a>
                            @endif
                            @if($questions->count() > 0)
                                <a href="#assessment" class="toc-link"><i class="bi bi-pencil-square me-2"></i>Assessment</a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Main Reading Canvas -->
                <div class="col-lg-9">
                    <div class="detail-card p-4 p-lg-5">
                        <!-- Content Section -->
                        <div id="content" class="reading-content">
                            @if(!empty($contentBlocks))
                                @foreach($contentBlocks as $block)
                                    @switch($block['type'])
                                        @case('h2')
                                            <h2 id="{{ $block['id'] }}">
                                                {{ $block['content'] }}
                                                <a href="#{{ $block['id'] }}" class="section-anchor"><i class="bi bi-link"></i></a>
                                            </h2>
                                            @break
                                        @case('h3')
                                            <h3 id="{{ $block['id'] }}">
                                                {{ $block['content'] }}
                                                <a href="#{{ $block['id'] }}" class="section-anchor"><i class="bi bi-link"></i></a>
                                            </h3>
                                            @break
                                        @case('paragraph')
                                            <p>{!! nl2br(e($block['content'])) !!}</p>
                                            @break
                                        @case('code')
                                            <pre><code class="language-{{ $block['language'] }}">{{ e($block['content']) }}</code></pre>
                                            @break
                                        @case('callout')
                                            <div class="callout {{ $block['calloutType'] }}">
                                                <div class="callout-title">
                                                    @if($block['calloutType'] === 'info')
                                                        <i class="bi bi-info-circle-fill"></i> Info
                                                    @else
                                                        <i class="bi bi-exclamation-triangle-fill"></i> Warning
                                                    @endif
                                                </div>
                                                <p class="mb-0">{{ $block['content'] }}</p>
                                            </div>
                                            @break
                                        @case('image')
                                            <img src="{{ $block['url'] }}" alt="{{ $block['alt'] }}" class="img-fluid">
                                            @break
                                        @case('video')
                                            <div class="ratio ratio-16by9">
                                                <iframe src="{{ $block['url'] }}" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                                            </div>
                                            @break
                                    @endswitch
                                @endforeach
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="bi bi-file-earmark-text fs-1 d-block mb-3"></i>
                                    <p class="mb-0">No content has been added to this skill yet. Check back later.</p>
                                </div>
                            @endif
                        </div>

                        @php
                            $resourceLinks = [];
                            // Support legacy single link
                            if (!empty($skill->resource_link)) {
                                $resourceLinks[] = [
                                    'url' => $skill->resource_link,
                                    'label' => 'Resource Link'
                                ];
                            }
                            // Support new multiple links
                            if (!empty($skill->resource_links) && is_array($skill->resource_links)) {
                                foreach ($skill->resource_links as $link) {
                                    if (!empty($link['url'])) {
                                        $resourceLinks[] = $link;
                                    }
                                }
                            }
                        @endphp

                        @if(!empty($resourceLinks))
                            <hr class="my-5">
                            <div id="resources">
                                <h5 class="fw-bold mb-3" style="color: #0f172a;"><i class="bi bi-link-45deg me-2"></i>External Resources</h5>
                                <div class="callout info">
                                    <p class="mb-2 fw-semibold">Supplemental Reading</p>
                                    <p class="text-muted small mb-3">Explore these external resources to deepen your understanding of the topics covered in this lesson.</p>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($resourceLinks as $link)
                                            <li class="mb-2">
                                                <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none" style="color: #6366f1; font-family: 'SF Mono', Monaco, monospace; font-size: 0.9rem; word-break: break-all;">
                                                    <i class="bi bi-link-45deg me-1"></i>{{ $link['url'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                            <hr class="my-5">
                            <div id="assessment">
                                <h5 class="fw-bold mb-3" style="color: #0f172a;"><i class="bi bi-pencil-square me-2"></i>Assessment</h5>
                                @if($questions->count() > 0)
                                    @php
                                        $easyCount = $questions->where('difficulty', 'easy')->count();
                                        $mediumCount = $questions->where('difficulty', 'medium')->count();
                                        $hardCount = $questions->where('difficulty', 'hard')->count();
                                    @endphp
                                    <p class="text-muted mb-3">Test your knowledge with {{ $questions->count() }} question(s) across 3 difficulty tiers.</p>
                                    <div class="d-flex flex-wrap gap-2 mb-4">
                                        <span class="badge-difficulty easy px-3 py-2" style="font-size:0.8rem;"><i class="bi bi-check-circle me-1"></i>{{ $easyCount }} Easy</span>
                                        <span class="badge-difficulty medium px-3 py-2" style="font-size:0.8rem;"><i class="bi bi-check-circle me-1"></i>{{ $mediumCount }} Medium</span>
                                        <span class="badge-difficulty hard px-3 py-2" style="font-size:0.8rem;"><i class="bi bi-check-circle me-1"></i>{{ $hardCount }} Hard</span>
                                    </div>
                                    <a href="{{ route('assessment.test.index') }}?skill_id={{ $skill->id }}" class="btn btn-gradient-success">
                                        <i class="bi bi-pencil-square me-1"></i>Take Quiz
                                    </a>
                                @else
                                    <p class="text-muted mb-3">Test your knowledge with questions across 3 difficulty tiers.</p>
                                    <div class="d-flex flex-wrap gap-2 mb-4">
                                        <span class="badge-difficulty easy px-3 py-2" style="font-size:0.8rem;"><i class="bi bi-check-circle me-1"></i>0 Easy</span>
                                        <span class="badge-difficulty medium px-3 py-2" style="font-size:0.8rem;"><i class="bi bi-check-circle me-1"></i>0 Medium</span>
                                        <span class="badge-difficulty hard px-3 py-2" style="font-size:0.8rem;"><i class="bi bi-check-circle me-1"></i>0 Hard</span>
                                    </div>
                                    <button class="btn btn-gradient-success" disabled>
                                        <i class="bi bi-pencil-square me-1"></i>Coming Soon
                                    </button>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
        @else
            <!-- ===== STAGE 1: Pre-Enrollment View (Content Hidden) ===== -->
            <div class="detail-card p-5 text-center locked-overlay">
                <div class="py-5" style="position: relative; z-index: 2;">
                    <i class="bi bi-lock-fill" style="font-size: 3rem; color: #d1d5db;"></i>
                    <h4 class="fw-bold mt-3 mb-2" style="color: #1f2937;">Content Locked</h4>
                    <p class="text-muted mb-4" style="max-width: 480px; margin: 0 auto;">Enroll in this skill to access the full curriculum, including detailed lessons, external resources, and assessment quizzes.</p>
                    <form action="{{ route('core-assets.action') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="skill">
                        <input type="hidden" name="action" value="enroll">
                        <input type="hidden" name="payload[skill_id]" value="{{ $skill->id }}">
                        <input type="hidden" name="redirect" value="{{ route('core-assets.skills.detail', $skill->slug) }}">
                        <button type="submit" class="btn btn-gradient btn-lg px-5"><i class="bi bi-plus-circle me-2"></i>Enroll Now to Unlock</button>
                    </form>
                </div>
                <!-- Preview of locked content (blurred/faded) -->
                <div class="mt-4 text-start opacity-25 user-select-none" style="filter: blur(4px);">
                    <div style="height: 20px; width: 100%; background: #e5e7eb; border-radius: 4px; margin-bottom: 12px;"></div>
                    <div style="height: 20px; width: 80%; background: #e5e7eb; border-radius: 4px; margin-bottom: 12px;"></div>
                    <div style="height: 20px; width: 90%; background: #e5e7eb; border-radius: 4px; margin-bottom: 12px;"></div>
                    <div style="height: 20px; width: 60%; background: #e5e7eb; border-radius: 4px; margin-bottom: 12px;"></div>
                </div>
            </div>
        @endif
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Reading progress indicator
        window.addEventListener('scroll', function() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById('readingProgress').style.width = scrolled + '%';
        });

        // Active TOC link highlighting
        const tocLinks = document.querySelectorAll('.toc-link');
        const sections = [];

        tocLinks.forEach(link => {
            const targetId = link.getAttribute('data-target') || link.getAttribute('href')?.substring(1);
            if (targetId) {
                const section = document.getElementById(targetId);
                if (section) {
                    sections.push({ link, section, id: targetId });
                }
            }
        });

        function updateActiveTocLink() {
            let currentSection = null;
            const scrollPos = window.scrollY + 100;

            sections.forEach(({ section }) => {
                if (section.offsetTop <= scrollPos) {
                    currentSection = section;
                }
            });

            tocLinks.forEach(link => link.classList.remove('active'));
            if (currentSection) {
                const activeLink = document.querySelector(`.toc-link[data-target="${currentSection.id}"], .toc-link[href="#${currentSection.id}"]`);
                if (activeLink) activeLink.classList.add('active');
            }
        }

        window.addEventListener('scroll', updateActiveTocLink);
        updateActiveTocLink();
    </script>
    <style>
        .badge-difficulty { font-size: 0.7rem; font-weight: 600; padding: 0.25em 0.65em; border-radius: 20px; }
        .badge-difficulty.easy { background: #d1fae5; color: #065f46; }
        .badge-difficulty.medium { background: #fef3c7; color: #b45309; }
        .badge-difficulty.hard { background: #fee2e2; color: #991b1b; }
</style>
@include('partials.footer')
</body>
</html>
