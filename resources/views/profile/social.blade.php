<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social & Privacy - UniGrowth</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">🔗 Social Links & Privacy</h1>
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
            <form action="{{ route('profile.privacy-social.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Visibility -->
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Profile Visibility</h2>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Who can see your profile?</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 px-4 py-2 border rounded cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="visibility" value="public" {{ ($profile['preferences']['privacy_show_profile'] ?? true) ? 'checked' : '' }}>
                            <span>🌍 Public</span>
                        </label>
                        <label class="flex items-center gap-2 px-4 py-2 border rounded cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="visibility" value="private" {{ !($profile['preferences']['privacy_show_profile'] ?? true) ? 'checked' : '' }}>
                            <span>🔒 Private</span>
                        </label>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">When set to Private, other users cannot view your profile details.</p>
                </div>

                <!-- Social Links -->
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Social Links</h2>
                <div id="social-links-container" class="space-y-3 mb-4">
                    @if (!empty($profile['social_links']))
                        @foreach ($profile['social_links'] as $index => $link)
                            <div class="flex gap-2 items-start social-link-row">
                                <select name="social_links[{{ $index }}][platform]" class="px-3 py-2 border border-gray-300 rounded text-sm">
                                    <option value="github" {{ $link['platform'] === 'github' ? 'selected' : '' }}>GitHub</option>
                                    <option value="linkedin" {{ $link['platform'] === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                                    <option value="portfolio" {{ $link['platform'] === 'portfolio' ? 'selected' : '' }}>Portfolio</option>
                                    <option value="twitter" {{ $link['platform'] === 'twitter' ? 'selected' : '' }}>Twitter</option>
                                    <option value="dribbble" {{ $link['platform'] === 'dribbble' ? 'selected' : '' }}>Dribbble</option>
                                    <option value="other" {{ $link['platform'] === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <input type="url" name="social_links[{{ $index }}][url]" value="{{ $link['url'] }}" placeholder="https://..." class="flex-1 px-3 py-2 border border-gray-300 rounded text-sm">
                                <button type="button" class="remove-link text-red-500 hover:text-red-700 px-2">✕</button>
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500 italic" id="no-links-msg">No social links added yet.</p>
                    @endif
                </div>
                <button type="button" id="add-link-btn" class="text-sm text-blue-600 hover:text-blue-800 mb-6 inline-block">+ Add Social Link</button>

                <div class="flex justify-end border-t pt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded text-sm">Save Settings</button>
                </div>
            </form>
        </div>

    <script>
        let linkIndex = {{ count($profile['social_links'] ?? []) }};
        document.getElementById('add-link-btn')?.addEventListener('click', function() {
            const container = document.getElementById('social-links-container');
            const noMsg = document.getElementById('no-links-msg');
            if (noMsg) noMsg.remove();

            const row = document.createElement('div');
            row.className = 'flex gap-2 items-start social-link-row';
            row.innerHTML = `
                <select name="social_links[${linkIndex}][platform]" class="px-3 py-2 border border-gray-300 rounded text-sm">
                    <option value="github">GitHub</option>
                    <option value="linkedin">LinkedIn</option>
                    <option value="portfolio">Portfolio</option>
                    <option value="twitter">Twitter</option>
                    <option value="dribbble">Dribbble</option>
                    <option value="other">Other</option>
                </select>
                <input type="url" name="social_links[${linkIndex}][url]" placeholder="https://..." class="flex-1 px-3 py-2 border border-gray-300 rounded text-sm">
                <button type="button" class="remove-link text-red-500 hover:text-red-700 px-2">✕</button>
            `;
            container.appendChild(row);
            linkIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-link')) {
                e.target.closest('.social-link-row').remove();
            }
        });
    </script>
</body>
</html>
</parameter>
</invoke>
</｜tool_calls>
