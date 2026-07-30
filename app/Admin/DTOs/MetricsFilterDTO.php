<?php

declare(strict_types=1);

namespace App\Admin\DTOs;

final class MetricsFilterDTO
{
    public function __construct(
        public readonly string $timeFrame = 'all',
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'time_frame' => $this->timeFrame,
        ];
    }
}

