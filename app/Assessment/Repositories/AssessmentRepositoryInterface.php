<?php

declare(strict_types=1);

namespace App\Assessment\Repositories;

use App\Assessment\Models\Attempt;
use App\Auth\Models\User;
use Illuminate\Support\Collection;

interface AssessmentRepositoryInterface
{
    /**
     * Fetch randomized active questions for a skill that the user has NOT answered before.
     * Returns up to 5 questions, but allows as few as 1 question to be available.
     *
     * @return Collection<int, \App\Assessment\Models\Question>
     *
     * @throws \RuntimeException if no unseen questions are available for the skill.
     */
    public function fetchUnseenActiveQuestionsForSkill(int $userId, int $skillId): Collection;

    /**
     * Fetch correct option IDs for the given question IDs.
     *
     * @param int[] $questionIds
     * @return array<int, array<int, int>>  [question_id => [correct_option_id, ...]]
     */
    public function fetchCorrectOptions(array $questionIds): array;

    /**
     * Create an attempt and log answered questions within a transaction.
     *
     * @param array{
     *     user_id: int,
     *     skill_id: int,
     *     score: float,
     *     max_score: float,
     *     percentage: float,
     *     passed: bool,
     * } $attemptData
     * @param array<int, int> $answeredQuestionIds  [question_id => selected_option_id]
     */
    public function logAttemptAndAnsweredQuestions(
        int $userId,
        array $attemptData,
        array $answeredQuestionIds,
    ): Attempt;

    /**
     * Upsert student skill proficiency record.
     */
    public function upsertStudentSkillProficiency(int $userId, int $skillId, float $score): void;

/**
     * Update user's total platform score (sum of all skill proficiencies).
     */
    public function updateUserPlatformScore(int $userId): void;

    /**
     * Increment a user's lifetime platform_score by the given marks earned.
     *
     * The lifetime score is the total marks earned from correct quiz answers
     * since day one and is never reset (unless the user is deleted).
     */
    public function incrementUserPlatformScore(int $userId, float $marks): void;

    /**
     * Fetch leaderboard data — top 10 users by platform_score.
     *
     * @return Collection<int, User>
     */
    public function fetchLeaderboardData(): Collection;

    /**
     * Fetch dashboard aggregate stats for a user.
     *
     * @return array{total_skills: int, total_attempts: int, average_score: float, total_questions_answered: int}
     */
    public function fetchDashboardStats(int $userId): array;

    /**
     * Fetch all skill proficiency records for a user.
     *
     * @return Collection<int, \App\Assessment\Models\StudentSkill>
     */
    public function fetchStudentSkills(int $userId): Collection;
}

