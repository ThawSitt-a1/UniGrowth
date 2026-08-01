<?php

declare(strict_types=1);

namespace App\Overview\Repositories;

use App\Overview\Models\Season;
use Illuminate\Support\Collection;

final class SeasonRepository implements SeasonRepositoryInterface
{
    public function getCurrentActiveSeason(): ?Season
    {
        return Season::query()->active()->first();
    }

    public function findById(int $seasonId): ?Season
    {
        return Season::query()->find($seasonId);
    }

    public function create(array $data): Season
    {
        return Season::query()->create($data);
    }

    public function endSeason(int $seasonId): void
    {
        Season::query()->where('id', $seasonId)->update([
            'is_active' => false,
            'ends_at' => now(),
        ]);
    }

    public function getSeasonHistory(int $limit = 10): Collection
    {
        return Season::query()
            ->history()
            ->limit($limit)
            ->get();
    }

    /**
     * Update the highest_score for a season.
     * The highest_score equals the total combined marks of all active questions.
     */
    public function updateHighestScore(int $seasonId, float $highestScore): void
    {
        Season::query()->where('id', $seasonId)->update([
            'highest_score' => $highestScore,
        ]);
    }
}

