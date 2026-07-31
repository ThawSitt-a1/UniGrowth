<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report a Bug - UniGrowth</title>
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
    </style>
</head>
<body>
    <div class="container py-5" style="max-width: 800px;">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold" style="color: #1f2937;">
                <i class="bi bi-bug me-2" style="color: #dc2626;"></i>Report a Bug
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
            <form action="{{ route('profile.bug-report.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold small text-secondary">Bug Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required maxlength="200"
                           class="form-control" placeholder="Brief description of the issue">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold small text-secondary">Description <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="5" required maxlength="5000"
                              class="form-control" placeholder="Detailed description of what happened...">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="steps_to_reproduce" class="form-label fw-semibold small text-secondary">Steps to Reproduce</label>
                    <textarea name="steps_to_reproduce" id="steps_to_reproduce" rows="4" maxlength="5000"
                              class="form-control" placeholder="1. Go to...&#10;2. Click on...&#10;3. See error...">{{ old('steps_to_reproduce') }}</textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="severity" class="form-label fw-semibold small text-secondary">Severity <span class="text-danger">*</span></label>
                        <select name="severity" id="severity" required class="form-select">
                            <option value="low" {{ old('severity') === 'low' ? 'selected' : '' }}>Low - Minor inconvenience</option>
                            <option value="medium" {{ old('severity') === 'medium' ? 'selected' : '' }}>Medium - Affects functionality</option>
                            <option value="high" {{ old('severity') === 'high' ? 'selected' : '' }}>High - Major feature broken</option>
                            <option value="critical" {{ old('severity') === 'critical' ? 'selected' : '' }}>Critical - System down / data loss</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="screenshot" class="form-label fw-semibold small text-secondary">Screenshot (optional)</label>
                        <input type="file" name="screenshot" id="screenshot" accept="image/png,image/jpeg,image/gif"
                               class="form-control">
                        <small class="text-muted">Max 2MB. Accepted formats: PNG, JPG, GIF.</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-danger px-5"
                            style="border-radius: 10px; font-weight: 600;">
                        <i class="bi bi-send me-1"></i>Submit Bug Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

