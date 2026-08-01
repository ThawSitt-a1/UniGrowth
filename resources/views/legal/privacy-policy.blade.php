<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniGrowth — Privacy Policy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f9fafb;
        }
        .legal-header {
            background: linear-gradient(135deg, #1e1b4b, #3730a3, #581c87);
            padding: 2rem 0;
        }
        .legal-content {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.04);
            padding: 2.5rem;
        }
        .legal-content h2 {
            color: #1f2937;
            font-weight: 700;
            font-size: 1.25rem;
            margin-top: 2rem;
            margin-bottom: 0.75rem;
        }
        .legal-content h2:first-child {
            margin-top: 0;
        }
        .legal-content p {
            color: #4b5563;
            line-height: 1.7;
            margin-bottom: 1rem;
        }
        .legal-content ul {
            color: #4b5563;
            margin-bottom: 1rem;
        }
        .legal-content ul li {
            margin-bottom: 0.5rem;
        }
        @media (max-width: 400px) {
            body { overflow-x: hidden; }
            .legal-header { padding: 1.5rem 0 !important; }
            .legal-header .fs-4 { font-size: 1rem !important; }
            .legal-content { padding: 1.25rem !important; }
            .legal-content h1 { font-size: 1.25rem !important; }
            .legal-content h2 { font-size: 1.05rem !important; }
            .legal-content p, .legal-content li { font-size: 0.875rem !important; }
        }
    </style>
</head>
<body>
    <div class="legal-header">
        <div class="container">
            <a href="/" class="text-white text-decoration-none fs-4 fw-bold">
                <i class="bi bi-mortarboard-fill me-2"></i>UniGrowth
            </a>
        </div>
    </div>

    <div class="container py-5">
        <div class="legal-content">
            <h1 class="fw-bold mb-1" style="color: #1f2937; font-size: 1.75rem;">Privacy Policy</h1>
            <p class="text-muted small mb-4">Last updated: {{ date('F d, Y') }}</p>

            <h2>1. Information We Collect</h2>
            <p><strong>Account Data:</strong> Name, university email address, institution, graduation year, and profile preferences.</p>
            <p><strong>User-Generated Growth Data:</strong> Goals, journal entries, habit logs, self-assessment answers, and reflection notes.</p>
            <p><strong>Technical Data:</strong> IP address, device type, browser type, and app usage telemetry (for bug fixes and performance improvements).</p>

            <h2>2. How We Use Your Information</h2>
            <ul>
                <li>To personalize your growth recommendations and track your progress.</li>
                <li>To communicate important platform updates or account notifications.</li>
                <li>To analyze anonymized, aggregated platform statistics (e.g., "80% of student users set time-management goals").</li>
            </ul>

            <h2>3. Data Sharing & Third Parties</h2>
            <p>We do <strong>NOT</strong> sell your personal data.</p>
            <p>We only share data with essential infrastructure providers (e.g., secure database hosting, transactional email delivery) who are contractually bound to keep your data confidential.</p>
            <p>We will never share your individual responses or progress data with your university without your explicit opt-in consent.</p>

            <h2>4. Data Retention & Deletion</h2>
            <p>We retain your personal data for as long as your account is active.</p>
            <p>Upon account deletion, your personal data is permanently wiped from active databases within 30 days.</p>

            <h2>5. Your Data Rights</h2>
            <p>Depending on your location (e.g., GDPR, CCPA), you have the right to:</p>
            <ul>
                <li>Access a copy of your personal data.</li>
                <li>Correct inaccuracies in your data.</li>
                <li>Request complete deletion of your data ("Right to be Forgotten").</li>
            </ul>

            <h2>6. Academic Integrity</h2>
            <p>UniGrowth expressly prohibits using the platform to facilitate cheating or contract cheating. Universities may block platforms that enable academic dishonesty.</p>

            <h2>7. FERPA & Institutional Privacy</h2>
            <p>Student data is kept strictly separate from university administrative access. Students can use personal reflection tools without fear that their school can view their entries.</p>

            <h2>8. Mental Health Guardrails</h2>
            <p>Clear disclaimers and crisis helpline links are visible in the app. Personal development often touches on mental health; UniGrowth is not a clinical service.</p>
            <p>If you are experiencing a mental health crisis, please contact your university's counseling center or emergency health services immediately.</p>

            <hr class="my-4">
            <p class="text-center mb-0">
                <a href="/" class="text-decoration-none" style="color: #6366f1;">&larr; Back to UniGrowth</a>
            </p>
        </div>
    </div>

@include('partials.footer')
</body>
</html>
