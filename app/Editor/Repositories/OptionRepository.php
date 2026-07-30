<?php

declare(strict_types=1);

namespace App\Editor\Repositories;

use App\Assessment\Models\Option;
use App\Editor\DTOs\QuestionOptionDTO;

final class OptionRepository implements OptionRepositoryInterface
{
    public function save(QuestionOptionDTO $data): bool
    {
        if ($data->optionId) {
            $option = Option::query()->findOrFail($data->optionId);
            if ($option->locked_by_admin) {
                return false;
            }
            $option->update([
                'question_id' => $data->questionId,
                'option_text' => $data->optionText,
                'is_correct' => $data->isCorrect,
            ]);
            return true;
        }

        Option::query()->create([
            'editor_id' => $data->editorId,
            'question_id' => $data->questionId,
            'option_text' => $data->optionText,
            'is_correct' => $data->isCorrect,
            'locked_by_admin' => false,
        ]);
        return true;
    }

    public function deleteByOwner(int $id, int $editorId): bool
    {
        $option = Option::query()
            ->where('id', $id)
            ->where('editor_id', $editorId)
            ->where('locked_by_admin', false)
            ->first();

        if (!$option) {
            return false;
        }

        return (bool) $option->delete();
    }

    public function verifyOwnership(int $id, int $editorId): bool
    {
        return Option::query()
            ->where('id', $id)
            ->where('editor_id', $editorId)
            ->exists();
    }

    public function isLockedByAdmin(int $id): bool
    {
        return Option::query()
            ->where('id', $id)
            ->where('locked_by_admin', true)
            ->exists();
    }
}
