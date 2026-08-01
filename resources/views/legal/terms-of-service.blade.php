<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniGrowth — Terms of Service</title>
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
            <h1 class="fw-bold mb-1" style="color: #1f2937; font-size: 1.75rem;">Terms of Service</h1>
            <p class="text-muted small mb-4">Last updated: {{ date('F d, Y') }}</p>

            <h2>1. Acceptance of Terms</h2>
            <p>By creating an account or accessing UniGrowth ("the Platform"), you agree to be bound by these Terms of Service. If you do not agree, you may not use the Platform.</p>

            <h2>2. Eligibility & Student Status</h2>
            <p>You must be at least 18 years old (or the legal age of digital consent in your jurisdiction) or have explicit parental/guardian consent to use the Platform.</p>
            <p>Account registration requires a valid university email address (.edu or institutional domain) where applicable.</p>

            <h2>3. User Accounts & Responsibilities</h2>
            <p>You are responsible for maintaining the confidentiality of your account credentials.</p>
            <p>You agree to provide accurate, current, and complete information during registration.</p>
            <p>You are solely responsible for all activities that occur under your account.</p>

            <h2>4. Acceptable Use Policy</h2>
            <p>You agree not to:</p>
            <ul>
                <li>Use the Platform to violate academic integrity policies (e.g., sharing exam answers, plagiarizing content).</li>
                <li>Post or transmit illegal, harassing, abusive, defamatory, or hateful content.</li>
                <li>Scrape, reverse-engineer, or compromise the security of the Platform.</li>
            </ul>

            <h2>5. Intellectual Property & User Content</h2>
            <p><strong>Our Content:</strong> All platform design, code, logos, and original materials belong strictly to UniGrowth.</p>
            <p><strong>Your Content:</strong> You retain ownership of any goal logs, journal entries, or progress tracking data you create. By uploading content, you grant us a limited, non-exclusive, royalty-free license to host and process that data solely to provide the platform's services to you.</p>

            <h2>6. Academic & Medical Disclaimer</h2>
            <p>UniGrowth is an educational and personal growth tool, not a certified mental health service, medical advice provider, or licensed career counseling firm.</p>
            <p>If you are experiencing a mental health crisis, please contact your university's counseling center or emergency health services immediately.</p>

            <h2>7. Termination & Account Deletion</h2>
            <p>We reserve the right to suspend or terminate your account if you violate these terms. You may delete your account and associated personal data at any time through your account settings.</p>

            <h2>8. Limitation of Liability</h2>
            <p>To the maximum extent permitted by law, UniGrowth shall not be liable for any indirect, incidental, or consequential damages resulting from your use or inability to use the Platform.</p>

            <hr class="my-4">
            <p class="text-center mb-0">
                <a href="/" class="text-decoration-none" style="color: #6366f1;">&larr; Back to UniGrowth</a>
            </p>
        </div>
    </div>

@include('partials.footer')
</body>
</html>
