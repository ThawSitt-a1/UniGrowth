<?php

declare(strict_types=1);

namespace App\Editor\Repositories;

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
                'difficulty' => $data->difficulty,
            ]);
            return true;
        }

        Question::query()->create([
            'editor_id' => $data->editorId,
            'skill_id' => $data->skillId,
            'question_text' => $data->questionText,
            'difficulty' => $data->difficulty,
            'is_active' => true,
            'locked_by_admin' => false,
        ]);
        return true;
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
