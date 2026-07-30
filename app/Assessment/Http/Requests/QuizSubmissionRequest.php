<?php

declare(strict_types=1);

namespace App\Assessment\Http\Requests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;

final class QuizSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() instanceof Authenticatable;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'answers' => ['required', 'array', 'min:1'],
            'answers.*.question_id' => ['required', 'integer', 'exists:questions,id'],
            'answers.*.selected_option_id' => ['required', 'integer', 'exists:options,id'],
        ];
    }

    /**
     * @return array<int, array{question_id: int, selected_option_id: int}>
     */
    public function getAnswers(): array
    {
        return $this->input('answers');
    }

    public function getStudentId(): int
    {
        return (int) $this->user()->getAuthIdentifier();
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'answers.required' => 'You must provide answers for the quiz.',
            'answers.*.question_id.required' => 'Each answer must include a question_id.',
            'answers.*.selected_option_id.required' => 'Each answer must include a selected_option_id.',
        ];
    }
}

