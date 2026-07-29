<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniGrowth — Student Development Platform</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google reCAPTCHA Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
        .gradient-text {
            background: linear-gradient(90deg, #a5b4fc, #c4b5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
                    <h1 class="display-4 fw-bold text-white mb-3" style="line-height: 1.2; white-space: nowrap;">
                       UniGrowth
                    </h1>
                    <p class="text-white-50 fs-5 mb-4" style="color: rgba(199,210,254,0.8) !important;">
                        Set goals, develop skills, and track your personal growth throughout your university journey.
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

            <!-- RIGHT: Registration Form -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center p-3 p-sm-4 p-lg-5" style="background: #f9fafb;">
                <div class="w-100" style="max-width: 32rem;">
                    <!-- Form Card -->
                    <div class="form-card p-4 p-lg-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h2 class="fw-bold mb-1" style="color: #1f2937; font-size: 1.5rem;">Create Account</h2>
                            <p class="text-muted small mt-2">Fill in your details to get started</p>
                        </div>

                        <!-- Status Messages -->
                        @if (session('status'))
                            <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
                                <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                                <span>{{ session('status') }}</span>
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

                        <!-- Registration Form -->
                        <form action="{{ route('register') }}" method="POST">
                            @csrf

                            <div class="d-flex flex-column gap-3">
                                <!-- Username -->
                                <div>
                                    <label for="username" class="form-label fw-semibold small" style="color: #374151;">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="bi bi-person text-muted"></i>
                                        </span>
                                        <input type="text" name="username" id="username" value="{{ old('username') }}"
                                            placeholder="johndoe"
                                            required autofocus
                                            class="form-control input-field @error('username') input-error @enderror" style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    @error('username')
                                        <p class="text-danger small mt-1 mb-0">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="form-label fw-semibold small" style="color: #374151;">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="bi bi-envelope text-muted"></i>
                                        </span>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                                            placeholder="you@university.edu"
                                            required
                                            class="form-control input-field @error('email') input-error @enderror" style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    @error('email')
                                        <p class="text-danger small mt-1 mb-0">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div>
                                    <label for="password" class="form-label fw-semibold small" style="color: #374151;">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="bi bi-lock text-muted"></i>
                                        </span>
                                        <input type="password" name="password" id="password"
                                            placeholder="Min. 8 characters, 1 letter, 1 number, 1 special"
                                            required
                                            class="form-control input-field @error('password') input-error @enderror" style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    @error('password')
                                        <p class="text-danger small mt-1 mb-0">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Row: Academic Year + Major -->
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <label for="academic_year" class="form-label fw-semibold small" style="color: #374151;">Academic Year</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                                <i class="bi bi-calendar3 text-muted"></i>
                                            </span>
                                            <select name="academic_year" id="academic_year" required
                                                class="form-select input-field @error('academic_year') input-error @enderror" style="border-radius: 0 10px 10px 0;">
                                                <option value="" disabled selected>Select year</option>
                                                <option value="1st Year" {{ old('academic_year') == '1st Year' ? 'selected' : '' }}>1st Year</option>
                                                <option value="2nd Year" {{ old('academic_year') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                                <option value="3rd Year" {{ old('academic_year') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                                <option value="4th Year" {{ old('academic_year') == '4th Year' ? 'selected' : '' }}>4th Year</option>
                                                <option value="5th Year" {{ old('academic_year') == '5th Year' ? 'selected' : '' }}>5th Year</option>
                                                <option value="Graduate" {{ old('academic_year') == 'Graduate' ? 'selected' : '' }}>Graduate</option>
                                            </select>
                                        </div>
                                        @error('academic_year')
                                            <p class="text-danger small mt-1 mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="major" class="form-label fw-semibold small" style="color: #374151;">Major / Field</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                                <i class="bi bi-book text-muted"></i>
                                            </span>
                                            <input type="text" name="major" id="major" value="{{ old('major') }}"
                                                placeholder="e.g. Computer Science"
                                                required
                                                class="form-control input-field @error('major') input-error @enderror" style="border-radius: 0 10px 10px 0;">
                                        </div>
                                        @error('major')
                                            <p class="text-danger small mt-1 mb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- University Name -->
                                <div>
                                    <label for="university_name" class="form-label fw-semibold small" style="color: #374151;">University / Institution</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="bi bi-building text-muted"></i>
                                        </span>
                                        <input type="text" name="university_name" id="university_name" value="{{ old('university_name') }}"
                                            placeholder="e.g. University of Technology"
                                            required
                                            class="form-control input-field @error('university_name') input-error @enderror" style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    @error('university_name')
                                        <p class="text-danger small mt-1 mb-0">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- reCAPTCHA -->
                                <div class="d-flex justify-content-center py-2 flex-column align-items-center">
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                                    @error('g-recaptcha-response')
                                        <p class="text-danger small text-center mt-1 mb-0">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Remember Me -->
                                <div class="form-check">
                                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                    <label class="form-check-label small text-secondary" for="remember">Remember me</label>
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="btn-gradient">
                                    <span class="d-inline-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-person-plus"></i>
                                        Register
                                    </span>
                                </button>
                            </div>
                        </form>

                        <!-- Login Navigation -->
                        <div class="mt-4 pt-4 border-top text-center">
                            <p class="small text-secondary mb-0">
                                Already have an account?
                                <a href="/login" class="fw-semibold text-decoration-none" style="color: #6366f1;">
                                    Sign in
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
