<?php

namespace App\Auth\Http\Requests;

use App\Auth\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

final class LoginRequest extends FormRequest
{
    /**
     * Sanitization layer: Clean data before validation to prevent XSS/Injection.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            // Normalize for consistent database lookups
            'email' => Str::lower(trim((string) $this->email)),
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    //Validation layer
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email',
                        'max:254', 'exists:users,email'],
            'password' => ['required', 'string'],
            'g-recaptcha-response' => ['required', new Recaptcha()],
        ];
    }

    public function messages(): array
    {
        return [
            // Email messages
            'email.required'    => 'An email address is required.',
            'email.email'       => 'Please enter a valid email format.',
            'email.max'         => 'The email address is too long.',
            'email.exists'      => 'Invalid credentials.',

            // Password messages
            'password.required' => 'A password is required.',

            // Recaptcha messages
            'g-recaptcha-response.required' => 'Please complete the verification.',
            'g-recaptcha-response'          => 'Invalid verification. Please try again.',
        ];
    }
}
