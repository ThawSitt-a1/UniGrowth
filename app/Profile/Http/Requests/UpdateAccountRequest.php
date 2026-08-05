<?php

namespace App\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

public function rules(): array
    {
        return [
            'action' => ['required', 'string', 'in:change_password,deactivate'],

            // Re-authentication: required for both password change and account deletion.
            'current_password' => ['required', 'string', 'current_password'],

            // Password change fields.
            'new_password' => ['nullable', 'string', Password::min(12)->uncompromised(), 'confirmed'],

            // Intent Confirmation (Intent Guard) — only for account deletion.
            'confirmation' => ['required_if:action,deactivate', 'string', 'in:DELETE'],
            'agree_irreversible' => ['required_if:action,deactivate', 'accepted'],

            // Optional feedback collection (kept brief).
            'feedback_reason' => ['nullable', 'string', 'max:50'],
            'feedback' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Please enter your current password to continue.',
            'current_password.current_password' => 'The current password is incorrect.',
            'new_password.min' => 'New password must be at least 12 characters.',
            'new_password.uncompromised' => 'This password has been exposed in a data breach. Please choose a more secure one.',
            'new_password.confirmed' => 'The password confirmation does not match.',
            'action.required' => 'Account action is required.',
            'action.in' => 'Invalid account action.',
            'confirmation.required_if' => 'Please type DELETE to confirm you want to permanently delete your account.',
            'confirmation.in' => 'Please type DELETE exactly to confirm.',
            'agree_irreversible.required_if' => 'You must acknowledge that this action is irreversible.',
            'agree_irreversible.accepted' => 'You must acknowledge that this action is irreversible.',
            'feedback_reason.max' => 'Please choose a shorter reason.',
            'feedback.max' => 'Please keep your feedback under 500 characters.',
        ];
    }
}

