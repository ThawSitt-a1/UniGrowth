<?php

declare(strict_types=1);

namespace App\Editor\UseCases;

use App\Admin\Services\SystemSettingsServiceInterface;
use App\Editor\DTOs\SkillDataDTO;
use App\Editor\Repositories\SkillRepositoryInterface;

final class ManageSkillUseCase
{
    public function __construct(
        private readonly SkillRepositoryInterface $skillRepository,
        private readonly SystemSettingsServiceInterface $systemSettings,
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

        // When "Require Content Approval" is enabled, newly created skills are
        // auto-suspended until an admin approves them via the content moderation
        // console. On edits, preserve the existing active state.
        $isActive = $data->skillId ? $data->isActive : ! $this->systemSettings->isContentApprovalRequired();

        $data = new SkillDataDTO(
            skillId: $data->skillId,
            editorId: $data->editorId,
            title: $data->title,
            slug: $data->slug,
            description: $data->description,
            tags: $data->tags,
            content: $data->content,
            resourceLink: $data->resourceLink,
            resourceLinks: $data->resourceLinks,
            isActive: $isActive,
        );

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
