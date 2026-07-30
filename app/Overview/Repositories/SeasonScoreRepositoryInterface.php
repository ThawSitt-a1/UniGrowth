<?php

declare(strict_types=1);

namespace App\Overview\Repositories;

use Illuminate\Support\Collection;

interface SeasonScoreRepositoryInterface
{
    public function upsertScore(int $userId, int $seasonId, float $score, int $questionsAnswered): void;

    public function getTotalScore(int $userId, int $seasonId): float;

    public function getUserSeasonRank(int $userId, int $seasonId): int;

    public function getLeaderboard(int $seasonId, int $limit = 10): Collection;

    public function getTotalParticipants(int $seasonId): int;

    public function resetScoresForSeason(int $seasonId): void;

    public function archiveScores(int $seasonId): void;
}

