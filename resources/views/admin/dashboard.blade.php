@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">📊 Platform Metrics</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.dashboard', ['time_frame' => '7d']) }}"
                   class="px-3 py-1 rounded text-sm {{ $timeFrame === '7d' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border hover:bg-gray-50' }}">
                    Last 7 days
                </a>
                <a href="{{ route('admin.dashboard', ['time_frame' => '30d']) }}"
                   class="px-3 py-1 rounded text-sm {{ $timeFrame === '30d' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border hover:bg-gray-50' }}">
                    Last 30 days
                </a>
                <a href="{{ route('admin.dashboard', ['time_frame' => 'all']) }}"
                   class="px-3 py-1 rounded text-sm {{ $timeFrame === 'all' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border hover:bg-gray-50' }}">
                    All Time
                </a>
            </div>
        </div>
    </div>

    <!-- Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Registered Users</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($metrics['total_registered_users'] ?? 0) }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <span class="text-2xl">👥</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Active Users</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($metrics['active_users'] ?? 0) }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <span class="text-2xl">✅</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Banned / Suspended</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($metrics['total_banned_users'] ?? 0) }}</p>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <span class="text-2xl">🚫</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Skills</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($metrics['total_skills'] ?? 0) }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <span class="text-2xl">📚</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recorded At -->
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-sm text-gray-500">
            Last updated: {{ $metrics['recorded_at'] ?? 'N/A' }}
        </p>
        <p class="text-xs text-gray-400 mt-1">
            Metrics are computed from existing database tables. Time frame: <strong>{{ $timeFrame }}</strong>
        </p>
    </div>
@endsection

