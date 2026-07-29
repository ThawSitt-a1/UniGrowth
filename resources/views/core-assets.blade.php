<!DOCTYPE html>
<html>
<head>
    <title>Core Assets Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Core Assets Manager</h1>
            <div class="flex gap-4 items-center">
                <span class="text-sm text-gray-600">{{ auth()->user()->username }}</span>
                <a href="{{ route('core-assets.skills') }}"
                   class="text-sm text-blue-600 hover:text-blue-800 underline {{ request()->routeIs('core-assets.skills') ? 'font-bold' : '' }}">
                   Browse Skills
                </a>
                <a href="{{ route('core-assets.index') }}"
                   class="text-sm text-blue-600 hover:text-blue-800 underline {{ request()->routeIs('core-assets.index') ? 'font-bold' : '' }}">
                   My Goals
                </a>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 underline">Logout</button>
                </form>
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

        @if(request()->routeIs('core-assets.skills') && isset($availableSkills))
            {{-- ==================== SKILL BROWSING CATALOG ==================== --}}
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Available Skills</h2>

                <!-- Tag Filter Buttons -->
                <div class="mb-6">
                    <p class="text-sm font-semibold text-gray-600 mb-2">Filter by Tag:</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('core-assets.skills', ['sort' => $availableSkills['sort_by']]) }}"
                           class="px-3 py-1 rounded-full text-sm {{ is_null($availableSkills['selected_tag']) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            All
                        </a>
                        @foreach ($availableSkills['all_tags'] as $tag)
                            <a href="{{ route('core-assets.skills', ['tag' => $tag, 'sort' => $availableSkills['sort_by']]) }}"
                               class="px-3 py-1 rounded-full text-sm {{ $availableSkills['selected_tag'] === $tag ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                {{ $tag }}
                            </a>
                        @endforeach
                    </div>

                <!-- Sort Controls -->
                <div class="mb-6 flex items-center gap-4">
                    <p class="text-sm font-semibold text-gray-600">Sort by:</p>
                    <a href="{{ route('core-assets.skills', ['tag' => $availableSkills['selected_tag'], 'sort' => 'newest']) }}"
                       class="px-3 py-1 rounded text-sm {{ $availableSkills['sort_by'] === 'newest' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        Newest
                    </a>
                    <a href="{{ route('core-assets.skills', ['tag' => $availableSkills['selected_tag'], 'sort' => 'most_enrolled']) }}"
                       class="px-3 py-1 rounded text-sm {{ $availableSkills['sort_by'] === 'most_enrolled' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        Most Enrolled
                    </a>
                </div>

                <!-- Skills Grid -->
                @if (count($availableSkills['skills']) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($availableSkills['skills'] as $skill)
                            <div class="border rounded-lg p-5 bg-white shadow-sm hover:shadow-md transition-shadow {{ $skill['is_enrolled'] ? 'border-green-300 bg-green-50' : '' }}">
                                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $skill['title'] }}</h3>
                                <p class="text-sm text-gray-600 mb-3">{{ $skill['description'] }}</p>

                                <!-- Tags -->
                                @if (count($skill['tags']) > 0)
                                    <div class="flex flex-wrap gap-1 mb-3">
                                        @foreach ($skill['tags'] as $skillTag)
                                            <a href="{{ route('core-assets.skills', ['tag' => $skillTag, 'sort' => $availableSkills['sort_by']]) }}"
                                               class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full hover:bg-blue-200">
                                                {{ $skillTag }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Enrollment Count -->
                                <p class="text-xs text-gray-500 mb-3">
                                    👥 {{ $skill['enrollments_count'] }} enrolled
                                </p>

                                <!-- Enroll / Enrolled Button -->
                                @if ($skill['is_enrolled'])
                                    <span class="inline-block bg-green-100 text-green-800 text-sm px-4 py-2 rounded font-medium">
                                        ✅ Enrolled
                                    </span>
                                @else
                                    <form action="{{ route('core-assets.action') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type" value="skill">
                                        <input type="hidden" name="action" value="enroll">
                                        <input type="hidden" name="payload[skill_id]" value="{{ $skill['id'] }}">
                                        <button type="submit"
                                                class="bg-purple-500 text-white px-4 py-2 rounded text-sm hover:bg-purple-600 transition-colors">
                                            Enroll
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">No skills found{{ $availableSkills['selected_tag'] ? ' with tag "' . $availableSkills['selected_tag'] . '"' : '' }}.</p>
                    </div>
                @endif
            </div>
        @else
            {{-- ==================== GOALS & ENROLLED SKILLS MANAGEMENT ==================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Goals Section (user's own goals only) -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">My Goals</h2>

                    <!-- Create Goal Form -->
                    <form action="{{ route('core-assets.action') }}" method="POST" class="mb-6 flex gap-2">
                        @csrf
                        <input type="hidden" name="type" value="goal">
                        <input type="hidden" name="action" value="create">
                        <input type="text" name="payload[text]" placeholder="Enter a new goal..."
                               class="flex-1 border rounded px-3 py-2 text-sm" required>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded text-sm hover:bg-blue-600">
                            Add Goal
                        </button>
                    </form>

                    <!-- Goals List -->
                    <div class="space-y-3">
                        @forelse ($profile['goals'] ?? [] as $goal)
                            <div class="border rounded p-3 flex items-center justify-between {{ $goal['status'] === 'completed' ? 'bg-green-50 border-green-200' : '' }}">
                                <div class="flex-1">
                                    <p class="{{ $goal['status'] === 'completed' ? 'line-through text-gray-500' : 'text-gray-800' }}">
                                        {{ $goal['text'] }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Status: {{ $goal['status'] }}
                                        @if($goal['completed_at'])
                                            · Completed: {{ \Carbon\Carbon::parse($goal['completed_at'])->diffForHumans() }}
                                        @endif
                                    </p>
                                </div>
                                <div class="flex gap-2 ml-4">
                                    @if($goal['status'] !== 'completed')
                                        <form action="{{ route('core-assets.action') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type" value="goal">
                                            <input type="hidden" name="action" value="complete">
                                            <input type="hidden" name="payload[goal_id]" value="{{ $goal['id'] }}">
                                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600">
                                                Complete
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('core-assets.action') }}" method="POST"
                                          onsubmit="return confirm('Delete this goal?')">
                                        @csrf
                                        <input type="hidden" name="type" value="goal">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="payload[goal_id]" value="{{ $goal['id'] }}">
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                        @empty
                            <p class="text-gray-500 text-sm">No goals yet. Create one above!</p>
                        @endforelse
                    </div>

                <!-- My Enrolled Skills Section -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-800">My Enrolled Skills</h2>

                    <!-- Link to Browse Skills -->
                    <div class="mb-6">
                        <a href="{{ route('core-assets.skills') }}"
                           class="bg-purple-500 text-white px-4 py-2 rounded text-sm hover:bg-purple-600 inline-block">
                            Browse All Available Skills
                        </a>
                    </div>

                    <!-- Enrolled Skills List -->
                    <div class="space-y-3">
                        @forelse ($profile['enrolled_skills'] ?? [] as $enrollment)
                            <div class="border rounded p-3 flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $enrollment['skill_title'] ?? 'Skill #'.$enrollment['skill_id'] }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Status: {{ $enrollment['status'] }}
                                        @if($enrollment['enrolled_at'])
                                            · Enrolled: {{ \Carbon\Carbon::parse($enrollment['enrolled_at'])->diffForHumans() }}
                                        @endif
                                    </p>
                                </div>
                                <form action="{{ route('core-assets.action') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="skill">
                                    <input type="hidden" name="action" value="unenroll">
                                    <input type="hidden" name="payload[skill_id]" value="{{ $enrollment['skill_id'] }}">
                                    <button type="submit" class="bg-orange-500 text-white px-3 py-1 rounded text-xs hover:bg-orange-600">
                                        Unenroll
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Not enrolled in any skills yet.</p>
                        @endforelse
                    </div>
            </div>
        @endif

        <!-- Navigation -->
        <div class="mt-8 text-center">
            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700 text-sm underline">
                Back to Dashboard
            </a>
        </div>
</body>
</html>
