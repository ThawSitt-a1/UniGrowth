<?php

declare(strict_types=1);

namespace App\Editor\UseCases;

use App\Editor\DTOs\QuestionDataDTO;
use App\Editor\Repositories\QuestionRepositoryInterface;
use App\Editor\Repositories\SkillRepositoryInterface;

final class ManageQuestionUseCase
{
    public function __construct(
        private readonly QuestionRepositoryInterface $questionRepository,
        private readonly SkillRepositoryInterface $skillRepository,
    ) {
    }

    public function execute(QuestionDataDTO $data): void
    {
        // Verify skill ownership
        if (!$this->skillRepository->verifyOwnership($data->skillId, $data->editorId)) {
            throw new \RuntimeException('You do not own the skill associated with this question.');
        }

        // Editors cannot create or edit questions for a suspended skill.
        if ($this->skillRepository->isSuspended($data->skillId)) {
            throw new \RuntimeException('You cannot add or edit questions for a suspended skill.');
        }

        if ($data->questionId) {
            if ($this->questionRepository->isLockedByAdmin($data->questionId)) {
                throw new \RuntimeException('This question is locked by admin and cannot be edited.');
            }
            if (!$this->questionRepository->verifyOwnership($data->questionId, $data->editorId)) {
                throw new \RuntimeException('You do not own this question.');
            }
        }

        // Validate options count based on question type
        if (!empty($data->options)) {
            $expectedCount = $data->questionType === 'true_false' ? 2 : 5;
            if (count($data->options) !== $expectedCount) {
                throw new \RuntimeException(sprintf(
                    'A %s question must have exactly %d options.',
                    str_replace('_', ' ', $data->questionType),
                    $expectedCount
                ));
            }
        }

        // Questions always publish immediately when created; "Require Content
        // Approval" only applies to skills. On edits, preserve the existing
        // active state so an approved question stays live.
        $isActive = $data->questionId ? $data->isActive : true;

        $data = new QuestionDataDTO(
            questionId: $data->questionId,
            editorId: $data->editorId,
            skillId: $data->skillId,
            questionText: $data->questionText,
            difficulty: $data->difficulty,
            questionType: $data->questionType,
            marks: $data->marks,
            options: $data->options,
            isActive: $isActive,
        );

        $saved = $this->questionRepository->save($data);
        if (!$saved) {
            throw new \RuntimeException('Failed to save question.');
        }
    }

    public function delete(int $targetId, int $editorId): void
    {
        if ($this->questionRepository->isLockedByAdmin($targetId)) {
            throw new \RuntimeException('This question is locked by admin and cannot be deleted.');
        }

        $deleted = $this->questionRepository->deleteByOwner($targetId, $editorId);
        if (!$deleted) {
            throw new \RuntimeException('Failed to delete question or you do not own it.');
        }
    }
}
