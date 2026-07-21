<?php

namespace App\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'required|string',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'token.required' => 'The reset token is required.',
            'email.required' => 'An email address is required.',
            'email.email' => 'Please enter a valid email format.',
            'email.exists' => 'This email does not exist in our records.',
            'password.required' => 'A new password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}

