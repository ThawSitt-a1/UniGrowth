@extends('admin.layout')

@section('title', 'Bug Reports')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">🐛 Bug Reports</h1>
        <p class="text-sm text-gray-500 mt-1">Review and manage user-submitted bug reports.</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        @if (count($reports) > 0)
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Subject</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Message</th>
                        <th class="px-6 py-3">Submitted</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($reports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-500">{{ $report['id'] }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium">{{ $report['user']['username'] ?? 'Unknown' }}</div>
                                <div class="text-xs text-gray-400">{{ $report['user']['email'] ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium">{{ $report['subject'] ?? '(No subject)' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs font-medium bg-gray-100">
                                    {{ $report['category'] ?? 'General' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-gray-600 truncate">{{ $report['message'] ?? '' }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{ isset($report['created_at']) ? \Carbon\Carbon::parse($report['created_at'])->format('Y-m-d H:i') : 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-8 text-center text-gray-500">
                <p class="text-lg">✅ No bug reports found.</p>
                <p class="text-sm mt-1">All clear!</p>
            </div>
        @endif
    </div>
@endsection

