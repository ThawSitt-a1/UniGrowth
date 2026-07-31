<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - UniGrowth</title>
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
        .avatar-preview {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e0e7ff;
        }
        .avatar-placeholder {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.8rem;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: #fff;
            border: 3px solid #e0e7ff;
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
                <i class="bi bi-pencil-square me-2" style="color: #6366f1;"></i>Edit Profile
            </h1>
            <a href="{{ route('profile.show') }}" class="back-link">
                <i class="bi bi-arrow-left me-1"></i>Back to Profile
            </a>
        </div>

        <!-- Flash Messages -->
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

        <!-- Avatar Upload Section -->
        <div class="form-card p-4 mb-4">
            <h5 class="fw-bold mb-3" style="color: #1f2937;">
                <i class="bi bi-camera me-2" style="color: #6366f1;"></i>Profile Picture
            </h5>
            <form action="{{ route('profile.avatar.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex align-items-center gap-4 flex-wrap">
                    @if ($profile['avatar_path'])
                        <img src="{{ $profile['avatar_path'] }}" alt="Avatar" class="avatar-preview">
                    @else
                        <div class="avatar-placeholder">
                            {{ strtoupper(substr($profile['username'] ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-grow-1">
                        <input type="file" name="avatar" accept="image/*"
                               class="form-control form-control-sm">
                        <small class="text-muted">Accepted formats: PNG, JPG, GIF. Max 2MB.</small>
                    </div>
                    <button type="submit" class="btn btn-primary"
                            style="background: linear-gradient(135deg, #6366f1, #7c3aed); border: none; border-radius: 8px; font-weight: 600;">
                        <i class="bi bi-upload me-1"></i>Upload
                    </button>
                </div>
            </form>
        </div>

        <!-- Profile Edit Form -->
        <div class="form-card p-4">
            <h5 class="fw-bold mb-3" style="color: #1f2937;">
                <i class="bi bi-person-gear me-2" style="color: #6366f1;"></i>Biographical Information
            </h5>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small text-secondary">Username</label>
                        <input type="text" value="{{ $profile['username'] }}" disabled
                               class="form-control bg-light text-muted">
                        <small class="text-muted">Username cannot be changed.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small text-secondary">Email</label>
                        <input type="email" value="{{ $profile['email'] }}" disabled
                               class="form-control bg-light text-muted">
                        <small class="text-muted">Email cannot be changed.</small>
                    </div>
                    <div class="col-md-6">
                        <label for="academic_year" class="form-label fw-semibold small text-secondary">Academic Year</label>
                        <select name="academic_year" id="academic_year"
                                class="form-select">
                            <option value="">Select year</option>
                            @foreach (['Freshman', 'Sophomore', 'Junior', 'Senior', 'Graduate', 'Postgraduate'] as $year)
                                <option value="{{ $year }}" {{ ($profile['academic_year'] ?? '') === $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="major" class="form-label fw-semibold small text-secondary">Major / Field of Study</label>
                        <input type="text" name="major" id="major" value="{{ $profile['major'] ?? '' }}"
                               maxlength="100" class="form-control" placeholder="e.g. Computer Science">
                    </div>
                    <div class="col-12">
                        <label for="university_name" class="form-label fw-semibold small text-secondary">University Name</label>
                        <input type="text" name="university_name" id="university_name"
                               value="{{ $profile['university_name'] ?? '' }}" maxlength="150"
                               class="form-control" placeholder="e.g. Stanford University">
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-5"
                            style="background: linear-gradient(135deg, #6366f1, #7c3aed); border: none; border-radius: 10px; font-weight: 600;">
                        <i class="bi bi-check2-circle me-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

