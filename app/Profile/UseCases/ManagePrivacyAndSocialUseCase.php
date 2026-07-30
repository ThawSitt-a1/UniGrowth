<?php

namespace App\Profile\UseCases;

use App\Auth\Models\User;
use App\Profile\Models\UserSocialAccount;
use Illuminate\Support\Facades\DB;

final class ManagePrivacyAndSocialUseCase
{
    public function __construct(
        private readonly User $userModel,
        private readonly UserSocialAccount $socialAccountModel,
    ) {
    }

    public function execute(int $userId, string $visibility, array $socialLinks): bool
    {
        return DB::transaction(function () use ($userId, $visibility, $socialLinks): bool {
            // Update visibility in preferences
            $user = $this->userModel->newQuery()->find($userId);

            if ($user === null) {
                return false;
            }

            $currentPreferences = $user->preferences ?? [];
            $currentPreferences['privacy_show_profile'] = ($visibility === 'public');
            $user->forceFill(['preferences' => $currentPreferences])->save();

            // Sync social links
            if (!empty($socialLinks)) {
                $this->socialAccountModel->newQuery()
                    ->where('user_id', $userId)
                    ->delete();

                foreach ($socialLinks as $link) {
                    $this->socialAccountModel->newQuery()->create([
                        'user_id' => $userId,
                        'platform' => $link['platform'],
                        'url' => $link['url'],
                    ]);
                }
            }

            return true;
        });
    }
}

