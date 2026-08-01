<?php

declare(strict_types=1);

namespace App\Core\Assets\DTO;

final readonly class AssetActionDTO
{
    public function __construct(
        public string $type, // 'goal'|'skill'|'habit'
        public string $action, // 'create'|'complete'|'delete'|'enroll'|'unenroll'
        /** @var array<string, mixed> */
        public array $payload = [],
    ) {
    }
}

