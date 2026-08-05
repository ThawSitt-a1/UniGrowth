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
                        'max:254', 'unique:users,email',
                        'regex:/^(?!.*admin)/i'],
            'password' => ['required','string',
                            Password::min(12)
                            ->uncompromised(),],  // Have I been pwned check],
            'g-recaptcha-response' => ['required', new Recaptcha()],
            'remember' => ['boolean'],
            // Core biographical data
            'academic_year' => ['required', 'string', 'max:50'],
            'major' => ['required', 'string', 'max:100'],
            'university_name' => ['required', 'string', 'max:150'],
            // Terms of Service agreement
            'agreed_to_terms' => ['required', 'accepted'],
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
            'email.regex'       => 'The email address cannot contain the word "admin".',

            // Password messages
            'password.required' => 'A password is required.',
            'password.min'      => 'Your password is too short. It must be at least 12 characters long.',
            'password.uncompromised' => 'The password you entered has been exposed in a data breach. Please choose a more secure, unique password.',

            // Recaptcha messages
            'g-recaptcha-response.required' => 'Please complete the verification.',
            'g-recaptcha-response'          => 'Invalid verification. Please try again.',

            // Biographical data messages
            'academic_year.required' => 'Please select your academic year.',
            'academic_year.max'      => 'Academic year cannot exceed 50 characters.',
            'major.required'         => 'Please enter your major/field of study.',
            'major.max'              => 'Major cannot exceed 100 characters.',
'university_name.required' => 'Please enter your university name.',
            'university_name.max'    => 'University name cannot exceed 150 characters.',

            // Terms of Service messages
            'agreed_to_terms.required' => 'You must agree to the Terms of Service and Privacy Policy.',
            'agreed_to_terms.accepted' => 'You must agree to the Terms of Service and Privacy Policy.',
        ];
    }
}

