<?php

declare(strict_types=1);

namespace App\Admin\UseCases;

use App\Admin\DTOs\RoleAssignmentDTO;
use App\Auth\Models\User;
use InvalidArgumentException;

final class AssignUserRoleUseCase
{
    /**
     * Execute role assignment.
     *
     * Only allows: user <-> editor transitions.
     * Admin role cannot be assigned through this use case.
     */
    public function execute(RoleAssignmentDTO $assignment): void
    {
        $allowedRoles = ['user', 'editor'];

        if (!in_array($assignment->newRole, $allowedRoles, true)) {
            throw new InvalidArgumentException(
                "Role '{$assignment->newRole}' cannot be assigned. Only 'user' and 'editor' roles are assignable."
            );
        }

        $user = User::query()->findOrFail($assignment->userId);

        // Prevent changing admin roles
        if ($user->role === 'admin') {
            throw new InvalidArgumentException('Cannot change the role of an admin user.');
        }

        $user->update(['role' => $assignment->newRole]);
    }
}

