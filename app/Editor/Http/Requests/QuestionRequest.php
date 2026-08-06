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
            'question_type' => ['required', 'string', 'in:multiple_choice,true_false'],
            'marks' => ['required', 'numeric', 'min:0', 'max:100'],
            'options' => ['nullable', 'array'],
            'options.*.option_text' => ['nullable', 'string', 'max:500'],
            'options.*.is_correct' => ['nullable', 'boolean'],
            'options.*.option_id' => ['nullable', 'integer', 'exists:options,id'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $rawOptions = $this->input('options', []);
            $questionType = $this->input('question_type', 'multiple_choice');
            $questionId = $this->input('question_id');

            // Filter out empty option rows so blank/hidden rows don't count,
            // matching the behaviour in EditorConsoleController::saveQuestion.
            $options = [];
            foreach ($rawOptions as $opt) {
                if (!empty(trim((string) ($opt['option_text'] ?? '')))) {
                    $options[] = $opt;
                }
            }

            if (empty($options)) {
                $validator->errors()->add('options', 'Options are required.');
                return;
            }

            // Count correct answers
            $correctCount = 0;
            foreach ($options as $opt) {
                if (!empty($opt['is_correct'])) {
                    $correctCount++;
                }
            }

            if ($correctCount === 0) {
                $validator->errors()->add('options', 'You must mark exactly one option as correct.');
            } elseif ($correctCount > 1) {
                $validator->errors()->add('options', 'You can only mark one option as correct.');
            }

            // Validate option count by type
            $expectedCount = $questionType === 'true_false' ? 2 : 5;
            if (count($options) !== $expectedCount) {
                $validator->errors()->add('options', sprintf(
                    'A %s question must have exactly %d options.',
                    str_replace('_', ' ', $questionType),
                    $expectedCount
                ));
            }
        });
    }
}

