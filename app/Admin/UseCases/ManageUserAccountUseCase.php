<?php

declare(strict_types=1);

namespace App\Admin\UseCases;

use App\Admin\DTOs\UserStatusDTO;
use App\Auth\Models\User;

final class ManageUserAccountUseCase
{
    /**
     * Execute account penalty actions (ban, clear status).
     *
     * @throws \InvalidArgumentException when attempting to modify an admin account
     */
    public function execute(UserStatusDTO $status): void
    {
        $user = User::query()->findOrFail($status->targetUserId);

        // Guard: never allow modifying an admin account's status
        if ($user->role === User::ROLE_ADMIN) {
            throw new \InvalidArgumentException('Admin accounts cannot be banned.');
        }

        $updateData = [
            'account_status' => $status->status,
        ];

        if ($status->status === 'banned') {
            // Clear any existing suspension window when banning
            $updateData['suspended_until'] = null;
        } elseif ($status->status === 'allowed') {
            // Clear suspension when restoring
            $updateData['suspended_until'] = null;
        }

        $user->update($updateData);

        // Immediately invalidate the user's sessions so the ban
        // takes effect on their next request rather than waiting for token expiry.
        if ($status->status !== 'allowed') {
            $user->update(['remember_token' => null]);
        }
    }
}

