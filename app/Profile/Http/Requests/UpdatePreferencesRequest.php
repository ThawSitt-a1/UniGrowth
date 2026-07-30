<?php

namespace App\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePreferencesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

public function rules(): array
    {
        return [
            'theme' => ['nullable', 'string', 'in:light,dark'],
            'notifications_email' => ['nullable', 'boolean'],
            'notifications_browser' => ['nullable', 'boolean'],
            'language' => ['nullable', 'string', 'max:10'],
            'privacy_show_profile' => ['nullable', 'boolean'],
            'privacy_show_progress' => ['nullable', 'boolean'],
            'privacy_show_goals' => ['nullable', 'boolean'],
            'make_profile_private' => ['nullable', 'boolean'],
            'privacy_hide_leaderboards' => ['nullable', 'boolean'],
            'comm_email' => ['nullable', 'boolean'],
            'comm_telegram' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'theme.in' => 'Theme must be either light or dark.',
            'language.max' => 'Language code cannot exceed 10 characters.',
        ];
    }
}

