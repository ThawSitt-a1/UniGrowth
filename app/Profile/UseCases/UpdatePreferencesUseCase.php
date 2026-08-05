<?php

namespace App\Profile\UseCases;

use App\Auth\Models\User;

final class UpdatePreferencesUseCase
{
    /**
     * All known boolean-toggled preference keys.
     *
     * When a checkbox is left unchecked, the browser does not send the field at
     * all. Without a default, a previously-enabled toggle could never be turned
     * off (the old `true` value would survive the merge). These keys are
     * normalized here so an absent checkbox is persisted as `false`.
     */
    private const BOOLEAN_PREFERENCE_KEYS = [
        'notifications_email',
        'notifications_browser',
        'privacy_show_profile',
        'privacy_show_progress',
        'privacy_show_goals',
        'make_profile_private',
        'privacy_hide_leaderboards',
        'comm_email',
        'comm_telegram',
    ];

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

        // Normalize boolean preference keys so unchecked checkboxes (which are
        // absent from the request) are persisted as `false` instead of being
        // silently dropped and leaving the previous value untouched.
        $normalized = [];
        foreach (self::BOOLEAN_PREFERENCE_KEYS as $key) {
            $normalized[$key] = array_key_exists($key, $settings)
                ? (bool) $settings[$key]
                : false;
        }

        // Only override keys the form actually manages; merge the rest.
        $currentPreferences = $user->preferences ?? [];
        $mergedPreferences = array_merge($currentPreferences, $normalized);

        return $user->forceFill(['preferences' => $mergedPreferences])->save();
    }
}

