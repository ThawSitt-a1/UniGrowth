@extends('admin.layout')

@section('title', 'User Management')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">👥 User Management</h1>
        <p class="text-sm text-gray-500 mt-1">Manage user accounts, roles, and penalties.</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Username</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Score</th>
                    <th class="px-6 py-3">Verified</th>
                    <th class="px-6 py-3">Joined</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-500">{{ $user['id'] }}</td>
                        <td class="px-6 py-4 font-medium">{{ $user['username'] }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $user['email'] }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                {{ $user['role'] === 'admin' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $user['role'] === 'editor' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $user['role'] === 'user' ? 'bg-gray-100 text-gray-700' : '' }}">
                                {{ $user['role'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                {{ $user['account_status'] === 'allowed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $user['account_status'] === 'banned' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $user['account_status'] === 'suspended' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                                {{ $user['account_status'] }}
                                @if ($user['suspended_until'])
                                    <br><small>until {{ \Carbon\Carbon::parse($user['suspended_until'])->format('Y-m-d') }}</small>
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ number_format($user['platform_score'] ?? 0, 1) }}</td>
                        <td class="px-6 py-4">
                            @if ($user['email_verified_at'])
                                <span class="text-green-600">✅</span>
                            @else
                                <span class="text-red-400">❌</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-xs">
                            {{ \Carbon\Carbon::parse($user['created_at'])->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-2">
                                <!-- Status Change Form -->
                                <form action="{{ route('admin.users.status', $user['id']) }}" method="POST"
                                      onsubmit="return confirm('Change status to {{ $user['account_status'] === 'allowed' ? 'banned' : 'allowed' }}?')">
                                    @csrf
                                    <input type="hidden" name="status"
                                           value="{{ $user['account_status'] === 'allowed' ? 'banned' : 'allowed' }}">
                                    <button type="submit"
                                            class="text-xs px-3 py-1 rounded
                                                {{ $user['account_status'] === 'allowed' ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                        {{ $user['account_status'] === 'allowed' ? '🚫 Ban' : '✅ Restore' }}
                                    </button>
                                </form>

                                <!-- Role Change Form (only for non-admin) -->
                                @if ($user['role'] !== 'admin')
                                    <form action="{{ route('admin.users.role', $user['id']) }}" method="POST">
                                        @csrf
                                        <select name="role" onchange="this.form.submit()"
                                                class="text-xs border rounded px-2 py-1">
                                            <option value="user" {{ $user['role'] === 'user' ? 'selected' : '' }}>User</option>
                                            <option value="editor" {{ $user['role'] === 'editor' ? 'selected' : '' }}>Editor</option>
                                        </select>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-400 italic">Admin</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

