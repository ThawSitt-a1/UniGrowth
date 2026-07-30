<?php

declare(strict_types=1);

namespace App\Admin\Repositories;

interface ContentRepositoryInterface
{
    /**
     * Suspend a question (set is_active = false).
     */
    public function suspendQuestion(int $questionId): bool;

    /**
     * Restore a question (set is_active = true).
     */
    public function restoreQuestion(int $questionId): bool;

    /**
     * Permanently delete a question and its options.
     */
    public function deleteQuestion(int $questionId): bool;

    /**
     * Suspend a skill (set is_active = false).
     */
    public function suspendSkill(int $skillId): bool;

    /**
     * Restore a skill (set is_active = true).
     */
    public function restoreSkill(int $skillId): bool;

    /**
     * Permanently delete a skill.
     */
    public function deleteSkill(int $skillId): bool;

    /**
     * Get all suspended/flagged content for review.
     *
     * @return array<int, array<string, mixed>>
     */
    public function fetchSuspendedContent(): array;
}

