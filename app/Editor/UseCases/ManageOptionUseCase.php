<?php

declare(strict_types=1);

namespace App\Editor\UseCases;

use App\Editor\DTOs\QuestionOptionDTO;
use App\Editor\Repositories\OptionRepositoryInterface;
use App\Editor\Repositories\QuestionRepositoryInterface;

final class ManageOptionUseCase
{
    public function __construct(
        private readonly OptionRepositoryInterface $optionRepository,
        private readonly QuestionRepositoryInterface $questionRepository,
    ) {
    }

    public function execute(QuestionOptionDTO $data): void
    {
        // Verify question ownership
        if (!$this->questionRepository->verifyOwnership($data->questionId, $data->editorId)) {
            throw new \RuntimeException('You do not own the question associated with this option.');
        }

        if ($data->optionId) {
            if ($this->optionRepository->isLockedByAdmin($data->optionId)) {
                throw new \RuntimeException('This option is locked by admin and cannot be edited.');
            }
            if (!$this->optionRepository->verifyOwnership($data->optionId, $data->editorId)) {
                throw new \RuntimeException('You do not own this option.');
            }
        }

        $saved = $this->optionRepository->save($data);
        if (!$saved) {
            throw new \RuntimeException('Failed to save option.');
        }
    }

    public function delete(int $targetId, int $editorId): void
    {
        if ($this->optionRepository->isLockedByAdmin($targetId)) {
            throw new \RuntimeException('This option is locked by admin and cannot be deleted.');
        }

        $deleted = $this->optionRepository->deleteByOwner($targetId, $editorId);
        if (!$deleted) {
            throw new \RuntimeException('Failed to delete option or you do not own it.');
        }
    }
}
