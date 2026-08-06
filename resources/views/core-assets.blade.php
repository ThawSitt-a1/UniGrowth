<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Core Assets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f8fafc;
            color: #0f172a;
            margin: 0;
        }
        .quote-card {
            background: linear-gradient(135deg, #4338ca, #8b5cf6);
            border-radius: 24px;
            padding: 2rem;
            min-height: 260px;
            color: #ffffff;
            box-shadow: 0 24px 70px rgba(67, 56, 202, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .quote-card p {
            margin: 0;
            font-size: 1.2rem;
            line-height: 1.8;
            letter-spacing: -0.02em;
        }
        .quote-author {
            margin-top: 1.5rem;
            font-size: 0.95rem;
            font-weight: 700;
            opacity: 0.88;
        }
        .section-title {
            font-size: 1.125rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }
        .asset-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.06);
        }
        .asset-card h2 {
            margin-bottom: 1rem;
            font-size: 1rem;
            color: #111827;
        }
        .asset-item {
            padding: 1rem 1rem;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            margin-bottom: 1rem;
        }
        .asset-item:last-child { margin-bottom: 0; }
        .asset-item strong { display: block; margin-bottom: 0.35rem; color: #111827; }
        .asset-item span { color: #6b7280; font-size: 0.94rem; }
        .empty-state {
            color: #6b7280;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="mb-5">
            <h1 class="fw-bold">Core Assets</h1>
            <p class="text-muted">Three inspirational quotes displayed side by side at the top of this page.</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-12 col-md-4">
                <div class="quote-card">
                    <p>“Style is a way to say who you are without having to speak.”</p>
                    <div class="quote-author">Rachel Zoe</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="quote-card" style="background: linear-gradient(135deg, #0f172a, #4338ca);">
                    <p>“Design is not just what it looks like and feels like. Design is how it works.”</p>
                    <div class="quote-author">Steve Jobs</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="quote-card" style="background: linear-gradient(135deg, #047857, #065f46);">
                    <p>“Good design is obvious. Great design is transparent.”</p>
                    <div class="quote-author">Joe Sparano</div>
                </div>
            </div>
        </div>

        <div class="row gy-4">
            <div class="col-12 col-lg-6">
                <div class="asset-card">
                    <h2 class="section-title">My Goals</h2>
                    @forelse ($profile['goals'] ?? [] as $goal)
                        <div class="asset-item">
                            <strong>{{ $goal['text'] }}</strong>
                            <span>Status: {{ ucfirst($goal['status']) }}</span>
                        </div>
                    @empty
                        <p class="empty-state">No goals found yet. Add a goal to get started.</p>
                    @endforelse
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="asset-card">
                    <h2 class="section-title">Enrolled Skills</h2>
                    @forelse ($profile['enrolled_skills'] ?? [] as $enrollment)
                        <div class="asset-item">
                            <strong>{{ $enrollment['skill_title'] ?? 'Skill #' . $enrollment['skill_id'] }}</strong>
                            <span>Status: {{ ucfirst($enrollment['status'] ?? 'active') }}</span>
                        </div>
                    @empty
                        <p class="empty-state">You are not enrolled in any skills yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</body>
</html>
