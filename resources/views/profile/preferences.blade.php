<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preferences - UniGrowth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f3f4f6;
        }
        .form-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.06), 0 1px 8px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.04);
        }
        .back-link {
            color: #6366f1;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: #4f46e5;
            text-decoration: underline;
        }
        .pref-section {
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .theme-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .theme-option:hover {
            border-color: #6366f1;
            background: rgba(99,102,241,0.03);
        }
        .theme-option input[type="radio"]:checked + span {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 800px;">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold" style="color: #1f2937;">
                <i class="bi bi-sliders me-2" style="color: #7c3aed;"></i>Preferences
            </h1>
            <a href="{{ route('profile.show') }}" class="back-link">
                <i class="bi bi-arrow-left me-1"></i>Back to Profile
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
                <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="form-card p-4 p-lg-5">
            <form action="{{ route('profile.preferences.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Appearance -->
                <div class="pref-section p-4 mb-4">
                    <h6 class="fw-bold mb-3" style="color: #334155;">
                        <i class="bi bi-palette me-2" style="color: #6366f1;"></i>Appearance
                    </h6>
                    <label class="form-label fw-semibold small text-secondary mb-2">Theme</label>
                    <div class="d-flex gap-3 flex-wrap">
                        <label class="theme-option">
                            <input type="radio" name="theme" value="light"
                                   {{ ($profile['preferences']['theme'] ?? 'light') === 'light' ? 'checked' : '' }}>
                            <span>☀️ Light</span>
                        </label>
                        <label class="theme-option">
                            <input type="radio" name="theme" value="dark"
                                   {{ ($profile['preferences']['theme'] ?? '') === 'dark' ? 'checked' : '' }}>
                            <span>🌙 Dark</span>
                        </label>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="pref-section p-4 mb-4">
                    <h6 class="fw-bold mb-3" style="color: #334155;">
                        <i class="bi bi-bell me-2" style="color: #d97706;"></i>Notifications
                    </h6>
                    <div class="d-flex flex-column gap-3">
                        <label class="d-flex align-items-center gap-3">
                            <input type="checkbox" name="notifications_email" value="1"
                                   {{ ($profile['preferences']['notifications_email'] ?? true) ? 'checked' : '' }}
                                   class="form-check-input" style="width: 20px; height: 20px;">
                            <span class="text-secondary">Email notifications</span>
                        </label>
                        <label class="d-flex align-items-center gap-3">
                            <input type="checkbox" name="notifications_browser" value="1"
                                   {{ ($profile['preferences']['notifications_browser'] ?? true) ? 'checked' : '' }}
                                   class="form-check-input" style="width: 20px; height: 20px;">
                            <span class="text-secondary">Browser notifications</span>
                        </label>
                    </div>
                </div>

                <!-- Privacy Preferences -->
                <div class="pref-section p-4 mb-4">
                    <h6 class="fw-bold mb-3" style="color: #334155;">
                        <i class="bi bi-shield-lock me-2" style="color: #059669;"></i>Privacy Preferences
                    </h6>
                    <div class="d-flex flex-column gap-3">
                        <label class="d-flex align-items-center gap-3">
                            <input type="checkbox" name="privacy_show_profile" value="1"
                                   {{ ($profile['preferences']['privacy_show_profile'] ?? true) ? 'checked' : '' }}
                                   class="form-check-input" style="width: 20px; height: 20px;">
                            <span class="text-secondary">Show my profile to other users</span>
                        </label>
                        <label class="d-flex align-items-center gap-3">
                            <input type="checkbox" name="privacy_show_progress" value="1"
                                   {{ ($profile['preferences']['privacy_show_progress'] ?? true) ? 'checked' : '' }}
                                   class="form-check-input" style="width: 20px; height: 20px;">
                            <span class="text-secondary">Show my progress to other users</span>
                        </label>
                        <label class="d-flex align-items-center gap-3">
                            <input type="checkbox" name="privacy_show_goals" value="1"
                                   {{ ($profile['preferences']['privacy_show_goals'] ?? true) ? 'checked' : '' }}
                                   class="form-check-input" style="width: 20px; height: 20px;">
                            <span class="text-secondary">Show my goals to other users</span>
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-5"
                            style="background: linear-gradient(135deg, #6366f1, #7c3aed); border: none; border-radius: 10px; font-weight: 600;">
                        <i class="bi bi-check2-circle me-1"></i>Save Preferences
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

