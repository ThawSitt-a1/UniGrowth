<footer class="py-5" style="background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87); color: rgba(255,255,255,0.85);">
    <div class="container">
        <div class="row g-4">
            <!-- Brand & Description -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-mortarboard-fill fs-4" style="color: #a5b4fc;"></i>
                    <span class="fw-bold fs-5 text-white">UniGrowth</span>
                </div>
                <p class="small mb-3" style="color: rgba(199,210,254,0.7); line-height: 1.7;">
                    UniGrowth is the all-in-one platform for university students to set goals, develop new skills, and track personal growth throughout their academic journey.
                </p>
                <div class="d-flex gap-2">
                    <a href="https://t.me/unigrowth" target="_blank" rel="noopener noreferrer" class="btn btn-sm" style="background: rgba(255,255,255,0.1); color: #fff; border-radius: 10px; padding: 8px 14px; transition: all 0.2s;" title="Telegram">
                        <i class="bi bi-telegram fs-5"></i>
                    </a>
                    <a href="https://facebook.com/unigrowth" target="_blank" rel="noopener noreferrer" class="btn btn-sm" style="background: rgba(255,255,255,0.1); color: #fff; border-radius: 10px; padding: 8px 14px; transition: all 0.2s;" title="Facebook">
                        <i class="bi bi-facebook fs-5"></i>
                    </a>
                    <a href="https://instagram.com/unigrowth" target="_blank" rel="noopener noreferrer" class="btn btn-sm" style="background: rgba(255,255,255,0.1); color: #fff; border-radius: 10px; padding: 8px 14px; transition: all 0.2s;" title="Instagram">
                        <i class="bi bi-instagram fs-5"></i>
                    </a>
                    <a href="https://tiktok.com/@unigrowth" target="_blank" rel="noopener noreferrer" class="btn btn-sm" style="background: rgba(255,255,255,0.1); color: #fff; border-radius: 10px; padding: 8px 14px; transition: all 0.2s;" title="TikTok">
                        <i class="bi bi-tiktok fs-5"></i>
                    </a>
                </div>
            </div>

@if (!($hideQuickLinks ?? false))
            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-white mb-3" style="font-size: 0.85rem; letter-spacing: 0.05em; text-transform: uppercase;">Quick Links</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none small" style="color: rgba(199,210,254,0.7); transition: color 0.2s;">
                            <i class="bi bi-chevron-right me-1" style="font-size: 0.65rem;"></i>Dashboard
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('core-assets.skills') }}" class="text-decoration-none small" style="color: rgba(199,210,254,0.7); transition: color 0.2s;">
                            <i class="bi bi-chevron-right me-1" style="font-size: 0.65rem;"></i>Skills
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('assessment.test.index') }}" class="text-decoration-none small" style="color: rgba(199,210,254,0.7); transition: color 0.2s;">
                            <i class="bi bi-chevron-right me-1" style="font-size: 0.65rem;"></i>Quiz
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('core-assets.index') }}#goals" class="text-decoration-none small" style="color: rgba(199,210,254,0.7); transition: color 0.2s;">
                            <i class="bi bi-chevron-right me-1" style="font-size: 0.65rem;"></i>Goals
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('core-assets.index') }}#pane-habits" class="text-decoration-none small" style="color: rgba(199,210,254,0.7); transition: color 0.2s;">
                            <i class="bi bi-chevron-right me-1" style="font-size: 0.65rem;"></i>Habits
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('about-team') }}" class="text-decoration-none small" style="color: rgba(199,210,254,0.7); transition: color 0.2s;">
                            <i class="bi bi-chevron-right me-1" style="font-size: 0.65rem;"></i>Meet Our Team
                        </a>
                    </li>
                </ul>
            </div>
            @endif

            <!-- Contact -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-white mb-3" style="font-size: 0.85rem; letter-spacing: 0.05em; text-transform: uppercase;">Contact Us</h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-fill" style="color: #a5b4fc; font-size: 0.85rem;"></i>
                        <a href="mailto:support@unigrowth.com" class="text-decoration-none small" style="color: rgba(199,210,254,0.7);">
                            support@unigrowth.com
                        </a>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-telegram" style="color: #a5b4fc; font-size: 0.85rem;"></i>
                        <a href="https://t.me/unigrowth" target="_blank" rel="noopener noreferrer" class="text-decoration-none small" style="color: rgba(199,210,254,0.7);">
                            @unigrowth
                        </a>
                    </li>
                    <li class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-globe" style="color: #a5b4fc; font-size: 0.85rem;"></i>
                        <a href="{{ route('dashboard') }}" class="text-decoration-none small" style="color: rgba(199,210,254,0.7);">
                            www.unigrowth.com
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Acknowledgments -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-white mb-3" style="font-size: 0.85rem; letter-spacing: 0.05em; text-transform: uppercase;">Acknowledgments</h6>
                <p class="small mb-2" style="color: rgba(199,210,254,0.7); line-height: 1.6;">
                    <i class="bi bi-heart-fill me-1" style="color: #f472b6;"></i>
                    Special thanks to all the authors, speakers, and content creators whose work has inspired and shaped the UniGrowth platform.
                </p>
                <p class="small mb-0" style="color: rgba(199,210,254,0.5);">
                    <i class="bi bi-code-slash me-1"></i>
                    Built with Laravel, Bootstrap 5, and lots of <i class="bi bi-cup-hot-fill" style="color: #fbbf24;"></i>
                </p>
            </div>
        </div>

        <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="small mb-0" style="color: rgba(199,210,254,0.5);">
                    &copy; {{ date('Y') }} UniGrowth. All rights reserved.
                    <span class="mx-2">|</span>
                    <a href="{{ route('terms-of-service') }}" class="text-decoration-none" style="color: rgba(199,210,254,0.5);">Terms of Service</a>
                    <span class="mx-2">|</span>
                    <a href="{{ route('privacy-policy') }}" class="text-decoration-none" style="color: rgba(199,210,254,0.5);">Privacy Policy</a>
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="small mb-0" style="color: rgba(199,210,254,0.4);">
                    <i class="bi bi-mortarboard-fill me-1"></i>
                    Empowering students to grow, one skill at a time.
                </p>
            </div>
        </div>
    </div>
<style>
        @media (max-width: 400px) {
            footer .container { padding-left: 0.75rem; padding-right: 0.75rem; }
            footer .row.g-4 > [class*="col-"] { margin-bottom: 1rem; }
            footer h6 { font-size: 0.8rem !important; }
            footer .small { font-size: 0.75rem !important; }
            footer .d-flex.gap-2 { gap: 0.35rem !important; }
            footer .btn-sm { padding: 6px 10px !important; }
        }
    </style>
</footer>
