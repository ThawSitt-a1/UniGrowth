@extends('admin.layout')

@section('title', 'Content Moderation')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">📋 Content Moderation</h1>
        <p class="text-sm text-gray-500 mt-1">Manage skills and questions. Suspending hides content from users but preserves it for admin review.</p>
    </div>

    <!-- Content Action Form -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Execute Action</h2>
        <form action="{{ route('admin.content.action') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select name="target_type" class="w-full border rounded px-3 py-2 text-sm" required>
                    <option value="QUESTION">Question</option>
                    <option value="SKILL">Skill</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Target ID</label>
                <input type="number" name="target_id" min="1" class="w-full border rounded px-3 py-2 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Action</label>
                <select name="action" class="w-full border rounded px-3 py-2 text-sm" required>
                    <option value="SUSPEND">Suspend (Hide)</option>
                    <option value="RESTORE">Restore (Show)</option>
                    <option value="DELETE">Delete (Permanent)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                <input type="text" name="reason" maxlength="1000" class="w-full border rounded px-3 py-2 text-sm" placeholder="Optional reason...">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 w-full">
                    Execute
                </button>
            </div>
        </form>
    </div>

    <!-- Suspended Content List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Suspended Content ({{ count($suspendedContent) }})</h2>
        </div>

        @if (count($suspendedContent) > 0)
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Type</th>
                        <th class="px-6 py-3">Title</th>
                        <th class="px-6 py-3">Related To</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($suspendedContent as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-500">{{ $item['id'] }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs font-medium
                                    {{ $item['type'] === 'QUESTION' ? 'bg-yellow-100 text-yellow-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ $item['type'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium">{{ $item['title'] }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $item['skill'] }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-700">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{ \Carbon\Carbon::parse($item['created_at'])->format('Y-m-d') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-8 text-center text-gray-500">
                <p class="text-lg">✅ No suspended content.</p>
                <p class="text-sm mt-1">All skills and questions are currently active.</p>
            </div>
        @endif
    </div>
@endsection

