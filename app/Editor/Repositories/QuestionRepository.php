<?php

declare(strict_types=1);

namespace App\Editor\Repositories;

use App\Assessment\Models\Option;
use App\Assessment\Models\Question;
use App\Editor\DTOs\QuestionDataDTO;

final class QuestionRepository implements QuestionRepositoryInterface
{
    public function save(QuestionDataDTO $data): bool
    {
        if ($data->questionId) {
            $question = Question::query()->findOrFail($data->questionId);
            if ($question->locked_by_admin) {
                return false;
            }
            $question->update([
                'skill_id' => $data->skillId,
                'question_text' => $data->questionText,
                'question_type' => $data->questionType,
                'difficulty' => $data->difficulty,
                'marks' => $data->marks,
            ]);
        } else {
            $question = Question::query()->create([
                'editor_id' => $data->editorId,
                'skill_id' => $data->skillId,
                'question_text' => $data->questionText,
                'question_type' => $data->questionType,
                'difficulty' => $data->difficulty,
                'marks' => $data->marks,
                'is_active' => true,
                'locked_by_admin' => false,
            ]);
        }

        // Sync options if provided
        if (!empty($data->options)) {
            $this->syncOptions($question, $data);
        }

        return true;
    }

    /**
     * @param Question $question
     * @param QuestionDataDTO $data
     */
    private function syncOptions(Question $question, QuestionDataDTO $data): void
    {
        $existingOptionIds = $question->options()->pluck('id')->toArray();
        $submittedOptionIds = [];
        $maxOptions = $data->questionType === 'true_false' ? 2 : 5;

        // First, unset all correct options for this question
        Option::query()->where('question_id', $question->id)->where('is_correct', true)->update(['is_correct' => false]);

        foreach (array_slice($data->options, 0, $maxOptions) as $opt) {
            $optionId = $opt['option_id'] ?? null;
            $isCorrect = !empty($opt['is_correct']);

            if ($optionId && in_array($optionId, $existingOptionIds)) {
                // Update existing option
                Option::query()->where('id', $optionId)->update([
                    'option_text' => $opt['option_text'],
                    'is_correct' => $isCorrect,
                ]);
                $submittedOptionIds[] = $optionId;
            } else {
                // Create new option
                $newOption = Option::query()->create([
                    'editor_id' => $data->editorId,
                    'question_id' => $question->id,
                    'option_text' => $opt['option_text'],
                    'is_correct' => $isCorrect,
                    'locked_by_admin' => false,
                ]);
                $submittedOptionIds[] = $newOption->id;
            }
        }

        // Delete options that were removed
        $toDelete = array_diff($existingOptionIds, $submittedOptionIds);
        if (!empty($toDelete)) {
            Option::query()->whereIn('id', $toDelete)->where('locked_by_admin', false)->delete();
        }
    }

    public function deleteByOwner(int $id, int $editorId): bool
    {
        $question = Question::query()
            ->where('id', $id)
            ->where('editor_id', $editorId)
            ->where('locked_by_admin', false)
            ->first();

        if (!$question) {
            return false;
        }

        return (bool) $question->delete();
    }

    public function verifyOwnership(int $id, int $editorId): bool
    {
        return Question::query()
            ->where('id', $id)
            ->where('editor_id', $editorId)
            ->exists();
    }

    public function isLockedByAdmin(int $id): bool
    {
        return Question::query()
            ->where('id', $id)
            ->where('locked_by_admin', true)
            ->exists();
    }
}
