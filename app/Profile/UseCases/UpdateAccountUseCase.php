<?php

namespace App\Profile\UseCases;

use App\Auth\Models\User;
use Illuminate\Support\Facades\Hash;

final class UpdateAccountUseCase
{
    public function __construct(
        private readonly User $userModel,
    ) {
    }

    public function changePassword(int $userId, string $newPassword): bool
    {
        $user = $this->userModel->newQuery()->find($userId);

        if ($user === null) {
            return false;
        }

        return $user->forceFill([
            'password' => Hash::make($newPassword),
        ])->save();
    }

    public function deactivateAccount(int $userId): bool
    {
        $user = $this->userModel->newQuery()->find($userId);

        if ($user === null) {
            return false;
        }

        return $user->forceFill([
            'account_status' => 'suspended',
            'suspended_until' => now()->addYears(100), // Effectively permanent
        ])->save();
    }
}

