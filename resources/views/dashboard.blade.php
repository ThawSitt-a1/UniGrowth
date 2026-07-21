<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-md mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

        <!-- Status / Success Messages -->
        @if (session('status'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span class="text-sm">{{ session('status') }}</span>
            </div>
        @endif

        <!-- Email Verification Notice -->
        @if (!auth()->user()->hasVerifiedEmail())
            <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                <p class="text-sm font-semibold">Your email is not yet verified.</p>
                <p class="text-sm mt-1">Please check your inbox for the verification link.</p>
                <form action="{{ route('verification.send') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 underline">
                        Resend verification email
                    </button>
                </form>
            </div>
        @else
            <p class="text-green-600 font-semibold">
                Success! You are logged in and your email is verified.
            </p>
        @endif

        <form action="/logout" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="text-red-500 underline">Logout</button>
        </form>
    </div>
</body>
</html>
