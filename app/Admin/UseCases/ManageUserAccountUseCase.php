<?php

declare(strict_types=1);

namespace App\Admin\UseCases;

use App\Admin\DTOs\UserStatusDTO;
use App\Auth\Models\User;
use Carbon\Carbon;

final class ManageUserAccountUseCase
{
    /**
     * Execute account penalty actions (ban, suspend, clear status).
     */
    public function execute(UserStatusDTO $status): void
    {
        $user = User::query()->findOrFail($status->targetUserId);

        $updateData = [
            'account_status' => $status->status,
        ];

        if ($status->status === 'suspended' && $status->suspendedUntil) {
            $updateData['suspended_until'] = Carbon::parse($status->suspendedUntil);
        } elseif ($status->status === 'allowed') {
            // Clear suspension when restoring
            $updateData['suspended_until'] = null;
        }

        $user->update($updateData);
    }
}

