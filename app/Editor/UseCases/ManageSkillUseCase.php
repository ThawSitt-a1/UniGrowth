<?php

declare(strict_types=1);

namespace App\Editor\UseCases;

use App\Editor\DTOs\SkillDataDTO;
use App\Editor\Repositories\SkillRepositoryInterface;

final class ManageSkillUseCase
{
    public function __construct(
        private readonly SkillRepositoryInterface $skillRepository,
    ) {
    }

    public function execute(SkillDataDTO $data): void
    {
        if ($data->skillId) {
            if ($this->skillRepository->isLockedByAdmin($data->skillId)) {
                throw new \RuntimeException('This skill is locked by admin and cannot be edited.');
            }
            if (!$this->skillRepository->verifyOwnership($data->skillId, $data->editorId)) {
                throw new \RuntimeException('You do not own this skill.');
            }
        }

        $saved = $this->skillRepository->save($data);
        if (!$saved) {
            throw new \RuntimeException('Failed to save skill.');
        }
    }

    public function delete(int $targetId, int $editorId): void
    {
        if ($this->skillRepository->isLockedByAdmin($targetId)) {
            throw new \RuntimeException('This skill is locked by admin and cannot be deleted.');
        }

        $deleted = $this->skillRepository->deleteByOwner($targetId, $editorId);
        if (!$deleted) {
            throw new \RuntimeException('Failed to delete skill or you do not own it.');
        }
    }
}
