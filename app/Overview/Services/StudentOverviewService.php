<?php

declare(strict_types=1);

namespace App\Overview\Services;

use App\Auth\Models\User;
use App\Overview\DTO\StudentOverviewDTO;
use App\Overview\Repositories\StudentOverviewRepositoryInterface;
use App\Overview\Repositories\SeasonRepositoryInterface;
use App\Overview\Repositories\SeasonScoreRepositoryInterface;

final class StudentOverviewService
{
    public function __construct(
        private readonly StudentOverviewRepositoryInterface $studentOverviewRepo,
        private readonly SeasonRepositoryInterface $seasonRepo,
        private readonly SeasonScoreRepositoryInterface $seasonScoreRepo,
        private readonly SeasonService $seasonService,
    ) {
    }

    /**
     * Get the full student overview dashboard data.
     */
    public function getStudentOverview(int $studentId): StudentOverviewDTO
    {
        $user = User::query()->findOrFail($studentId);

        // Season info (refreshes highest_score = total marks of active quizzes)
        $currentSeason = $this->seasonRepo->getCurrentActiveSeason();
        $seasonInfo = $this->seasonService->getCurrentSeasonInfo();

        // Goals
        $activeGoals = $this->studentOverviewRepo->fetchActiveGoals($studentId)
            ->map(fn($g) => [
                'id' => $g->id,
                'text' => $g->text,
                'created_at' => $g->created_at?->toISOString(),
            ])
            ->toArray();

        $completedGoals = $this->studentOverviewRepo->fetchCompletedGoals($studentId)
            ->map(fn($g) => [
                'id' => $g->id,
                'text' => $g->text,
                'completed_at' => $g->completed_at?->toISOString(),
            ])
            ->toArray();

        // Enrolled skills
        $enrolledSkills = $this->studentOverviewRepo->fetchEnrolledSkills($studentId)
            ->map(fn($e) => [
                'id' => $e->id,
                'skill_id' => $e->skill_id,
                'skill_title' => $e->skill?->title ?? 'Unknown',
                'enrolled_at' => $e->enrolled_at?->toISOString(),
            ])
            ->toArray();

// Quiz statistics (season-scoped: reset to 0 when season ends, rebuild when new one starts)
        $seasonId = $currentSeason?->id;
        $quizStats = [
            'total_questions_answered' => $this->studentOverviewRepo->countTotalQuestionsAnswered($studentId, $seasonId),
            'total_attempts' => $this->studentOverviewRepo->countTotalAttempts($studentId, $seasonId),
            'total_score' => $this->studentOverviewRepo->sumTotalScore($studentId, $seasonId),
            'average_score_per_attempt' => round($this->studentOverviewRepo->averageScorePerAttempt($studentId, $seasonId), 2),
        ];

        // Season score and rank
        $totalSeasonScore = $currentSeason
            ? $this->seasonScoreRepo->getTotalScore($studentId, $currentSeason->id)
            : 0.0;

        $seasonRank = $currentSeason
            ? $this->seasonScoreRepo->getUserSeasonRank($studentId, $currentSeason->id)
            : 0;

        return new StudentOverviewDTO(
            studentId: $studentId,
            username: $user->username,
            season: $seasonInfo,
            activeGoals: $activeGoals,
            completedGoals: $completedGoals,
            enrolledSkills: $enrolledSkills,
            quizStatistics: $quizStats,
            seasonRank: $seasonRank,
            totalSeasonScore: $totalSeasonScore,
        );
    }
}
