<?php

namespace App\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestResetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'An email address is required.',
            'email.email' => 'Please enter a valid email format.',
            'email.exists' => 'This email does not exist in our records.',
        ];
    }
}

