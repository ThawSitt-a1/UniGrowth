<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security - UniGrowth</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">🔒 Security Settings</h1>
            <a href="{{ route('profile.show') }}" class="text-sm text-blue-600 hover:text-blue-800 underline">← Back to Profile</a>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Change Password -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Change Password</h2>
            <form action="{{ route('profile.account.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="change_password">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                        <input type="password" name="current_password" id="current_password" required class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" name="new_password" id="new_password" required minlength="12" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-400 mt-1">Minimum 12 characters.</p>
                    </div>
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500">
                    </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded text-sm">Change Password</button>
                </div>
            </form>
        </div>

        <!-- Deactivate Account -->
        <div class="bg-white rounded-lg shadow p-6 border border-red-200">
            <h2 class="text-lg font-semibold text-red-700 mb-4">⚠️ Danger Zone</h2>
            <p class="text-sm text-gray-600 mb-4">Deactivating your account will suspend your profile and you will not be able to log in. Contact an administrator to reactivate your account.</p>
            <form action="{{ route('profile.account.update') }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to deactivate your account? This action cannot be undone without contacting support.')">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="deactivate">
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded text-sm">Deactivate Account</button>
            </form>
        </div>
</body>
</html>
</parameter>
</invoke>
</｜tool_calls>
