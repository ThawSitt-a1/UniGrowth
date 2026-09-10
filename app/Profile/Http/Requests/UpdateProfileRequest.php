<?php

namespace App\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => strip_tags(trim((string) $this->username)),
            'academic_year' => strip_tags(trim((string) $this->academic_year)),
            'major' => strip_tags(trim((string) $this->major)),
            'university_name' => strip_tags(trim((string) $this->university_name)),
        ]);
    }

    public function rules(): array
    {
        return [
            'username' => ['nullable', 'string', 'max:50', 'regex:/^[a-zA-Z0-9._\s-]+$/'],
            'academic_year' => ['nullable', 'string', 'max:50'],
            'major' => ['nullable', 'string', 'max:100'],
            'university_name' => ['nullable', 'string', 'max:150'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.regex' => 'The username may only contain letters, numbers, spaces, dots, underscores, and hyphens.',
            'username.max' => 'Username cannot exceed 50 characters.',
            'academic_year.max' => 'Academic year cannot exceed 50 characters.',
            'major.max' => 'Major cannot exceed 100 characters.',
            'university_name.max' => 'University name cannot exceed 150 characters.',
        ];
    }
}
