<?php

declare(strict_types=1);

namespace App\Editor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class QuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question_id' => ['nullable', 'integer', 'exists:questions,id'],
            'skill_id' => ['required', 'integer', 'exists:skills,id'],
            'question_text' => ['required', 'string'],
            'difficulty' => ['required', 'string', 'in:easy,medium,hard'],
        ];
    }
}
