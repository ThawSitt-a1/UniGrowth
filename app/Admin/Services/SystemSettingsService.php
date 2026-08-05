<?php

declare(strict_types=1);

namespace App\Admin\Services;

use App\Admin\Repositories\SettingsRepositoryInterface;

final class SystemSettingsService implements SystemSettingsServiceInterface
{
    private const DEFAULT_PLATFORM_NAME = 'UniGrowth';

    public function __construct(
        private readonly SettingsRepositoryInterface $settingsRepository,
    ) {
    }

    public function get(string $key, ?string $default = null): ?string
    {
        return $this->settingsRepository->get($key, $default);
    }

    public function getBool(string $key, bool $default = false): bool
    {
        $value = $this->get($key);
        if ($value === null) {
            return $default;
        }

        return strtolower($value) === 'true';
    }

    public function getPlatformName(): string
    {
        return $this->get('site_platform_name', self::DEFAULT_PLATFORM_NAME) ?: self::DEFAULT_PLATFORM_NAME;
    }

    public function isRegistrationAllowed(): bool
    {
        return $this->getBool('allow_user_registration', true);
    }

    public function isFeatureKillSkillsEnabled(): bool
    {
        return $this->getBool('feature_kill_skills', false);
    }

    public function isFeatureKillGoalsHabitsEnabled(): bool
    {
        return $this->getBool('feature_kill_goals_habits', false);
    }

    public function isFeatureKillQuizEnabled(): bool
    {
        return $this->getBool('feature_kill_quiz', false);
    }

    public function isFeatureKillSeasonEnabled(): bool
    {
        return $this->getBool('feature_kill_season', false);
    }

    public function isMaintenanceModeEnabled(): bool
    {
        return $this->getBool('maintenance_mode', false);
    }

    public function isContentApprovalRequired(): bool
    {
        return $this->getBool('content_approval_required', false);
    }
}
