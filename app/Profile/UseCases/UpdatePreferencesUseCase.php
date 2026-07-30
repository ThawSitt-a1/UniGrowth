<?php

namespace App\Profile\UseCases;

use App\Auth\Models\User;

final class UpdatePreferencesUseCase
{
    public function __construct(
        private readonly User $userModel,
    ) {
    }

    public function execute(int $userId, array $settings): bool
    {
        $user = $this->userModel->newQuery()->find($userId);

        if ($user === null) {
            return false;
        }

        $currentPreferences = $user->preferences ?? [];
        $mergedPreferences = array_merge($currentPreferences, $settings);

        return $user->forceFill(['preferences' => $mergedPreferences])->save();
    }
}

