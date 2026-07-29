<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - UniGrowth</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">✏️ Edit Profile</h1>
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
            <!-- Avatar Upload -->
            <form action="{{ route('profile.avatar.upload') }}" method="POST" enctype="multipart/form-data" class="mb-6 pb-6 border-b">
                @csrf
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Profile Picture</h2>
                <div class="flex items-center gap-4">
                    @if ($profile['avatar_path'])
                        <img src="{{ $profile['avatar_path'] }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover">
                    @else
                        <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-2xl text-blue-500 font-bold">{{ strtoupper(substr($profile['username'] ?? 'U', 0, 1)) }}</span>
                        </div>
                    @endif
                    <input type="file" name="avatar" accept="image/*" class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded text-sm hover:bg-blue-600">Upload</button>
                </div>
            </form>

            <!-- Profile Edit Form -->
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Biographical Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" value="{{ $profile['username'] }}" disabled class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-50 text-gray-500 text-sm">
                        <p class="text-xs text-gray-400 mt-1">Username cannot be changed.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" value="{{ $profile['email'] }}" disabled class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-50 text-gray-500 text-sm">
                        <p class="text-xs text-gray-400 mt-1">Email cannot be changed.</p>
                    </div>
                    <div>
                        <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-1">Academic Year</label>
                        <select name="academic_year" id="academic_year" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select year</option>
                            @foreach (['Freshman', 'Sophomore', 'Junior', 'Senior', 'Graduate', 'Postgraduate'] as $year)
                                <option value="{{ $year }}" {{ ($profile['academic_year'] ?? '') === $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="major" class="block text-sm font-medium text-gray-700 mb-1">Major / Field of Study</label>
                        <input type="text" name="major" id="major" value="{{ $profile['major'] ?? '' }}" maxlength="100" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label for="university_name" class="block text-sm font-medium text-gray-700 mb-1">University Name</label>
                        <input type="text" name="university_name" id="university_name" value="{{ $profile['university_name'] ?? '' }}" maxlength="150" class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded text-sm">Save Changes</button>
                </div>
            </form>
        </div>
</body>
</html>
</parameter>
</invoke>
</｜tool_calls>
