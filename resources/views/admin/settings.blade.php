@extends('admin.layout')

@section('title', 'System Settings')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">🔧 System Settings</h1>
        <p class="text-sm text-gray-500 mt-1">Modify global platform configuration.</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Configuration Parameters</h2>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Setting Key</th>
                    <th class="px-6 py-3">Current Value</th>
                    <th class="px-6 py-3">Update</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($settings as $key => $value)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono text-sm font-medium text-gray-800">{{ $key }}</td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm
                                {{ $value === 'true' || $value === 'false' ? ($value === 'true' ? 'text-green-600' : 'text-red-600') : 'text-gray-600' }}">
                                {{ $value ?? '(empty)' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.settings.update') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="hidden" name="setting_key" value="{{ $key }}">
                                @if (in_array($key, ['maintenance_mode', 'notifications_enabled', 'content_approval_required', 'allow_user_registration', 'require_email_verification']))
                                    <select name="setting_value" class="border rounded px-2 py-1 text-sm" onchange="this.form.submit()">
                                        <option value="true" {{ $value === 'true' ? 'selected' : '' }}>Enabled</option>
                                        <option value="false" {{ $value === 'false' ? 'selected' : '' }}>Disabled</option>
                                    </select>
                                @else
                                    <input type="text" name="setting_value" value="{{ $value ?? '' }}"
                                           class="border rounded px-2 py-1 text-sm flex-1">
                                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">
                                        Save
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded p-4 text-yellow-700 text-sm">
        <strong>⚠️ Note:</strong> Changes take effect immediately. Some settings like <code>maintenance_mode</code> may require middleware integration.
    </div>
@endsection

