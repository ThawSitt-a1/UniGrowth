<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Core :: Test Recommendations</title>
    <style>
        body { font-family:monospace; padding:2rem; max-width:800px; margin:auto; background:#f5f5f5; }
        h2 { color:#333; }
        .note { font-size:0.85rem; color:#888; }
        .box { background:#fff; padding:1rem; border:1px solid #ccc; margin-bottom:1rem; border-radius:4px; overflow-x:auto; }
        .msg-success { background:#d4edda; border:1px solid #c3e6cb; color:#155724; padding:0.5rem; margin-bottom:1rem; border-radius:4px; }
        .msg-error   { background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; padding:0.5rem; margin-bottom:1rem; border-radius:4px; }
        table { width:100%; border-collapse:collapse; }
        td, th { border:1px solid #ddd; padding:0.5rem; text-align:left; font-size:0.9rem; }
        th { background:#f0f0f0; }
        tr.high-match { background:#d4edda; }
        tr.low-match  { background:#fff3cd; }
        tr.no-match   { background:#f8d7da; }
        .tag { display:inline-block; background:#e7e7e7; padding:2px 6px; border-radius:3px; font-size:0.75rem; margin:1px; }
        .tag.match { background:#c3e6cb; color:#155724; }
        .jaccard-bar { height:8px; border-radius:4px; background:#e0e0e0; margin-top:4px; overflow:hidden; }
        .jaccard-fill { height:100%; border-radius:4px; background:#28a745; }
        input, button { padding:0.4rem; font-size:0.9rem; }
        button { cursor:pointer; border:none; border-radius:3px; }
        .btn-primary { background:#007bff; color:#fff; }
        .btn-secondary { background:#6c757d; color:#fff; }
        .badge { display:inline-block; padding:2px 8px; border-radius:10px; font-size:0.75rem; font-weight:bold; }
        .badge-score { background:#28a745; color:#fff; }
        .badge-cold  { background:#ffc107; color:#333; }
        .stats { display:flex; gap:1rem; margin-bottom:0.5rem; flex-wrap:wrap; }
        .stat-item { background:#e9ecef; padding:0.5rem 1rem; border-radius:4px; text-align:center; flex:1; min-width:120px; }
        .stat-value { font-size:1.5rem; font-weight:bold; color:#333; }
        .stat-label { font-size:0.75rem; color:#666; }
        @media (max-width: 600px) {
            body { padding:1rem; }
            table { font-size:0.75rem; }
            td, th { padding:0.3rem; }
            .stats { flex-direction:column; }
            .stat-item { min-width:auto; }
            .stat-value { font-size:1.2rem; }
            .box { padding:0.75rem; }
            pre { font-size:0.6rem !important; }
        }
    </style>
</head>
<body>
    <h2>🧪 Recommendation Engine :: Test UI</h2>
    <p class="note">
        (ugly on purpose — testing only)
        &nbsp;|&nbsp;
        <a href="{{ route('core.test-assets.index') }}">Manage Assets</a>
        &nbsp;|&nbsp;
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </p>

    @if (session('success'))
        <div class="msg-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="msg-error">{{ session('error') }}</div>
    @endif

    <!-- ============== RECOMMENDATIONS DISPLAY ============== -->
    <div class="box">
        <h3>📊 Personalized Skill Recommendations</h3>

        <form method="GET" action="{{ route('core.test-recommendations.index') }}" style="margin-bottom:1rem;">
            <label for="limit">Limit:</label>
            <input type="number" id="limit" name="limit" value="{{ $limit }}" min="1" max="100" style="width:70px;">
            <button type="submit" class="btn-primary">🔄 Refresh</button>
            <button type="submit" class="btn-secondary" name="limit" value="100">Show All</button>
        </form>

        @if (!empty($userTags))
        <div class="stats">
            <div class="stat-item">
                <div class="stat-value">{{ $enrolledCount }}</div>
                <div class="stat-label">Enrolled Skills</div>
            <div class="stat-item">
                <div class="stat-value">
                    @foreach ($userTags as $tag)
                        <span class="tag match">{{ $tag }}</span>
                    @endforeach
                </div>
                <div class="stat-label">Your Tags (from enrolled skills)</div>
            <div class="stat-item">
                <div class="stat-value">{{ count($recommendations) }}</div>
                <div class="stat-label">Recommendations Shown</div>
            <div class="stat-item">
                <div class="stat-value">{{ $totalCandidates }}</div>
                <div class="stat-label">Available Skills</div>
        </div>
        @else
        <p style="color:#856404; background:#fff3cd; padding:0.5rem; border-radius:4px;">
            ⚠️ <strong>Cold Start Mode:</strong> You have no enrolled skills. Showing random skill recommendations.
            <br><small>Enroll in skills via <a href="{{ route('core.test-assets.index') }}">Manage Assets</a> to get personalized Jaccard-based recommendations.</small>
        </p>
        @endif

        @if (count($recommendations) > 0)
            <table>
                <tr>
                    <th>#</th>
                    <th>Skill</th>
                    <th>Tags</th>
                    <th>Matching Tags</th>
                    <th>Jaccard Score</th>
                </tr>
                @foreach ($recommendations as $i => $rec)
                    @php
                        $rowClass = $rec['matching_tags_count'] > 0 ? ($rec['score'] > 0.3 ? 'high-match' : 'low-match') : 'no-match';
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ $rec['title'] }}</strong>
                            <br><small style="color:#666;">{{ Str::limit($rec['description'], 60) }}</small>
                        </td>
                        <td>
                            @foreach ($rec['tags'] as $tag)
                                <span class="tag {{ in_array(strtolower($tag), array_map('strtolower', $rec['matching_tags'])) ? 'match' : '' }}">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </td>
                        <td style="text-align:center;">
                            @if ($rec['matching_tags_count'] > 0)
                                <span class="badge badge-score">{{ $rec['matching_tags_count'] }}</span>
                                <br>
                                <small>{{ implode(', ', $rec['matching_tags']) }}</small>
                            @else
                                <span class="badge badge-cold">0</span>
                            @endif
                        </td>
                        <td style="min-width:120px;">
                            @if ($rec['score'] > 0)
                                <strong>{{ number_format($rec['score'] * 100, 1) }}%</strong>
                                <div class="jaccard-bar">
                                    <div class="jaccard-fill" style="width:{{ min($rec['score'] * 100, 100) }}%;"></div>
                                <small style="color:#666;">
                                    |I∩C|/|I∪C| = {{ $rec['matching_tags_count'] }}/{{ count($rec['tags']) + count($userTags) - $rec['matching_tags_count'] }}
                                </small>
                            @else
                                <span style="color:#999;">— (random)</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <p>No recommendations available. No skills exist in the platform yet.</p>
        @endif
    </div>

    <!-- ============== RAW JSON DATA ============== -->
    <div class="box">
        <h3>🔍 Raw API Response</h3>
        <pre style="font-size:0.75rem; background:#eee; padding:0.5rem; overflow-x:auto;">{{ json_encode($rawApiResponse, JSON_PRETTY_PRINT) }}</pre>
</div>
    @include('partials.footer')
</body>
</html>
