<?php

declare(strict_types=1);

namespace App\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ContentActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

/**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'target_id' => ['required', 'integer', 'min:1'],
            'target_type' => ['required', 'string', 'in:QUESTION,SKILL'],
            'action' => ['required', 'string', 'in:SUSPEND,RESTORE,DELETE'],
            'reason' => [
                'nullable',
                'string',
                'max:1000',
                function ($attribute, $value, $fail) {
                    if ($this->input('action') === 'SUSPEND' && empty(trim((string) $value))) {
                        $fail('A reason is required when suspending content. Please explain why this content is being suspended.');
                    }
                },
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'reason.required' => 'A reason is required when suspending content. Please explain why this content is being suspended.',
        ];
    }
}

