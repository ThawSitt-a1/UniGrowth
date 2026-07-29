{{-- Minimal E2E test UI for Skill Assessment & Ranking System --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Test UI</title>
    <style>
        body { font-family: monospace; background: #1a1a2e; color: #e0e0e0; padding: 20px; max-width: 1200px; margin: 0 auto; }
        h1, h2, h3 { color: #00d4aa; border-bottom: 1px solid #333; padding-bottom: 5px; }
        a { color: #00d4aa; }
        .card { background: #16213e; border: 1px solid #0f3460; border-radius: 6px; padding: 15px; margin-bottom: 20px; }
        .card h3 { margin-top: 0; border-bottom: 1px solid #0f3460; }
        label { display: block; margin: 8px 0 4px; color: #a0a0a0; }
        select, button { background: #0f3460; color: #e0e0e0; border: 1px solid #1a5276; padding: 8px 12px; border-radius: 4px; font-family: monospace; font-size: 14px; }
        button { cursor: pointer; background: #00d4aa; color: #1a1a2e; font-weight: bold; }
        button:hover { background: #00b894; }
        .option-item { margin: 6px 0; padding: 8px; background: #0f3460; border-radius: 4px; cursor: pointer; }
        .option-item.selected { background: #1a5276; border: 1px solid #00d4aa; }
        .option-item input { margin-right: 8px; }
        .success { color: #00d4aa; background: #003d33; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .error { color: #ff6b6b; background: #3d0000; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .info { color: #74b9ff; background: #0a1a3a; padding: 10px; border-radius: 4px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #0f3460; padding: 8px 12px; text-align: left; }
        th { background: #0f3460; color: #00d4aa; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 768px) { .grid { grid-template-columns: 1fr; } }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
        .badge.easy { background: #00b894; color: #1a1a2e; }
        .badge.medium { background: #fdcb6e; color: #1a1a2e; }
        .badge.hard { background: #e17055; color: #fff; }
        .badge.passed { background: #00d4aa; color: #1a1a2e; }
        .badge.failed { background: #ff6b6b; color: #fff; }
        .nav-links { margin: 15px 0; }
        .nav-links a { margin-right: 15px; }
        .question-block { background: #0f3460; padding: 12px; border-radius: 4px; margin-bottom: 12px; }
    </style>
</head>
<body>
    <h1>🧪 Skill Assessment & Ranking Test UI</h1>

    <div class="nav-links">
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('core-assets.index') }}">📚 Core Assets</a>
        <a href="{{ route('core.test-recommendations.index') }}">🔍 Recommendations</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Logout</a>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <div class="grid">
        {{-- LEFT COLUMN: Quiz Section --}}
        <div>
            <div class="card">
                <h3>📝 Take a Quiz</h3>
                <form method="GET" action="{{ route('assessment.test.index') }}">
                    @csrf
                    <label for="skill_id">Select Skill:</label>
                    <select name="skill_id" id="skill_id" onchange="this.form.submit()">
                        <option value="">-- Choose a skill --</option>
                        @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}" {{ $selectedSkillId === $skill->id ? 'selected' : '' }}>
                                {{ $skill->title }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if ($quiz)
                <div class="card">
                    <h3>📋 {{ $quiz['skill_title'] }}</h3>
                    <p>Total Questions: <strong>{{ $quiz['total_questions'] }}</strong></p>

                    <form method="POST" action="{{ route('assessment.test.submit') }}">
                        @csrf
                        <input type="hidden" name="skill_id" value="{{ $selectedSkillId }}">

                        @foreach ($quiz['questions'] as $qIndex => $question)
                            <div class="question-block">
                                <p>
                                    <strong>Q{{ $qIndex + 1 }}:</strong> {{ $question['question_text'] }}
                                    <span class="badge {{ $question['difficulty'] }}">{{ $question['difficulty'] }}</span>
                                </p>
                                @foreach ($question['options'] as $option)
                                    <div class="option-item">
                                        <input type="radio"
                                               name="answers[{{ $question['id'] }}]"
                                               value="{{ $option['id'] }}"
                                               id="q_{{ $question['id'] }}_o_{{ $option['id'] }}"
                                               required>
                                        <label for="q_{{ $question['id'] }}_o_{{ $option['id'] }}" style="display: inline; cursor: pointer;">
                                            {{ $option['option_text'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <button type="submit" style="margin-top: 10px;">✅ Submit Quiz</button>
                    </form>
                </div>
            @elseif ($selectedSkillId)
                <div class="info">No unseen questions available for this skill (you may have answered all).</div>
            @endif

            {{-- Quiz Result --}}
            @if (session('result'))
                @php $r = session('result'); @endphp
                <div class="card">
                    <h3>📊 Last Quiz Result</h3>
                    <p>Score: <strong>{{ $r['score'] }} / {{ $r['max_score'] }}</strong></p>
                    <p>Percentage: <strong>{{ $r['percentage'] }}%</strong></p>
                    <p>Status: <span class="badge {{ $r['passed'] ? 'passed' : 'failed' }}">
                        {{ $r['passed'] ? '✅ PASSED' : '❌ FAILED' }}
                    </span></p>
                    <p>Proficiency Score: <strong>{{ $r['proficiency_score'] }}</strong></p>
                    <details>
                        <summary>View Question Details</summary>
                        @foreach ($r['question_results'] as $qr)
                            <div class="option-item" style="{{ $qr['correct'] ? 'border-left: 3px solid #00d4aa;' : 'border-left: 3px solid #ff6b6b;' }}">
                                Q{{ $qr['question_id'] }}: {{ $qr['correct'] ? '✅ Correct' : '❌ Incorrect' }}
                            </div>
                        @endforeach
                    </details>
                </div>
            @endif
        </div>

        {{-- RIGHT COLUMN: Dashboard & Leaderboard --}}
        <div>
            {{-- Dashboard --}}
            @if ($dashboard)
                <div class="card">
                    <h3>📊 Dashboard</h3>
                    <p><strong>{{ $dashboard['username'] }}</strong> — Rank: #<strong>{{ $dashboard['rank'] }}</strong></p>
                    <p>Platform Score: <strong>{{ $dashboard['platform_score'] }}</strong></p>
                    <table>
                        <tr><th>Metric</th><th>Value</th></tr>
                        <tr><td>Total Skills</td><td>{{ $dashboard['stats']['total_skills'] }}</td></tr>
                        <tr><td>Total Attempts</td><td>{{ $dashboard['stats']['total_attempts'] }}</td></tr>
                        <tr><td>Average Score</td><td>{{ $dashboard['stats']['average_score'] }}%</td></tr>
                        <tr><td>Questions Answered</td><td>{{ $dashboard['stats']['total_questions_answered'] }}</td></tr>
                    </table>

                    @if (!empty($dashboard['skill_progress']))
                        <h4>Skill Proficiency</h4>
                        <table>
                            <tr><th>Skill</th><th>Score</th><th>Attempts</th></tr>
                            @foreach ($dashboard['skill_progress'] as $sp)
                                <tr>
                                    <td>{{ $sp['skill_title'] }}</td>
                                    <td>{{ $sp['proficiency_score'] }}</td>
                                    <td>{{ $sp['attempts_count'] }}</td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            @endif

            {{-- Leaderboard --}}
            @if (!empty($leaderboard))
                <div class="card">
                    <h3>🏆 Leaderboard (Top 10)</h3>
                    <table>
                        <tr><th>Rank</th><th>Username</th><th>Score</th></tr>
                        @foreach ($leaderboard as $entry)
                            <tr>
                                <td>#{{ $entry['rank'] }}</td>
                                <td>{{ $entry['username'] }}</td>
                                <td>{{ $entry['platform_score'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
    </div>
</body>
</html>

