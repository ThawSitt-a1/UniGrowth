<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet Our Team — UniGrowth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: #f8fafc;
            color: #1f2937;
        }
        .team-header {
            background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);
            padding: 3rem 0;
            position: relative;
            overflow: hidden;
        }
        .team-header::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
        }
        .team-header::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,0.12) 0%, transparent 70%);
            bottom: -80px;
            left: -80px;
        }
        .member-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 4px 24px rgba(0,0,0,0.04);
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
        }
        .member-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(99,102,241,0.12);
            border-color: rgba(99,102,241,0.15);
        }
        .member-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1.25rem;
            border: 4px solid #eef2ff;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 2.5rem;
            font-weight: 700;
        }
        .member-role {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #eef2ff;
            color: #4f46e5;
            margin-bottom: 0.75rem;
        }
        .member-social {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 1rem;
        }
        .member-social a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5f9;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s;
        }
        .member-social a:hover {
            background: #6366f1;
            color: #fff;
        }
        .thanks-section {
            background: #fff;
            border-radius: 20px;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 4px 24px rgba(0,0,0,0.04);
            padding: 2.5rem;
        }
        .thanks-section i {
            color: #f472b6;
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
        }
@media (max-width: 767.98px) {
            .member-avatar {
                width: 90px;
                height: 90px;
                font-size: 2rem;
            }
        }
        @media (max-width: 400px) {
            body { overflow-x: hidden; }
            .team-header { padding: 2rem 0 !important; }
            .team-header h1 { font-size: 1.5rem !important; }
            .team-header .fs-5 { font-size: 0.95rem !important; }
            .member-card { padding: 1.25rem !important; }
            .member-card h5 { font-size: 1rem !important; }
            .member-card .small { font-size: 0.75rem !important; }
            .member-avatar { width: 70px; height: 70px; font-size: 1.5rem; }
            .thanks-section { padding: 1.5rem !important; }
            .thanks-section h3 { font-size: 1.1rem !important; }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top" style="background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="{{ route('dashboard') }}">
                <i class="bi bi-mortarboard-fill me-2"></i>UniGrowth
            </a>
            <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#teamNav" style="color: rgba(255,255,255,0.7);">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="teamNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link nav-link-custom">
                            <i class="bi bi-house-door"></i>Home
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        @include('partials.theme-toggle', [
                            'btnClasses' => 'btn btn-sm text-white border-0',
                            'style' => 'background: rgba(255,255,255,0.1); border-radius: 8px;',
                        ])
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="team-header">
        <div class="container position-relative" style="z-index: 2;">
            <div class="text-center text-white">
                <span class="badge mb-3" style="background: rgba(255,255,255,0.15); color: #a5b4fc; padding: 6px 18px; border-radius: 20px; font-size: 0.8rem;">
                    <i class="bi bi-people-fill me-1"></i>Our Team
                </span>
                <h1 class="display-4 fw-bold mb-2">Meet the UniGrowth Team</h1>
                <p class="fs-5 mb-0" style="color: rgba(199,210,254,0.8); max-width: 600px; margin: 0 auto;">
                    The passionate people behind the platform, dedicated to empowering student growth.
                </p>
            </div>
        </div>
    </div>

    <!-- Team Members -->
    <div class="container py-5">
        <div class="row g-4">
            <!-- Member 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="member-card">
                    <div class="member-avatar">JD</div>
                    <span class="member-role">Founder & Lead Developer</span>
                    <h5 class="fw-bold mb-1">Jane Doe</h5>
                    <p class="small text-muted mb-2">Full-Stack Engineer</p>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        Jane is the visionary behind UniGrowth. With over 8 years of experience in educational technology, she architects the platform's core systems and leads the development team.
                    </p>
                    <div class="member-social">
                        <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" title="GitHub"><i class="bi bi-github"></i></a>
                        <a href="#" title="Email"><i class="bi bi-envelope-fill"></i></a>
                    </div>
                </div>
            </div>

            <!-- Member 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="member-card">
                    <div class="member-avatar">JS</div>
                    <span class="member-role">UI/UX Designer</span>
                    <h5 class="fw-bold mb-1">John Smith</h5>
                    <p class="small text-muted mb-2">Product Designer</p>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        John crafts the user experience and visual design of UniGrowth. He specializes in creating intuitive, accessible interfaces that make learning feel natural and engaging.
                    </p>
                    <div class="member-social">
                        <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" title="Dribbble"><i class="bi bi-dribbble"></i></a>
                        <a href="#" title="Portfolio"><i class="bi bi-globe"></i></a>
                    </div>
                </div>
            </div>

            <!-- Member 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="member-card">
                    <div class="member-avatar">MC</div>
                    <span class="member-role">Backend Developer</span>
                    <h5 class="fw-bold mb-1">Maria Chen</h5>
                    <p class="small text-muted mb-2">Laravel Specialist</p>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        Maria is the backbone of our backend infrastructure. She designs and implements the database architecture, API endpoints, and business logic that power the platform.
                    </p>
                    <div class="member-social">
                        <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" title="GitHub"><i class="bi bi-github"></i></a>
                        <a href="#" title="Email"><i class="bi bi-envelope-fill"></i></a>
                    </div>
                </div>
            </div>

            <!-- Member 4 -->
            <div class="col-lg-4 col-md-6">
                <div class="member-card">
                    <div class="member-avatar">AK</div>
                    <span class="member-role">Frontend Developer</span>
                    <h5 class="fw-bold mb-1">Alex Kim</h5>
                    <p class="small text-muted mb-2">JavaScript & Bootstrap Expert</p>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        Alex brings the UI to life with clean, responsive frontend code. He ensures every page looks great and performs flawlessly across all devices and browsers.
                    </p>
                    <div class="member-social">
                        <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" title="GitHub"><i class="bi bi-github"></i></a>
                        <a href="#" title="Twitter"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
            </div>

            <!-- Member 5 -->
            <div class="col-lg-4 col-md-6">
                <div class="member-card">
                    <div class="member-avatar">SP</div>
                    <span class="member-role">Content & Community Manager</span>
                    <h5 class="fw-bold mb-1">Sarah Patel</h5>
                    <p class="small text-muted mb-2">Educational Content Strategist</p>
                    <p class="small text-muted mb-0" style="line-height: 1.6;">
                        Sarah curates and creates educational content, manages the community, and ensures that UniGrowth's resources align with the needs of students and educators alike.
                    </p>
                    <div class="member-social">
                        <a href="#" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" title="Email"><i class="bi bi-envelope-fill"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thanks & Acknowledgments -->
        <div class="thanks-section mt-5 text-center">
            <div class="mb-3">
                <i class="bi bi-heart-fill" style="font-size: 2.5rem; color: #f472b6;"></i>
            </div>
            <h3 class="fw-bold mb-3" style="color: #1f2937;">Special Thanks & Acknowledgments</h3>
            <p class="text-muted mb-3" style="max-width: 700px; margin: 0 auto; line-height: 1.7;">
                We extend our deepest gratitude to the authors, speakers, and content creators whose work has inspired and shaped the UniGrowth platform. Your dedication to education and personal development has been the foundation upon which we build.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
                <span class="badge" style="background: #eef2ff; color: #4338ca; padding: 8px 18px; font-size: 0.8rem; border-radius: 20px;">
                    <i class="bi bi-megaphone-fill me-1"></i>Guest Speakers
                </span>
                <span class="badge" style="background: #faf5ff; color: #7c3aed; padding: 8px 18px; font-size: 0.8rem; border-radius: 20px;">
                    <i class="bi bi-pencil-fill me-1"></i>Content Authors
                </span>
                <span class="badge" style="background: #ecfdf5; color: #065f46; padding: 8px 18px; font-size: 0.8rem; border-radius: 20px;">
                    <i class="bi bi-people-fill me-1"></i>Community Contributors
                </span>
                <span class="badge" style="background: #fef3c7; color: #92400e; padding: 8px 18px; font-size: 0.8rem; border-radius: 20px;">
                    <i class="bi bi-star-fill me-1"></i>Beta Testers
                </span>
            </div>
            <p class="small text-muted mt-4 mb-0">
                <i class="bi bi-quote me-1"></i>
                "Education is the most powerful weapon which you can use to change the world." — Nelson Mandela
            </p>
        </div>

        <!-- Copyright Notice -->
        <div class="text-center mt-5 pt-4 border-top">
            <p class="small text-muted mb-0">
                &copy; {{ date('Y') }} UniGrowth. All rights reserved.
                <span class="mx-2">|</span>
                Built with <i class="bi bi-heart-fill" style="color: #f472b6;"></i> for students everywhere.
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
