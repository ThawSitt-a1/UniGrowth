<?php

declare(strict_types=1);

namespace App\Admin\DTOs;

final class PlatformMetricsDTO
{
    public function __construct(
        public readonly int $totalRegisteredUsers,
        public readonly int $activeUsers,
        public readonly int $totalBannedUsers,
        public readonly int $totalSkills,
        public readonly string $recordedAt,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'total_registered_users' => $this->totalRegisteredUsers,
            'active_users' => $this->activeUsers,
            'total_banned_users' => $this->totalBannedUsers,
            'total_skills' => $this->totalSkills,
            'recorded_at' => $this->recordedAt,
        ];
    }
}

