<?php

declare(strict_types=1);

namespace App\Editor\DTOs;

final class SkillDataDTO
{
    public function __construct(
        public readonly ?int $skillId,
        public readonly int $editorId,
        public readonly string $title,
        public readonly string $slug,
        public readonly string $description,
        public readonly ?array $tags = [],
        public readonly ?string $content = '',
        public readonly ?string $resourceLink = '',
        public readonly ?array $resourceLinks = [],
    ) {
    }
}
