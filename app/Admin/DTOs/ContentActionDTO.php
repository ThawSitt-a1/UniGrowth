<?php

declare(strict_types=1);

namespace App\Admin\DTOs;

final class ContentActionDTO
{
    public function __construct(
        public readonly int $targetId,
        public readonly string $targetType,  // QUESTION, SKILL
        public readonly string $action,      // SUSPEND, RESTORE, DELETE
        public readonly string $reason = '',
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'target_id' => $this->targetId,
            'target_type' => $this->targetType,
            'action' => $this->action,
            'reason' => $this->reason,
        ];
    }
}
