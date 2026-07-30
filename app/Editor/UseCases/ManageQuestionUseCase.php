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

        if ($data->questionId) {
            if ($this->questionRepository->isLockedByAdmin($data->questionId)) {
                throw new \RuntimeException('This question is locked by admin and cannot be edited.');
            }
            if (!$this->questionRepository->verifyOwnership($data->questionId, $data->editorId)) {
                throw new \RuntimeException('You do not own this question.');
            }
        }

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
