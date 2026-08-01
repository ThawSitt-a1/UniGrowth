<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniGrowth — Set New Password</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f9fafb;
        }
        .bg-grid {
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .glow-1 {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            pointer-events: none;
        }
        .glow-2 {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,0.12) 0%, transparent 70%);
            bottom: -50px;
            left: -80px;
            pointer-events: none;
        }
        .glow-3 {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(34,211,238,0.08) 0%, transparent 70%);
            top: 50%;
            left: 30%;
            pointer-events: none;
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
        .input-field {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.9375rem;
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
        .input-field:readonly {
            background: #f1f3f5;
            color: #6b7280;
            cursor: not-allowed;
        }
        .input-error { border-color: #ef4444; }
        .input-error:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
        .btn-gradient {
            width: 100%;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-size: 0.9375rem;
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
        .btn-gradient:active { transform: translateY(0); }
        .form-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.06), 0 1px 8px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.04);
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
        .tech-badge i {
            font-size: 0.85rem;
        }
        .back-link {
            color: #6366f1;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: #4f46e5;
            text-decoration: underline;
        }
        /* Responsive styles for mobile */
        @media (max-width: 991.98px) {
            .banner-section {
                min-height: auto !important;
                padding: 3rem 1.5rem !important;
            }
            .banner-section h1 {
                font-size: calc(1.8rem + 0.5vw) !important;
            }
            .banner-section p {
                font-size: 1rem !important;
            }
            .banner-section .px-5 {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }
@media (max-width: 575.98px) {
            .form-card {
                padding: 1.25rem !important;
            }
        }
        @media (max-width: 400px) {
            body { overflow-x: hidden; }
            .banner-section { padding: 2rem 1rem !important; }
            .banner-section h1 { font-size: 1.8rem !important; }
            .banner-section p { font-size: 0.9rem !important; }
            .input-field { font-size: 0.85rem !important; padding: 8px 10px !important; }
            .btn-gradient { font-size: 0.85rem !important; padding: 10px 16px !important; }
            .form-card { padding: 1rem !important; }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0 min-vh-100">

            <!-- LEFT: Branding Banner -->
            <div class="banner-section col-lg-6 d-flex align-items-center justify-content-center position-relative overflow-hidden" style="background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87); min-height: 600px;">
                <!-- Decorative glows -->
                <div class="glow-1"></div>
                <div class="glow-2"></div>
                <div class="glow-3"></div>
                <div class="bg-grid position-absolute top-0 start-0 w-100 h-100"></div>

                <!-- Content -->
                <div class="position-relative px-5 py-5" style="z-index: 10; max-width: 28rem; width: 100%;">
                    <!-- Platform badge -->
                    <div class="mb-4">
                        <span class="badge-eco">
                            <i class="bi bi-mortarboard-fill" style="font-size: 0.8rem;"></i>
                            Student Development Platform
                        </span>
                    </div>

                    <!-- Main heading -->
                    <h1 class="display-4 fw-bold text-white mb-3" style="line-height: 1.2;">
                       Set New Password
                    </h1>
                    <p class="text-white-50 fs-5 mb-4" style="color: rgba(199,210,254,0.8) !important;">
                        Choose a strong, unique password to secure your account.
                    </p>

                    <!-- Tech stack badges using Bootstrap Icons -->
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="tech-badge"><i class="bi bi-bootstrap-fill"></i> Bootstrap 5</span>
                        <span class="tech-badge"><i class="bi bi-filetype-php"></i> PHP / Laravel</span>
                        <span class="tech-badge"><i class="bi bi-code-slash"></i> Blade Engine</span>
                    </div>

                    <!-- Footer -->
                    <p class="small" style="color: rgba(165,180,252,0.4);">&copy; {{ date('Y') }} UniGrowth. All rights reserved.</p>
                </div>
            </div>

            <!-- RIGHT: Reset Password Form -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center p-3 p-sm-4 p-lg-5" style="background: #f9fafb;">
                <div class="w-100" style="max-width: 32rem;">
                    <!-- Form Card -->
                    <div class="form-card p-4 p-lg-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #6366f1, #7c3aed);">
                                <i class="bi bi-key text-white fs-4"></i>
                            </div>
                            <h2 class="fw-bold mb-1" style="color: #1f2937; font-size: 1.5rem;">Reset Your Password</h2>
                            <p class="text-muted small mt-2">Enter your new password below</p>
                        </div>

                        <!-- Flash Messages -->
                        @if (session('error'))
                            <div class="alert alert-danger d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
                                <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
                                <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger py-3 px-4 mb-4 rounded-3 small" role="alert">
                                <div class="d-flex align-items-start gap-2">
                                    <i class="bi bi-exclamation-circle-fill flex-shrink-0 mt-1"></i>
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <!-- Reset Password Form -->
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf

                            <!-- Hidden Token -->
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="d-flex flex-column gap-3">
                                <!-- Email (read-only) -->
                                <div>
                                    <label for="email" class="form-label fw-semibold small" style="color: #374151;">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="bi bi-envelope text-muted"></i>
                                        </span>
                                        <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}"
                                            required readonly
                                            class="form-control input-field @error('email') input-error @enderror" style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    @error('email')
                                        <p class="text-danger small mt-1 mb-0">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div>
                                    <label for="password" class="form-label fw-semibold small" style="color: #374151;">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="bi bi-lock text-muted"></i>
                                        </span>
                                        <input type="password" name="password" id="password"
                                            placeholder="Min. 8 characters, 1 letter, 1 number"
                                            required
                                            class="form-control input-field @error('password') input-error @enderror" style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    @error('password')
                                        <p class="text-danger small mt-1 mb-0">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirm New Password -->
                                <div>
                                    <label for="password_confirmation" class="form-label fw-semibold small" style="color: #374151;">Confirm New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="bi bi-lock-fill text-muted"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            placeholder="Re-enter your new password"
                                            required
                                            class="form-control input-field" style="border-radius: 0 10px 10px 0;">
                                    </div>
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="btn-gradient">
                                    <span class="d-inline-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-check-lg"></i>
                                        Reset Password
                                    </span>
                                </button>
                            </div>
                        </form>

                        <!-- Back to Login Navigation -->
                        <div class="mt-4 pt-4 border-top text-center">
                            <p class="small text-secondary mb-0">
                                <a href="/login" class="back-link">
                                    <i class="bi bi-arrow-left me-1"></i>Back to sign in
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('partials.theme-toggle', [
        'btnClasses' => 'btn d-inline-flex align-items-center justify-content-center border-0 shadow-lg',
        'style' => 'position: fixed; bottom: 1.25rem; right: 1.25rem; width: 44px; height: 44px; border-radius: 50% !important; z-index: 1050; background: #fff; color: #374151;',
    ])
</body>
</html>

