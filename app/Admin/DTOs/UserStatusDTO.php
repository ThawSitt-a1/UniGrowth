<?php

declare(strict_types=1);

namespace App\Admin\DTOs;

final class UserStatusDTO
{
    public function __construct(
        public readonly int $targetUserId,
        public readonly string $status,        // allowed, banned
        public readonly string $reason = '',
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'target_user_id' => $this->targetUserId,
            'status' => $this->status,
            'reason' => $this->reason,
        ];
    }
}

