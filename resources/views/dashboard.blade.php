<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">🏠 Dashboard</h1>
            <div class="flex gap-4 items-center">
                <span class="text-sm text-gray-600">{{ auth()->user()->username }}</span>
                <a href="{{ route('overview.index') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">Overview</a>
                <a href="{{ route('profile.show') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">Profile</a>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 underline">Logout</button>
                </form>
            </div>

        <!-- Status / Success Messages -->
        @if (session('status'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span class="text-sm">{{ session('status') }}</span>
            </div>
        @endif

        <!-- Email Verification Notice -->
        @if (!auth()->user()->hasVerifiedEmail())
            <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                <p class="text-sm font-semibold">Your email is not yet verified.</p>
                <p class="text-sm mt-1">Please check your inbox for the verification link.</p>
                <form action="{{ route('verification.send') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 underline">
                        Resend verification email
                    </button>
                </form>
            </div>
        @else
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span class="text-sm font-semibold">✅ Email verified — You are logged in.</span>
            </div>
        @endif

        <!-- Top 10 Leaderboard -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-purple-600">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-white">🏆 Top 10 Leaderboard</h2>
                        <p class="text-sm text-blue-100">{{ $currentSeasonName }}</p>
                    </div>
                    <a href="{{ route('overview.index') }}" class="text-xs text-white bg-white bg-opacity-20 hover:bg-opacity-30 px-3 py-1 rounded">
                        Full Overview →
                    </a>
                </div>

            @if ($hasActiveSeason && count($leaderboard) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3 w-12">#</th>
                                <th class="px-6 py-3">User</th>
                                <th class="px-6 py-3 text-right">Score</th>
                                <th class="px-6 py-3 text-right">Skills</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($leaderboard as $entry)
                                <tr class="hover:bg-gray-50 transition-colors {{ $entry['rank'] <= 3 ? 'bg-yellow-50' : '' }}">
                                    <!-- Rank Badge -->
                                    <td class="px-6 py-4">
                                        @if ($entry['rank'] === 1)
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white font-bold text-sm">🥇</span>
                                        @elseif ($entry['rank'] === 2)
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white font-bold text-sm">🥈</span>
                                        @elseif ($entry['rank'] === 3)
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-600 text-white font-bold text-sm">🥉</span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-8 h-8 text-gray-500 font-bold text-sm">{{ $entry['rank'] }}</span>
                                        @endif
                                    </td>

                                    <!-- User Info -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <!-- Avatar -->
                                            @if ($entry['is_public'] && !empty($entry['avatar_path']))
                                                <img src="{{ asset('storage/' . $entry['avatar_path']) }}" alt="avatar"
                                                     class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm border-2 border-gray-200">
                                                    {{ strtoupper(substr($entry['username'], 0, 1)) }}
                                                </div>
                                            @endif

                                            <div>
                                                <!-- Username always shown -->
                                                <p class="font-semibold text-gray-800">{{ $entry['username'] }}</p>

                                                <!-- Public extra info -->
                                                @if ($entry['is_public'])
                                                    <div class="text-xs text-gray-500 space-y-0.5 mt-0.5">
                                                        @if (!empty($entry['university_name']))
                                                            <span class="block">{{ $entry['university_name'] }}</span>
                                                        @endif
                                                        @if (!empty($entry['major']))
                                                            <span class="block italic">{{ $entry['major'] }}</span>
                                                        @endif
                                                        @if (!empty($entry['social_links']))
                                                            <div class="flex gap-2 mt-1">
                                                                @foreach ($entry['social_links'] as $link)
                                                                    <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer"
                                                                       class="text-blue-500 hover:text-blue-700 text-xs underline">
                                                                        {{ $link['platform'] }}
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-xs text-gray-400 italic">Private profile</span>
                                                @endif
                                            </div>
                                    </td>

                                    <!-- Score -->
                                    <td class="px-6 py-4 text-right">
                                        <span class="font-bold text-lg {{ $entry['rank'] === 1 ? 'text-yellow-600' : ($entry['rank'] === 2 ? 'text-gray-500' : ($entry['rank'] === 3 ? 'text-amber-700' : 'text-gray-700')) }}">
                                            {{ number_format($entry['season_score'], 1) }}
                                        </span>
                                    </td>

                                    <!-- Skills Count -->
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-sm text-gray-500">{{ $entry['skill_count'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif ($hasActiveSeason && count($leaderboard) === 0)
                <div class="p-8 text-center text-gray-500">
                    <p class="text-lg">📭 No scores yet this season.</p>
                    <p class="text-sm mt-1">Take a quiz to get on the leaderboard!</p>
                    <a href="{{ route('assessment.test.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded text-sm hover:bg-blue-600">
                        Take a Quiz
                    </a>
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    <p class="text-lg">⏸️ No active season running.</p>
                    <p class="text-sm mt-1">Contact an administrator to start a season.</p>
                </div>
            @endif
        </div>

        <!-- Quick links -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Quick Links</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('overview.index') }}" class="bg-blue-100 text-blue-700 px-4 py-2 rounded text-sm hover:bg-blue-200">
                    📊 Student Overview
                </a>
                <a href="{{ route('profile.show') }}" class="bg-green-100 text-green-700 px-4 py-2 rounded text-sm hover:bg-green-200">
                    👤 My Profile
                </a>
                <a href="{{ route('assessment.test.index') }}" class="bg-purple-100 text-purple-700 px-4 py-2 rounded text-sm hover:bg-purple-200">
                    📝 Take a Quiz
                </a>
                <a href="{{ route('core-assets.skills') }}" class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded text-sm hover:bg-yellow-200">
                    📚 Browse Skills
                </a>
                <a href="{{ route('core.test-recommendations.index') }}" class="bg-pink-100 text-pink-700 px-4 py-2 rounded text-sm hover:bg-pink-200">
                    🔍 Recommendations
                </a>
            </div>
    </div>
</body>
</html>
