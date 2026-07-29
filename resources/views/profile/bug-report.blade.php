<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report a Bug - UniGrowth</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">🐛 Report a Bug</h1>
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

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('profile.bug-report.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Bug Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required maxlength="200" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500" placeholder="Brief description of the issue">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="5" required maxlength="5000" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500" placeholder="Detailed description of what happened...">{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="steps_to_reproduce" class="block text-sm font-medium text-gray-700 mb-1">Steps to Reproduce</label>
                    <textarea name="steps_to_reproduce" id="steps_to_reproduce" rows="4" maxlength="5000" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500" placeholder="1. Go to...&#10;2. Click on...&#10;3. See error...">{{ old('steps_to_reproduce') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="severity" class="block text-sm font-medium text-gray-700 mb-1">Severity <span class="text-red-500">*</span></label>
                    <select name="severity" id="severity" required class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="low" {{ old('severity') === 'low' ? 'selected' : '' }}>Low - Minor inconvenience</option>
                        <option value="medium" {{ old('severity') === 'medium' ? 'selected' : '' }}>Medium - Affects functionality</option>
                        <option value="high" {{ old('severity') === 'high' ? 'selected' : '' }}>High - Major feature broken</option>
                        <option value="critical" {{ old('severity') === 'critical' ? 'selected' : '' }}>Critical - System down / data loss</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="screenshot" class="block text-sm font-medium text-gray-700 mb-1">Screenshot (optional)</label>
                    <input type="file" name="screenshot" id="screenshot" accept="image/png,image/jpeg,image/gif" class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-1">Max 2MB. Accepted formats: PNG, JPG, GIF.</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded text-sm">Submit Bug Report</button>
                </div>
            </form>
        </div>
</body>
</html>
</parameter>
</invoke>
</｜tool_calls>
