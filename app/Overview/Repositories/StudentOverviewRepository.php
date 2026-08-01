<?php

declare(strict_types=1);

namespace App\Overview\Repositories;

use App\Auth\Models\User;
use App\Core\Assets\Models\Goal;
use App\Core\Assets\Models\Enrollment;
use App\Assessment\Models\StudentAnsweredQuestion;
use App\Assessment\Models\Attempt;
use App\Overview\Models\SeasonScore;
use Illuminate\Support\Collection;

final class StudentOverviewRepository implements StudentOverviewRepositoryInterface
{
    public function fetchActiveGoals(int $userId): Collection
    {
        return Goal::query()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function fetchCompletedGoals(int $userId): Collection
    {
        return Goal::query()
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->orderBy('completed_at', 'desc')
            ->get();
    }

    public function countActiveGoals(int $userId): int
    {
        return Goal::query()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->count();
    }

    public function countCompletedGoals(int $userId): int
    {
        return Goal::query()
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->count();
    }

    public function fetchEnrolledSkills(int $userId): Collection
    {
        return Enrollment::query()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->with('skill')
            ->orderBy('enrolled_at', 'desc')
            ->get();
    }

    public function countEnrolledSkills(int $userId): int
    {
        return Enrollment::query()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->count();
    }

    public function countTotalQuestionsAnswered(int $userId, ?int $seasonId = null): int
    {
        if ($seasonId !== null) {
            $record = SeasonScore::query()
                ->where('user_id', $userId)
                ->where('season_id', $seasonId)
                ->first();

            return (int) ($record?->total_questions_answered ?? 0);
        }

        return StudentAnsweredQuestion::query()
            ->where('user_id', $userId)
            ->count();
    }

    public function countTotalAttempts(int $userId, ?int $seasonId = null): int
    {
        if ($seasonId !== null) {
            $record = SeasonScore::query()
                ->where('user_id', $userId)
                ->where('season_id', $seasonId)
                ->first();

            return (int) ($record?->total_attempts ?? 0);
        }

        return Attempt::query()
            ->where('user_id', $userId)
            ->count();
    }

    public function sumTotalScore(int $userId, ?int $seasonId = null): float
    {
        if ($seasonId !== null) {
            $record = SeasonScore::query()
                ->where('user_id', $userId)
                ->where('season_id', $seasonId)
                ->first();

            return (float) ($record?->total_score ?? 0.0);
        }

        return (float) Attempt::query()
            ->where('user_id', $userId)
            ->sum('score');
    }

    public function averageScorePerAttempt(int $userId, ?int $seasonId = null): float
    {
        if ($seasonId !== null) {
            $record = SeasonScore::query()
                ->where('user_id', $userId)
                ->where('season_id', $seasonId)
                ->first();

            if (!$record || $record->total_attempts <= 0) {
                return 0.0;
            }

            // Average percentage = (total_score / total_attempts) as a percentage of highest_score
            // But attempts don't have a per-attempt percentage stored in season_scores,
            // so we compute average score-per-attempt instead
            return round($record->total_score / $record->total_attempts, 2);
        }

        return (float) (Attempt::query()
            ->where('user_id', $userId)
            ->avg('percentage') ?? 0.0);
    }
}

