<?php

declare(strict_types=1);

namespace App\Assessment\Services;

use App\Assessment\Repositories\AssessmentRepositoryInterface;

final class RankingAggregatorService
{
    /**
     * Difficulty score multipliers.
     */
    private const DIFFICULTY_MULTIPLIERS = [
        'easy' => 1.0,
        'medium' => 2.0,
        'hard' => 3.0,
    ];

    public function __construct(
        private readonly AssessmentRepositoryInterface $assessmentRepository,
    ) {
    }

    /**
     * Calculate weighted score based on difficulty multiplier.
     */
    public function calculateWeightedScore(string $difficulty, float $rawScore): float
    {
        $multiplier = self::DIFFICULTY_MULTIPLIERS[$difficulty] ?? 1.0;

        return $rawScore * $multiplier;
    }

/**
     * Update student proficiency after an attempt.
     *
     * The lifetime `platform_score` is incremented by the marks earned from
     * correct answers on this attempt, so it accumulates across seasons and
     * is never reset.
     */
    public function updateProficiencyAndPlatformScore(int $studentId, int $skillId, float $weightedScore, float $marksEarned): void
    {
        $this->assessmentRepository->upsertStudentSkillProficiency(
            $studentId,
            $skillId,
            $weightedScore,
        );

        $this->assessmentRepository->incrementUserPlatformScore($studentId, $marksEarned);
    }
}

