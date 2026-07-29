<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Console') - UniGrowth Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0">
            <div class="p-6 border-b border-gray-700">
                <h1 class="text-xl font-bold">⚙️ Admin Panel</h1>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                    <span>📊</span> Dashboard
                </a>
                <a href="{{ route('admin.users') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.users') ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                    <span>👥</span> Users
                </a>
                <a href="{{ route('admin.content') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.content') ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                    <span>📋</span> Content
                </a>
                <a href="{{ route('admin.bug-reports') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.bug-reports') ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                    <span>🐛</span> Bug Reports
                </a>
                <a href="{{ route('admin.settings') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.settings') ? 'bg-blue-600' : 'hover:bg-gray-800' }}">
                    <span>🔧</span> Settings
                </a>
                <hr class="border-gray-700 my-4">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800">
                    <span>🏠</span> Main Dashboard
                </a>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-700 text-red-300">
                        <span>🚪</span> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8">
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

            @yield('content')
        </main>
    </div>
</body>
</html>

