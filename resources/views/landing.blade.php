<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $platformName ?? 'UniGrowth' }} — Student Development Platform</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #7c3aed;
            --accent: #a5b4fc;
            --dark-bg: #1e1b4b;
            --card-shadow: 0 4px 30px rgba(0,0,0,0.06);
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f0f2f5;
        }
        .bg-grid {
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .bg-dots {
            background-image: radial-gradient(rgba(99,102,241,0.08) 1px, transparent 1px);
            background-size: 30px 30px;
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

        /* Hero illustration container */
        .hero-illustration {
            position: relative;
            width: 100%;
            max-width: 420px;
            aspect-ratio: 5/4;
            max-height: 340px;
        }
        .hero-illustration svg {
            width: 100%;
            height: 100%;
        }
        .hero-illustration .floating-badge {
            position: absolute;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 8px 14px;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            animation: float 3s ease-in-out infinite;
        }
        .hero-illustration .floating-badge:nth-child(2) { top: 5%; right: -10%; animation-delay: 0.5s; }
        .hero-illustration .floating-badge:nth-child(3) { bottom: 15%; left: -15%; animation-delay: 1s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
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
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            border-radius: 16px 16px 0 0;
        }
        .feature-card:nth-child(1)::before { background: linear-gradient(90deg, #6366f1, #818cf8); }
        .feature-card:nth-child(2)::before { background: linear-gradient(90deg, #7c3aed, #a78bfa); }
        .feature-card:nth-child(3)::before { background: linear-gradient(90deg, #059669, #34d399); }
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

        /* CTA section with background image feel */
        .cta-section {
            background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(99,102,241,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(139,92,246,0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        @media (max-width: 767.98px) {
            .hero-title { font-size: 2.5rem !important; }
            .hero-illustration .floating-badge { display: none; }
        }
        @media (max-width: 400px) {
            body { overflow-x: hidden; }
            .hero-title { font-size: 1.8rem !important; }
        }
    </style>
</head>
<body>

    {{--
    ============================================================
    GUEST / UNAUTHENTICATED VIEW — Landing Page with SVG Illustration
    ============================================================
    --}}

    <!-- Hero Section with SVG Illustration -->
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
                        <i class="bi bi-mortarboard-fill me-2"></i>{{ $platformName ?? 'UniGrowth' }}
                    </span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-light-custom btn-sm">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-sm">Get Started</a>
                    </div>
                </div>
            </nav>

            <!-- Hero Content: Text Left, SVG Illustration Right -->
            <div class="row align-items-center" style="min-height: 80vh;">
                <div class="col-lg-6 text-white py-5">
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
                        {{ $platformName ?? 'UniGrowth' }} is the all-in-one platform for university students to set goals,
                        develop new skills, and track personal growth throughout their academic journey.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <span class="tech-badge"><i class="bi bi-bootstrap-fill"></i> Bootstrap 5</span>
                        <span class="tech-badge"><i class="bi bi-filetype-php"></i> PHP / Laravel</span>
                        <span class="tech-badge"><i class="bi bi-code-slash"></i> Blade Engine</span>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('register') }}" class="btn btn-primary-custom">
                            <i class="bi bi-person-plus me-2"></i>Create Free Account
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light-custom">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center">
                    <div class="hero-illustration">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                        <!-- Floating badges over illustration -->
                        <div class="floating-badge">
                            <i class="bi bi-star-fill" style="color: #fbbf24;"></i> Top 10%
                        </div>
                        <div class="floating-badge">
                            <i class="bi bi-graph-up-arrow" style="color: #34d399;"></i> +45% Growth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section with Image-Text pattern -->
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

<!-- ===== Image-Text Alternating Sections ===== -->

        <!-- Section 1: Image Left, Text Right -->
        <div class="row g-0 align-items-center mt-5 overflow-hidden rounded-4" style="background: #f8fafc; border: 1px solid rgba(0,0,0,0.04);">
            <div class="col-md-5 p-0">
                <div style="background: linear-gradient(135deg, #eef2ff, #faf5ff); padding: 3rem 2rem; min-height: 300px; display: flex; align-items: center; justify-content: center;">
                    <div style="max-width: 240px; opacity: 0.8;">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-7 p-4 p-md-5">
                <span class="badge bg-light text-primary fw-semibold mb-2 px-3 py-2">Why {{ $platformName ?? 'UniGrowth' }}?</span>
                <h3 class="fw-bold mb-3" style="color: #1f2937; font-size: 1.6rem;">Built for university students, by developers</h3>
                <p class="text-muted mb-3">Track your skill development journey with personalized recommendations, leaderboards, and detailed analytics — all in one platform designed for academic growth.</p>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1" style="color: #059669;"></i>
                            <div><span class="fw-semibold d-block" style="color: #1f2937;">Goal Setting</span><small class="text-muted">Define and track goals</small></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1" style="color: #059669;"></i>
                            <div><span class="fw-semibold d-block" style="color: #1f2937;">Skill Quizzes</span><small class="text-muted">Test your knowledge</small></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1" style="color: #059669;"></i>
                            <div><span class="fw-semibold d-block" style="color: #1f2937;">Leaderboards</span><small class="text-muted">Compete with peers</small></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-check-circle-fill mt-1" style="color: #059669;"></i>
                            <div><span class="fw-semibold d-block" style="color: #1f2937;">Analytics</span><small class="text-muted">Track your progress</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Image Right, Text Left (alternating) -->
        <div class="row g-0 align-items-center mt-4 overflow-hidden rounded-4" style="background: #f8fafc; border: 1px solid rgba(0,0,0,0.04);">
            <div class="col-md-7 p-4 p-md-5 order-2 order-md-1">
                <span class="badge bg-light text-success fw-semibold mb-2 px-3 py-2">Personalized Learning</span>
                <h3 class="fw-bold mb-3" style="color: #1f2937; font-size: 1.6rem;">Smart recommendations tailored to you</h3>
                <p class="text-muted mb-3">Our recommendation engine analyzes your enrolled skills, interests, and performance to suggest the most relevant skills and learning paths — helping you discover new areas to grow.</p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <span class="badge" style="background: #eef2ff; color: #4f46e5; font-size: 0.8rem; padding: 6px 14px;">
                        <i class="bi bi-stars me-1"></i>Jaccard Similarity
                    </span>
                    <span class="badge" style="background: #faf5ff; color: #7c3aed; font-size: 0.8rem; padding: 6px 14px;">
                        <i class="bi bi-tag me-1"></i>Tag Intersection
                    </span>
                    <span class="badge" style="background: #ecfdf5; color: #059669; font-size: 0.8rem; padding: 6px 14px;">
                        <i class="bi bi-graph-up me-1"></i>Performance Based
                    </span>
                </div>
            </div>
            <div class="col-md-5 p-0 order-1 order-md-2">
                <div style="background: linear-gradient(135deg, #faf5ff, #f3e8ff); padding: 3rem 2rem; min-height: 300px; display: flex; align-items: center; justify-content: center;">
                    <div style="max-width: 240px; opacity: 0.8;">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Image Left, Text Right -->
        <div class="row g-0 align-items-center mt-4 overflow-hidden rounded-4" style="background: #f8fafc; border: 1px solid rgba(0,0,0,0.04);">
            <div class="col-md-5 p-0">
                <div style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); padding: 3rem 2rem; min-height: 300px; display: flex; align-items: center; justify-content: center;">
                    <div style="max-width: 240px; opacity: 0.8;">
                        {!! file_get_contents(public_path('images/developer-illustration.svg')) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-7 p-4 p-md-5">
                <span class="badge bg-light text-success fw-semibold mb-2 px-3 py-2" style="color: #059669 !important;">Track & Compete</span>
                <h3 class="fw-bold mb-3" style="color: #1f2937; font-size: 1.6rem;">Seasonal competitions and leaderboards</h3>
                <p class="text-muted mb-3">Participate in seasonal competitions where you can earn scores, climb the leaderboard, and compare your progress with peers. Each season brings fresh opportunities to showcase your skills.</p>
                <div class="d-flex align-items-center gap-4 mt-3">
                    <div class="text-center">
                        <div class="fw-bold fs-4" style="color: #6366f1;">🏆</div>
                        <small class="text-muted">Top Rankings</small>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold fs-4" style="color: #059669;">📊</div>
                        <small class="text-muted">Score Tracking</small>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold fs-4" style="color: #7c3aed;">🎯</div>
                        <small class="text-muted">Skill Mastery</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section with Background Image Feel -->
    <div class="cta-section py-5">
        <div class="container text-center py-4 position-relative">
            <h2 class="fw-bold text-white mb-2">Ready to start your journey?</h2>
            <p class="text-white-50 mb-4" style="color: rgba(199,210,254,0.7) !important;">Join students who are already growing with {{ $platformName ?? 'UniGrowth' }}.</p>
            <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg px-5">
                <i class="bi bi-rocket-takeoff me-2"></i>Get Started Free
            </a>
        </div>
    </div>

<!-- Footer -->
    @include('partials.footer', ['hideQuickLinks' => true])

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

