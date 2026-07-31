<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social & Privacy - UniGrowth</title>
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
        .visibility-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .visibility-option:hover {
            border-color: #6366f1;
            background: rgba(99,102,241,0.03);
        }
        .social-input-group {
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }
        .btn-remove-link {
            color: #dc2626;
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .btn-remove-link:hover {
            background: #fef2f2;
            color: #b91c1c;
        }
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 800px;">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold" style="color: #1f2937;">
                <i class="bi bi-link-45deg me-2" style="color: #6366f1;"></i>Social Links & Privacy
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
        @if ($errors->any())
            <div class="alert alert-danger py-3 px-4 mb-4 rounded-3 small" role="alert">
                <ul class="list-unstyled mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-exclamation-triangle me-1"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card p-4 p-lg-5">
            <form action="{{ route('profile.privacy-social.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Visibility -->
                <div class="bg-light rounded-3 p-4 mb-4 border" style="border-color: #e2e8f0 !important;">
                    <h6 class="fw-bold mb-3" style="color: #334155;">
                        <i class="bi bi-eye me-2" style="color: #6366f1;"></i>Profile Visibility
                    </h6>
                    <label class="form-label fw-semibold small text-secondary mb-2">Who can see your profile?</label>
                    <div class="d-flex gap-3 flex-wrap mb-2">
                        <label class="visibility-option">
                            <input type="radio" name="visibility" value="public"
                                   {{ ($profile['preferences']['privacy_show_profile'] ?? true) ? 'checked' : '' }}>
                            <span>🌍 Public</span>
                        </label>
                        <label class="visibility-option">
                            <input type="radio" name="visibility" value="private"
                                   {{ !($profile['preferences']['privacy_show_profile'] ?? true) ? 'checked' : '' }}>
                            <span>🔒 Private</span>
                        </label>
                    </div>
                    <small class="text-muted">When set to Private, other users cannot view your profile details.</small>
                </div>

                <!-- Social Links -->
                <div class="bg-light rounded-3 p-4 mb-4 border" style="border-color: #e2e8f0 !important;">
                    <h6 class="fw-bold mb-3" style="color: #334155;">
                        <i class="bi bi-share me-2" style="color: #7c3aed;"></i>Social Links
                    </h6>

                    <div id="social-links-container" class="d-flex flex-column gap-3 mb-3">
                        @if (!empty($profile['social_links']))
                            @foreach ($profile['social_links'] as $index => $link)
                                <div class="social-input-group">
                                    <select name="social_links[{{ $index }}][platform]" class="form-select" style="max-width: 160px;">
                                        <option value="github" {{ $link['platform'] === 'github' ? 'selected' : '' }}>GitHub</option>
                                        <option value="linkedin" {{ $link['platform'] === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                                        <option value="portfolio" {{ $link['platform'] === 'portfolio' ? 'selected' : '' }}>Portfolio</option>
                                        <option value="twitter" {{ $link['platform'] === 'twitter' ? 'selected' : '' }}>Twitter</option>
                                        <option value="dribbble" {{ $link['platform'] === 'dribbble' ? 'selected' : '' }}>Dribbble</option>
                                        <option value="other" {{ $link['platform'] === 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <input type="url" name="social_links[{{ $index }}][url]" value="{{ $link['url'] }}"
                                           placeholder="https://..." class="form-control flex-grow-1">
                                    <button type="button" class="btn-remove-link remove-link">✕</button>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted small mb-0" id="no-links-msg">No social links added yet.</p>
                        @endif
                    </div>
                    <button type="button" id="add-link-btn" class="btn btn-sm btn-outline-primary"
                            style="border-color: #6366f1; color: #6366f1; border-radius: 8px;">
                        <i class="bi bi-plus-circle me-1"></i>Add Social Link
                    </button>
                </div>

                <div class="d-flex justify-content-end border-top pt-4">
                    <button type="submit" class="btn btn-primary px-5"
                            style="background: linear-gradient(135deg, #6366f1, #7c3aed); border: none; border-radius: 10px; font-weight: 600;">
                        <i class="bi bi-check2-circle me-1"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let linkIndex = {{ count($profile['social_links'] ?? []) }};
        document.getElementById('add-link-btn')?.addEventListener('click', function() {
            const container = document.getElementById('social-links-container');
            const noMsg = document.getElementById('no-links-msg');
            if (noMsg) noMsg.remove();

            const row = document.createElement('div');
            row.className = 'social-input-group';
            row.innerHTML = `
                <select name="social_links[${linkIndex}][platform]" class="form-select" style="max-width: 160px;">
                    <option value="github">GitHub</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="portfolio">Portfolio</option>
                    <option value="twitter">Twitter</option>
                    <option value="dribbble">Dribbble</option>
                    <option value="other">Other</option>
                </select>
                <input type="url" name="social_links[${linkIndex}][url]" placeholder="https://..." class="form-control flex-grow-1">
                <button type="button" class="btn-remove-link remove-link">✕</button>
            `;
            container.appendChild(row);
            linkIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-link')) {
                e.target.closest('.social-input-group').remove();
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

