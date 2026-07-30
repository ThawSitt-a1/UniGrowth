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
            'current_password' => ['required_with:new_password', 'string', 'current_password'],
            'new_password' => ['nullable', 'string', Password::min(12)->uncompromised(), 'confirmed'],
            'action' => ['required', 'string', 'in:change_password,deactivate'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required_with' => 'Please enter your current password to set a new one.',
            'current_password.current_password' => 'The current password is incorrect.',
            'new_password.min' => 'New password must be at least 12 characters.',
            'new_password.uncompromised' => 'This password has been exposed in a data breach. Please choose a more secure one.',
            'new_password.confirmed' => 'The password confirmation does not match.',
            'action.required' => 'Account action is required.',
            'action.in' => 'Invalid account action.',
        ];
    }
}

