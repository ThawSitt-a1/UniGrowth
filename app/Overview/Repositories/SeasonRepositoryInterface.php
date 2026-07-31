<?php

declare(strict_types=1);

namespace App\Overview\Repositories;

use App\Overview\Models\Season;
use Illuminate\Support\Collection;

interface SeasonRepositoryInterface
{
    public function getCurrentActiveSeason(): ?Season;

    public function findById(int $seasonId): ?Season;

    public function create(array $data): Season;

    public function endSeason(int $seasonId): void;

    public function getSeasonHistory(int $limit = 10): Collection;

    public function getOrCreateCurrentSeason(): Season;

    /**
     * Update the highest_score for a season.
     * The highest_score equals the total combined marks of all active questions.
     */
    public function updateHighestScore(int $seasonId, float $highestScore): void;
}

