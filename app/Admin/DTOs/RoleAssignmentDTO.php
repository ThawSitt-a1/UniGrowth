<?php

declare(strict_types=1);

namespace App\Admin\DTOs;

final class RoleAssignmentDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly string $newRole,   // user, editor  (only admins can promote to editor)
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'new_role' => $this->newRole,
        ];
    }
}

