<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security - UniGrowth</title>
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
        .danger-card {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 12px;
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
                <i class="bi bi-shield-lock me-2" style="color: #059669;"></i>Security Settings
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

        <!-- Change Password -->
        <div class="form-card p-4 p-lg-5 mb-4">
            <h5 class="fw-bold mb-3" style="color: #1f2937;">
                <i class="bi bi-key me-2" style="color: #6366f1;"></i>Change Password
            </h5>
            <form action="{{ route('profile.account.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="change_password">

                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="current_password" class="form-label fw-semibold small text-secondary">Current Password</label>
                        <input type="password" name="current_password" id="current_password" required
                               class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="new_password" class="form-label fw-semibold small text-secondary">New Password</label>
                        <input type="password" name="new_password" id="new_password" required minlength="12"
                               class="form-control">
                        <small class="text-muted">Minimum 12 characters.</small>
                    </div>
                    <div class="col-md-4">
                        <label for="new_password_confirmation" class="form-label fw-semibold small text-secondary">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                               class="form-control">
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-5"
                            style="background: linear-gradient(135deg, #6366f1, #7c3aed); border: none; border-radius: 10px; font-weight: 600;">
                        <i class="bi bi-check2-circle me-1"></i>Change Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Deactivate Account -->
        <div class="danger-card p-4 p-lg-5">
            <h5 class="fw-bold mb-3" style="color: #b91c1c;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>⚠️ Danger Zone
            </h5>
            <p class="text-secondary small mb-4">
                Deactivating your account will suspend your profile and you will not be able to log in.
                Contact an administrator to reactivate your account.
            </p>
            <form action="{{ route('profile.account.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="deactivate">
                <button type="submit" class="btn btn-danger"
                        style="border-radius: 10px; font-weight: 600;">
                    <i class="bi bi-person-x me-1"></i>Deactivate Account
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

