<?php

declare(strict_types=1);

namespace App\Admin\Services;

interface SystemSettingsServiceInterface
{
    public function get(string $key, ?string $default = null): ?string;

    public function getBool(string $key, bool $default = false): bool;

    public function getPlatformName(): string;

    public function isRegistrationAllowed(): bool;

    public function isFeatureKillSkillsEnabled(): bool;

    public function isFeatureKillGoalsHabitsEnabled(): bool;

    public function isFeatureKillQuizEnabled(): bool;

    public function isFeatureKillSeasonEnabled(): bool;

    public function isMaintenanceModeEnabled(): bool;

    public function isContentApprovalRequired(): bool;
}
