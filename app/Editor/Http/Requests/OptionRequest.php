<?php

declare(strict_types=1);

namespace App\Editor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class OptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'option_id' => ['nullable', 'integer', 'exists:options,id'],
            'question_id' => ['required', 'integer', 'exists:questions,id'],
            'option_text' => ['required', 'string', 'max:500'],
            'is_correct' => ['required', 'boolean'],
        ];
    }
}
