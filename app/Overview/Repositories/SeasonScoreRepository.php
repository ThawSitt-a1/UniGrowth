<?php

declare(strict_types=1);

namespace App\Overview\Repositories;

use App\Auth\Models\User;
use App\Overview\Models\SeasonScore;
use App\Overview\Models\SeasonScoreSnapshot;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class SeasonScoreRepository implements SeasonScoreRepositoryInterface
{
public function upsertScore(int $userId, int $seasonId, float $score, int $questionsAnswered): void
    {
        $record = SeasonScore::query()->firstOrNew([
            'user_id' => $userId,
            'season_id' => $seasonId,
        ]);

        $record->total_score = $record->total_score + $score;
        $record->skill_count = SeasonScore::query()
            ->where('user_id', $userId)
            ->where('season_id', $seasonId)
            ->count();
        $record->total_questions_answered = $record->total_questions_answered + $questionsAnswered;
        $record->total_attempts = $record->total_attempts + 1;
        $record->last_active_at = now();
        $record->save();
    }

    public function getTotalScore(int $userId, int $seasonId): float
    {
        $record = SeasonScore::query()
            ->where('user_id', $userId)
            ->where('season_id', $seasonId)
            ->first();

        return $record?->total_score ?? 0.0;
    }

    public function getUserSeasonRank(int $userId, int $seasonId): int
    {
        $userScore = SeasonScore::query()
            ->where('user_id', $userId)
            ->where('season_id', $seasonId)
            ->first();

        if ($userScore === null || $userScore->total_score <= 0) {
            return 0;
        }

        $rank = SeasonScore::query()
            ->where('season_id', $seasonId)
            ->where('total_score', '>', $userScore->total_score)
            ->count();

        return $rank + 1;
    }

    public function getLeaderboard(int $seasonId, int $limit = 10): Collection
    {
        return SeasonScore::query()
            ->where('season_id', $seasonId)
            ->with('user:id,username,platform_score,avatar_path,academic_year,major,university_name,preferences')
            ->orderBy('total_score', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getTotalParticipants(int $seasonId): int
    {
        return SeasonScore::query()
            ->where('season_id', $seasonId)
            ->count();
    }

    public function resetScoresForSeason(int $seasonId): void
    {
        SeasonScore::query()
            ->where('season_id', $seasonId)
            ->delete();
    }

    public function archiveScores(int $seasonId): void
    {
        $scores = SeasonScore::query()
            ->where('season_id', $seasonId)
            ->with('user:id,username')
            ->orderBy('total_score', 'desc')
            ->get();

        $snapshots = [];
        $rank = 1;
        foreach ($scores as $score) {
            $snapshots[] = [
                'season_id' => $seasonId,
                'user_id' => $score->user_id,
                'username' => $score->user->username ?? 'Unknown',
                'final_score' => $score->total_score,
                'final_rank' => $rank++,
                'skill_count' => $score->skill_count,
                'snapshot_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($snapshots)) {
            SeasonScoreSnapshot::query()->insert($snapshots);
        }
    }
}
