<?php

declare(strict_types=1);

namespace App\Editor\DTOs;

final class ContentQueryFilterDTO
{
    public function __construct(
        public readonly ?int $editorId = null,
        public readonly ?string $searchQuery = null,
        public readonly ?int $skillId = null,
        public readonly int $perPage = 15,
    ) {
    }
}
