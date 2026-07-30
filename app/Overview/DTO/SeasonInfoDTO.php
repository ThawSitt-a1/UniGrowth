<?php

declare(strict_types=1);

namespace App\Overview\DTO;

final class SeasonInfoDTO
{
    public function __construct(
        public readonly ?int $seasonId,
        public readonly ?string $seasonName,
        public readonly ?string $startedAt,
        public readonly ?string $endsAt,
        public readonly bool $isActive,
        public readonly int $daysRemaining,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'season_id' => $this->seasonId,
            'season_name' => $this->seasonName,
            'started_at' => $this->startedAt,
            'ends_at' => $this->endsAt,
            'is_active' => $this->isActive,
            'days_remaining' => $this->daysRemaining,
        ];
    }
}

