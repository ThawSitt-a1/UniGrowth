<?php

declare(strict_types=1);

namespace App\Assessment\Services;

use App\Assessment\Repositories\AssessmentRepositoryInterface;
use App\Auth\Models\User;

final class StudentDashboardService
{
    public function __construct(
        private readonly AssessmentRepositoryInterface $assessmentRepository,
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
     * Fetch global leaderboard — top 10 users.
     *
     * @return array<int, array<string, mixed>>
     */
    public function fetchGlobalLeaderboard(): array
    {
        $topUsers = $this->assessmentRepository->fetchLeaderboardData();

        $leaderboard = [];
        $rank = 1;
        foreach ($topUsers as $user) {
            $leaderboard[] = [
                'rank' => $rank++,
                'user_id' => $user->id,
                'username' => $user->username,
                'platform_score' => $user->platform_score,
            ];
        }

        return $leaderboard;
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

