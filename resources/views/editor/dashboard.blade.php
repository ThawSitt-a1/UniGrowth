@extends('editor.layout')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Editor Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <a href="{{ route('editor.skills.create') }}" class="block p-4 bg-indigo-50 rounded-lg border border-indigo-200 hover:bg-indigo-100">
            <h3 class="font-semibold text-indigo-700">Create Skill</h3>
            <p class="text-sm text-gray-600">Add a new skill for assessment</p>
        </a>
        <a href="{{ route('editor.questions.create') }}" class="block p-4 bg-green-50 rounded-lg border border-green-200 hover:bg-green-100">
            <h3 class="font-semibold text-green-700">Create Question</h3>
            <p class="text-sm text-gray-600">Add questions to skills</p>
        </a>
        <a href="{{ route('editor.questions.create') }}" class="block p-4 bg-blue-50 rounded-lg border border-blue-200 hover:bg-blue-100">
            <h3 class="font-semibold text-blue-700">Manage Options</h3>
            <p class="text-sm text-gray-600">Add options to questions</p>
        </a>
    </div>

    <h2 class="text-xl font-semibold mb-4">Your Content</h2>

    @if (count($content['data'] ?? []) > 0)
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Question</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skill</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Difficulty</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Locked</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
