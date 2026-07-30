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
}

