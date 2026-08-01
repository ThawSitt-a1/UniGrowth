<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Core :: Test Assets</title>
    <style>
        body { font-family:monospace; padding:2rem; max-width:700px; margin:auto; background:#f5f5f5; }
        h2 { color:#333; }
        .note { font-size:0.85rem; color:#888; }
        .box { background:#fff; padding:1rem; border:1px solid #ccc; margin-bottom:1rem; overflow-x:auto; }
        .msg-success { background:#d4edda; border:1px solid #c3e6cb; color:#155724; padding:0.5rem; margin-bottom:1rem; }
        .msg-error   { background:#f8d7da; border:1px solid #f5c6cb; color:#721c24; padding:0.5rem; margin-bottom:1rem; }
        table { width:100%; border-collapse:collapse; }
        td, th { border:1px solid #ddd; padding:0.4rem; text-align:left; font-size:0.9rem; }
        input, button { padding:0.4rem; }
        @media (max-width: 600px) {
            body { padding:1rem; }
            table { font-size:0.8rem; }
            td, th { padding:0.3rem; }
            input, button { font-size:0.8rem; padding:0.3rem; }
            pre { font-size:0.65rem !important; }
        }
    </style>
</head>
<body>
    <h2>🧪 Core Service :: Test Assets</h2>
    <p class="note">(ugly on purpose — testing only)</p>
    <p><a href="{{ route('dashboard') }}">← Main Dashboard</a></p>

    @if (session('success'))
        <div class="msg-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="msg-error">{{ session('error') }}</div>
    @endif

    <!-- ============== GOALS ============== -->
    <div class="box">
        <h3>📋 Goals</h3>

        <form method="POST" action="{{ route('core.test-assets.goal.create') }}" style="margin-bottom:1rem;">
            @csrf
            <input type="text" name="text" placeholder="Goal text..." required>
            <button type="submit" style="background:#007bff; color:#fff; border:none;">Add Goal</button>
        </form>

        @if (!empty($profile['goals']))
            <table>
                <tr><th>ID</th><th>Text</th><th>Status</th><th>Actions</th></tr>
                @foreach ($profile['goals'] as $goal)
                <tr>
                    <td>{{ $goal['id'] }}</td>
                    <td>{{ $goal['text'] }}</td>
                    <td>{{ $goal['status'] }}</td>
                    <td>
                        @if ($goal['status'] !== 'completed')
                        <form method="POST" action="{{ route('core.test-assets.goal.complete') }}" style="display:inline;">
                            @csrf
                            <input type="hidden" name="goal_id" value="{{ $goal['id'] }}">
                            <button type="submit" style="background:#28a745; color:#fff; border:none;">✅ Complete</button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('core.test-assets.goal.delete') }}" style="display:inline;">
                            @csrf
                            <input type="hidden" name="goal_id" value="{{ $goal['id'] }}">
                            <button type="submit" style="background:#dc3545; color:#fff; border:none;">❌ Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        @else
            <p>No goals yet.</p>
        @endif
    </div>

    <!-- ============== SKILLS ============== -->
    <div class="box">
        <h3>🎓 Enrolled Skills</h3>

        <form method="POST" action="{{ route('core.test-assets.skill.enroll') }}" style="margin-bottom:1rem;">
            @csrf
            <input type="number" name="skill_id" placeholder="Skill ID..." required min="1">
            <button type="submit" style="background:#6f42c1; color:#fff; border:none;">Enroll</button>
        </form>

        @if (!empty($profile['enrolled_skills']))
            <table>
                <tr><th>Skill ID</th><th>Title</th><th>Status</th><th>Enrolled</th><th>Action</th></tr>
                @foreach ($profile['enrolled_skills'] as $es)
                <tr>
                    <td>{{ $es['skill_id'] }}</td>
                    <td>{{ $es['skill_title'] ?? 'N/A' }}</td>
                    <td>{{ $es['status'] }}</td>
                    <td>{{ isset($es['enrolled_at']) ? \Carbon\Carbon::parse($es['enrolled_at'])->diffForHumans() : 'N/A' }}</td>
                    <td>
                        <form method="POST" action="{{ route('core.test-assets.skill.unenroll') }}" style="display:inline;">
                            @csrf
                            <input type="hidden" name="skill_id" value="{{ $es['skill_id'] }}">
                            <button type="submit" style="background:#fd7e14; color:#fff; border:none;">❌ Unenroll</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        @else
            <p>Not enrolled in any skills.</p>
        @endif
    </div>

    <!-- ============== RAW PROFILE ============== -->
    <div class="box">
        <h3>🔍 Raw Profile Data</h3>
        <pre style="font-size:0.8rem; background:#eee; padding:0.5rem; overflow-x:auto;">{{ json_encode($profile, JSON_PRETTY_PRINT) }}</pre>
</div>
    @include('partials.footer')
</body>
</html>

