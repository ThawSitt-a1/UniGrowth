<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $platformName ?? 'UniGrowth' }} — Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: #f8fafc; color: #1f2937;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <span class="badge bg-warning text-dark">Maintenance Mode</span>
                        </div>
                        <h1 class="display-5 fw-bold mb-3">{{ $platformName ?? 'UniGrowth' }} is temporarily unavailable</h1>
                        <p class="lead text-muted mb-4">{{ $message ?? 'We are performing scheduled maintenance to improve your experience. Please check back soon.' }}</p>
                        <a href="/" class="btn btn-primary btn-lg">Return to Homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
