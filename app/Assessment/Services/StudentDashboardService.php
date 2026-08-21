<?php

declare(strict_types=1);

namespace App\Assessment\Services;

use App\Assessment\Repositories\AssessmentRepositoryInterface;
use App\Auth\Models\User;
use App\Overview\Services\SeasonService;

final class StudentDashboardService
{
    public function __construct(
        private readonly AssessmentRepositoryInterface $assessmentRepository,
        private readonly SeasonService $seasonService,
    ) {
    }

    /**
     * Aggregate progress metrics for a student.
     *
     * @return array<string, mixed>
     */
    public function aggregateProgressMetrics(int $studentId): array
    {
        $user = User::query()->findOrFail($studentId);
        $stats = $this->assessmentRepository->fetchDashboardStats($studentId);
        $studentSkills = $this->assessmentRepository->fetchStudentSkills($studentId);

        $skillProgress = [];
        foreach ($studentSkills as $studentSkill) {
            $skillProgress[] = [
                'skill_id' => $studentSkill->skill_id,
                'skill_title' => $studentSkill->skill->title ?? 'Unknown',
                'proficiency_score' => $studentSkill->proficiency_score,
                'attempts_count' => $studentSkill->attempts_count,
                'last_attempted_at' => $studentSkill->last_attempted_at?->toISOString(),
            ];
        }

        // Compute current user rank
        $rank = $this->computeUserRank($studentId);

        return [
            'student_id' => $studentId,
            'username' => $user->username,
            'platform_score' => $user->platform_score,
            'rank' => $rank,
            'stats' => $stats,
            'skill_progress' => $skillProgress,
        ];
    }

    /**
     * Fetch seasonal leaderboard — top 10 users for the current active season.
     *
     * @return array<int, array<string, mixed>>
     */
    public function fetchGlobalLeaderboard(): array
    {
        $currentSeason = $this->seasonService->getCurrentSeason();

        if (!$currentSeason) {
            return [];
        }

        return $this->seasonService->getSeasonLeaderboard($currentSeason->id, 10);
    }

    /**
     * Compute a user's rank among all users by platform_score.
     */
    private function computeUserRank(int $userId): int
    {
        $user = User::query()->findOrFail($userId);

        if ($user->platform_score <= 0) {
            return 0;
        }

        $rank = User::query()
            ->where('platform_score', '>', $user->platform_score)
            ->count();

        return $rank + 1;
    }
}

