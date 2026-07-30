<?php

namespace App\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BugReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => strip_tags(trim((string) $this->title)),
            'description' => strip_tags(trim((string) $this->description)),
            'steps_to_reproduce' => strip_tags(trim((string) $this->steps_to_reproduce)),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:200'],
            'description' => ['required', 'string', 'min:20', 'max:5000'],
            'steps_to_reproduce' => ['nullable', 'string', 'max:3000'],
            'severity' => ['required', 'string', 'in:low,medium,high,critical'],
            'screenshot' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a title for the bug report.',
            'title.min' => 'Title must be at least 5 characters.',
            'title.max' => 'Title cannot exceed 200 characters.',
            'description.required' => 'Please describe the bug.',
            'description.min' => 'Description must be at least 20 characters.',
            'description.max' => 'Description cannot exceed 5000 characters.',
            'severity.required' => 'Please select a severity level.',
            'severity.in' => 'Severity must be one of: low, medium, high, critical.',
            'screenshot.image' => 'The screenshot must be an image file.',
            'screenshot.mimes' => 'Allowed screenshot formats: jpeg, png, jpg, gif, webp.',
            'screenshot.max' => 'Screenshot size must not exceed 5MB.',
        ];
    }
}

