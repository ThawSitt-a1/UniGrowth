<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - UniGrowth</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">👤 My Profile</h1>
            <div class="flex gap-4 items-center">
                <span class="text-sm text-gray-600">{{ $profile['username'] ?? 'User' }}</span>
                <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">Dashboard</a>
                <a href="{{ route('overview.index') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">Overview</a>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 underline">Logout</button>
                </form>
            </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">{{ session('error') }}</div>
        @endif

        <!-- Profile Tabs -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="border-b px-6 py-3 flex gap-6">
                <a href="{{ route('profile.show') }}" class="text-blue-600 font-semibold border-b-2 border-blue-600 pb-3 -mb-3">Profile</a>
                <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-blue-600 pb-3">Edit</a>
                <a href="{{ route('profile.preferences') }}" class="text-gray-600 hover:text-blue-600 pb-3">Preferences</a>
                <a href="{{ route('profile.social') }}" class="text-gray-600 hover:text-blue-600 pb-3">Social & Privacy</a>
                <a href="{{ route('profile.security') }}" class="text-gray-600 hover:text-blue-600 pb-3">Security</a>
                <a href="{{ route('profile.bug-report') }}" class="text-gray-600 hover:text-blue-600 pb-3">Report Bug</a>
            </div>

        <!-- Profile Content -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-start gap-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    @if ($profile['avatar_path'])
                        <img src="{{ $profile['avatar_path'] }}" alt="Avatar" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                    @else
                        <div class="w-32 h-32 rounded-full bg-blue-100 flex items-center justify-center border-4 border-gray-200">
                            <span class="text-4xl text-blue-500 font-bold">{{ strtoupper(substr($profile['username'] ?? 'U', 0, 1)) }}</span>
                        </div>
                    @endif
                </div>
                <!-- Info -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $profile['username'] }}</h2>
                    <p class="text-gray-500">{{ $profile['email'] }}</p>
                    <p class="text-sm text-gray-400 mt-1">Role: {{ $profile['role'] }}</p>
                    <p class="text-sm text-gray-400">Member since: {{ \Carbon\Carbon::parse($profile['created_at'])->format('M d, Y') }}</p>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 rounded p-3 text-center">
                            <p class="text-lg font-bold text-blue-600">{{ $profile['platform_score'] ?? 0 }}</p>
                            <p class="text-xs text-gray-500">Platform Score</p>
                        </div>
                        <div class="bg-green-50 rounded p-3 text-center">
                            <p class="text-lg font-bold text-green-600">{{ $profile['academic_year'] ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">Academic Year</p>
                        </div>
                        <div class="bg-purple-50 rounded p-3 text-center">
                            <p class="text-lg font-bold text-purple-600">{{ $profile['major'] ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500">Major</p>
                        </div>

                    @if ($profile['university_name'])
                        <p class="mt-3 text-sm text-gray-600">🏛️ {{ $profile['university_name'] }}</p>
                    @endif
                </div>

            <!-- Social Links -->
            @if (!empty($profile['social_links']))
                <div class="mt-6 border-t pt-4">
                    <h3 class="text-sm font-semibold text-gray-600 mb-3">🔗 Social Links</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($profile['social_links'] as $link)
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer"
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm">
                                {{ ucfirst($link['platform']) }}
                            </a>
                        @endforeach
                    </div>
            @endif

            <!-- Privacy Status -->
            <div class="mt-4 border-t pt-4">
                <h3 class="text-sm font-semibold text-gray-600 mb-2">🔒 Privacy</h3>
                @php
                    $isPublic = $profile['preferences']['privacy_show_profile'] ?? true;
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm {{ $isPublic ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $isPublic ? 'Public Profile' : 'Private Profile' }}
                </span>
            </div>

        <!-- Quick Actions -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('profile.edit') }}" class="bg-blue-500 hover:bg-blue-600 text-white text-center px-4 py-3 rounded-lg shadow">
                ✏️ Edit Profile
            </a>
            <a href="{{ route('profile.preferences') }}" class="bg-purple-500 hover:bg-purple-600 text-white text-center px-4 py-3 rounded-lg shadow">
                ⚙️ Preferences
            </a>
            <a href="{{ route('profile.social') }}" class="bg-green-500 hover:bg-green-600 text-white text-center px-4 py-3 rounded-lg shadow">
                🔗 Social Links
            </a>
        </div>
</body>
</html>
</parameter>
</invoke>
</｜tool_calls>
