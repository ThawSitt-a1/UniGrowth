<?php

declare(strict_types=1);

namespace App\Admin\UseCases;

use App\Admin\DTOs\ContentActionDTO;
use App\Admin\Repositories\ContentRepositoryInterface;
use InvalidArgumentException;

final class ManageContentUseCase
{
    public function __construct(
        private readonly ContentRepositoryInterface $contentRepository,
    ) {
    }

    /**
     * Execute content moderation actions.
     */
    public function execute(ContentActionDTO $action): void
    {
        $actionStr = strtoupper($action->action);
        $typeStr = strtoupper($action->targetType);

        switch ($typeStr) {
            case 'QUESTION':
                $this->handleQuestionAction($action->targetId, $actionStr);
                break;

            case 'SKILL':
                $this->handleSkillAction($action->targetId, $actionStr);
                break;

            default:
                throw new InvalidArgumentException("Unknown target type: {$typeStr}");
        }
    }

    private function handleQuestionAction(int $questionId, string $action): void
    {
        match ($action) {
            'SUSPEND' => $this->contentRepository->suspendQuestion($questionId),
            'RESTORE' => $this->contentRepository->restoreQuestion($questionId),
            'DELETE' => $this->contentRepository->deleteQuestion($questionId),
            default => throw new InvalidArgumentException("Unknown action: {$action} for question"),
        };
    }

    private function handleSkillAction(int $skillId, string $action): void
    {
        match ($action) {
            'SUSPEND' => $this->contentRepository->suspendSkill($skillId),
            'RESTORE' => $this->contentRepository->restoreSkill($skillId),
            'DELETE' => $this->contentRepository->deleteSkill($skillId),
            default => throw new InvalidArgumentException("Unknown action: {$action} for skill"),
        };
    }

    /**
     * Get all suspended content for review.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getSuspendedContent(): array
    {
        return $this->contentRepository->fetchSuspendedContent();
    }

    /**
     * Get all editor-created content (skills) with editor info.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAllEditorContent(): array
    {
        return $this->contentRepository->fetchAllEditorContent();
    }

    /**
     * Add an admin comment to a skill.
     */
    public function addSkillComment(int $skillId, string $comment): bool
    {
        return $this->contentRepository->addSkillAdminComment($skillId, $comment);
    }
}

