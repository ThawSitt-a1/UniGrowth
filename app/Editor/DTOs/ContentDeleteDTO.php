<?php

declare(strict_types=1);

namespace App\Editor\DTOs;

final class ContentDeleteDTO
{
    public function __construct(
        public readonly int $targetId,
        public readonly int $editorId,
    ) {
    }
}
