<?php

namespace App\Auth\Http\Requests;

use App\Auth\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            // Removes HTML/Script tags to prevent XSS
            'username' => strip_tags(trim((string) $this->username)),

            // Normalize for consistent database lookups
            'email' => Str::lower(trim((string) $this->email)),
            'remember' => $this->has('remember'),
        ]);
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string',
                          'max:50' , 'unique:users,username',
                          'regex:/^[a-zA-Z0-9._-]+$/'],
            'email' => ['required', 'string', 'email',
                        'max:254', 'unique:users,email'],
            'password' => ['required','string',
                            Password::min(12)
                            ->uncompromised(),],  // Have I been pwned check],
            'g-recaptcha-response' => ['required', new Recaptcha()],
            'remember' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            // Username messages
            'username.required' => 'A username is required.',
            'username.max'      => 'The username cannot exceed 50 characters.',
            'username.unique'   => 'This username is already taken.',

            // Email messages
            'email.required'    => 'An email address is required.',
            'email.email'       => 'Please enter a valid email format.',
            'email.max'         => 'The email address is too long.',
            'email.unique'      => 'This email is already registered.',

            // Password messages
            'password.required' => 'A password is required.',
            'password.min'      => 'Your password is too short. It must be at least 12 characters long.',
            'password.uncompromised' => 'The password you entered has been exposed in a data breach. Please choose a more secure, unique password.',

            // Recaptcha messages
            'g-recaptcha-response.required' => 'Please complete the verification.',
            'g-recaptcha-response'          => 'Invalid verification. Please try again.',
        ];
    }
}

