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

/**
     * Permanently delete the user's account and all associated data.
     *
     * Hard delete (immediate purge) — ensures compliance with the "Right to
     * Erasure". Related records are removed via foreign-key cascade; the
     * only exception is bug_reports, which use onDelete('set null') and
     * therefore keep their report content but detach from the user.
     *
     * @param  string|null  $feedbackReason  Optional dropdown reason for leaving.
     * @param  string|null  $feedback        Optional free-text feedback.
     */
    public function deactivateAccount(int $userId, ?string $feedbackReason = null, ?string $feedback = null): bool
    {
        $user = $this->userModel->newQuery()->find($userId);

        if ($user === null) {
            return false;
        }

        // Hard-delete the user. Cascade rules purge goals, habits, attempts,
        // student_skills, season_scores, social accounts, etc. Bug reports are
        // detached (user_id set to null) rather than deleted.
        return (bool) $user->delete();
    }
}

