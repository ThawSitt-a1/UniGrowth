<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Overview</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">📊 Student Overview</h1>
            <div class="flex gap-4 items-center">
                <span class="text-sm text-gray-600">{{ $overview['username'] ?? 'User' }}</span>
                <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">Dashboard</a>
                <a href="{{ route('assessment.test.index') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">Assessments</a>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 underline">Logout</button>
                </form>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        @endif

        <!-- Season Banner -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">🏆 Current Season</h2>
            @if ($overview['season']['is_active'] ?? false)
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 rounded p-4 text-center">
                        <p class="text-2xl font-bold text-blue-600">{{ $overview['season']['season_name'] ?? 'Unnamed' }}</p>
                        <p class="text-sm text-gray-500">Season Name</p>
                    </div>
                    <div class="bg-green-50 rounded p-4 text-center">
                        <p class="text-2xl font-bold text-green-600">{{ $overview['season']['days_remaining'] ?? 0 }}</p>
                        <p class="text-sm text-gray-500">Days Remaining</p>
                    </div>
                    <div class="bg-purple-50 rounded p-4 text-center">
                        <p class="text-2xl font-bold text-purple-600">#{{ $overview['season_rank'] ?? '—' }}</p>
                        <p class="text-sm text-gray-500">Your Rank</p>
                    </div>
                    <div class="bg-yellow-50 rounded p-4 text-center">
                        <p class="text-2xl font-bold text-yellow-600">{{ number_format($overview['total_season_score'] ?? 0, 1) }}</p>
                        <p class="text-sm text-gray-500">Season Score</p>
                    </div>
                </div>
                <div class="mt-3 text-xs text-gray-400">
                    Started: {{ $overview['season']['started_at'] ?? 'N/A' }}
                    &middot; Ends: {{ $overview['season']['ends_at'] ?? 'N/A' }}
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded p-4 text-yellow-700">
                    <p class="font-semibold">⚠️ No active season is running.</p>
                    <p class="text-sm mt-1">Quizzes are only available during an active season. Contact an administrator to start one.</p>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- LEFT COLUMN: Goals & Quiz Stats -->
            <div>
                <!-- Goals Section -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">🎯 My Goals</h2>

                    <!-- Active Goals -->
                    <div class="mb-4">
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Active Goals ({{ count($overview['active_goals'] ?? []) }})</h3>
                        @if (!empty($overview['active_goals']))
                            <ul class="space-y-2">
                                @foreach ($overview['active_goals'] as $goal)
                                    <li class="flex items-start gap-2 bg-blue-50 rounded p-3">
                                        <span class="text-blue-500 mt-0.5">📌</span>
                                        <div>
                                            <p class="text-sm text-gray-800">{{ $goal['text'] }}</p>
                                            <p class="text-xs text-gray-400">Created: {{ \Carbon\Carbon::parse($goal['created_at'])->diffForHumans() }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500 italic">No active goals. Create one via <a href="{{ route('core-assets.index') }}" class="text-blue-600 underline">Core Assets</a>.</p>
                        @endif
                    </div>

                    <!-- Completed Goals -->
                    <details>
                        <summary class="text-sm font-semibold text-gray-600 cursor-pointer hover:text-gray-800">
                            Completed Goals ({{ count($overview['completed_goals'] ?? []) }})
                        </summary>
                        <div class="mt-2 space-y-2">
                            @if (!empty($overview['completed_goals']))
                                @foreach ($overview['completed_goals'] as $goal)
                                    <div class="flex items-start gap-2 bg-green-50 rounded p-3">
                                        <span class="text-green-500 mt-0.5">✅</span>
                                        <div>
                                            <p class="text-sm text-gray-600 line-through">{{ $goal['text'] }}</p>
                                            <p class="text-xs text-gray-400">Completed: {{ \Carbon\Carbon::parse($goal['completed_at'])->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-500 italic">No completed goals yet.</p>
                            @endif
                        </div>
                    </details>
                </div>

                <!-- Quiz Statistics -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">📝 Quiz Statistics</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-indigo-50 rounded p-3 text-center">
                            <p class="text-2xl font-bold text-indigo-600">{{ $overview['quiz_statistics']['total_questions_answered'] ?? 0 }}</p>
                            <p class="text-xs text-gray-500">Questions Answered</p>
                        </div>
                        <div class="bg-indigo-50 rounded p-3 text-center">
                            <p class="text-2xl font-bold text-indigo-600">{{ $overview['quiz_statistics']['total_attempts'] ?? 0 }}</p>
                            <p class="text-xs text-gray-500">Quiz Attempts</p>
                        </div>
                        <div class="bg-indigo-50 rounded p-3 text-center">
                            <p class="text-2xl font-bold text-indigo-600">{{ number_format($overview['quiz_statistics']['total_score'] ?? 0, 1) }}</p>
                            <p class="text-xs text-gray-500">Total Score</p>
                        </div>
                        <div class="bg-indigo-50 rounded p-3 text-center">
                            <p class="text-2xl font-bold text-indigo-600">{{ number_format($overview['quiz_statistics']['average_score_per_attempt'] ?? 0, 1) }}%</p>
                            <p class="text-xs text-gray-500">Avg Score/Attempt</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Enrolled Skills & Season Actions -->
            <div>
                <!-- Enrolled Skills -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">📚 Enrolled Skills ({{ count($overview['enrolled_skills'] ?? []) }})</h2>
                    @if (!empty($overview['enrolled_skills']))
                        <div class="space-y-3">
                            @foreach ($overview['enrolled_skills'] as $enrollment)
                                <div class="border rounded p-3 flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $enrollment['skill_title'] }}</p>
                                        <p class="text-xs text-gray-400">Enrolled: {{ \Carbon\Carbon::parse($enrollment['enrolled_at'])->diffForHumans() }}</p>
                                    </div>
                                    <a href="{{ route('assessment.test.index', ['skill_id' => $enrollment['skill_id']]) }}"
                                       class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">
                                        Take Quiz
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">Not enrolled in any skills yet.</p>
                        <a href="{{ route('core-assets.skills') }}" class="mt-3 inline-block bg-purple-500 text-white px-4 py-2 rounded text-sm hover:bg-purple-600">
                            Browse Skills
                        </a>
                    @endif
                </div>

                <!-- Season History & Admin Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">⚙️ Season Actions</h2>

                    <!-- End Season (admin) -->
                    @if ($overview['season']['is_active'] ?? false)
                        <form action="{{ route('overview.season.end') }}" method="POST"
                              onsubmit="return confirm('End the current season? This will snapshot scores and reset platform scores for all users.')">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600 w-full">
                                🛑 End Current Season
                            </button>
                        </form>
                        <p class="text-xs text-gray-400 mt-2">
                            Snapshot all scores, reset platform scores, and create a new season.
                        </p>
                    @else
                        <p class="text-sm text-gray-500 italic">No active season to end.</p>
                    @endif

                    <!-- Navigation Links -->
                    <div class="mt-6 border-t pt-4">
                        <h3 class="text-sm font-semibold text-gray-600 mb-2">Quick Links</h3>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('assessment.test.index') }}" class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm hover:bg-green-200">
                                📝 Take a Quiz
                            </a>
                            <a href="{{ route('core-assets.index') }}" class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm hover:bg-blue-200">
                                🎯 Manage Goals
                            </a>
                            <a href="{{ route('core-assets.skills') }}" class="bg-purple-100 text-purple-700 px-3 py-1 rounded text-sm hover:bg-purple-200">
                                📚 Browse Skills
                            </a>
                            <a href="{{ route('core.test-recommendations.index') }}" class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-sm hover:bg-yellow-200">
                                🔍 Recommendations
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Raw API Data (debug) -->
        <details class="mt-8">
            <summary class="text-sm text-gray-400 cursor-pointer hover:text-gray-600">🔍 View Raw Data</summary>
            <pre class="mt-2 bg-gray-800 text-gray-200 p-4 rounded text-xs overflow-x-auto">{{ json_encode($overview, JSON_PRETTY_PRINT) }}</pre>
        </details>
    </div>
</body>
</html>

