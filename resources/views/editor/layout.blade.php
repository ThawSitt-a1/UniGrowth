<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor Console — UniGrowth</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen">
        <nav class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('editor.dashboard') }}" class="text-xl font-bold text-indigo-600">UniGrowth Editor</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('editor.dashboard') }}" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                        <a href="{{ route('editor.skills.create') }}" class="text-gray-700 hover:text-indigo-600">New Skill</a>
                        <a href="{{ route('editor.questions.create') }}" class="text-gray-700 hover:text-indigo-600">New Question</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-red-600">Logout</button>
                        </form>
                    </div>
            </div>
        </nav>

        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
