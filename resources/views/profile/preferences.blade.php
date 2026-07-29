<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preferences - UniGrowth</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">⚙️ Preferences</h1>
            <a href="{{ route('profile.show') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">← Back to Profile</a>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('profile.preferences.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <h2 class="text-lg font-semibold text-gray-800 mb-4">Appearance</h2>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Theme</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 px-4 py-2 border rounded cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="theme" value="light" {{ ($profile['preferences']['theme'] ?? 'light') === 'light' ? 'checked' : '' }}>
                            <span>☀️ Light</span>
                        </label>
                        <label class="flex items-center gap-2 px-4 py-2 border rounded cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="theme" value="dark" {{ ($profile['preferences']['theme'] ?? '') === 'dark' ? 'checked' : '' }}>
                            <span>🌙 Dark</span>
                        </label>
                    </div>

                <h2 class="text-lg font-semibold text-gray-800 mb-4">Notifications</h2>
                <div class="space-y-3 mb-6">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="notifications_email" value="1" {{ ($profile['preferences']['notifications_email'] ?? true) ? 'checked' : '' }} class="rounded">
                        <span class="text-sm text-gray-700">Email notifications</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="notifications_browser" value="1" {{ ($profile['preferences']['notifications_browser'] ?? true) ? 'checked' : '' }} class="rounded">
                        <span class="text-sm text-gray-700">Browser notifications</span>
                    </label>
                </div>

                <h2 class="text-lg font-semibold text-gray-800 mb-4">Privacy Preferences</h2>
                <div class="space-y-3 mb-6">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="privacy_show_profile" value="1" {{ ($profile['preferences']['privacy_show_profile'] ?? true) ? 'checked' : '' }} class="rounded">
                        <span class="text-sm text-gray-700">Show my profile to other users</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="privacy_show_progress" value="1" {{ ($profile['preferences']['privacy_show_progress'] ?? true) ? 'checked' : '' }} class="rounded">
                        <span class="text-sm text-gray-700">Show my progress to other users</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="privacy_show_goals" value="1" {{ ($profile['preferences']['privacy_show_goals'] ?? true) ? 'checked' : '' }} class="rounded">
                        <span class="text-sm text-gray-700">Show my goals to other users</span>
                    </label>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded text-sm">Save Preferences</button>
                </div>
            </form>
        </div>
</body>
</html>
</parameter>
</invoke>
</｜tool_calls>
