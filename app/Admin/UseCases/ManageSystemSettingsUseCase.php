<?php

declare(strict_types=1);

namespace App\Admin\UseCases;

use App\Admin\DTOs\SystemSettingsDTO;
use App\Admin\Repositories\SettingsRepositoryInterface;
use InvalidArgumentException;

final class ManageSystemSettingsUseCase
{
    private const ALLOWED_KEYS = [
        // Existing
        'maintenance_mode',
        'app_timezone',
        'default_language',
        'system_sender_email',
        'notifications_enabled',
        'content_approval_required',
        'allow_user_registration',
        'require_email_verification',
        'max_login_attempts',
        // Site Identity
        'site_platform_name',
        'site_logo_path',
        'site_favicon_path',
        'support_email',
        // Localization
        'date_display_format',
        'time_display_format',
        // Feature Kill Switches
        'feature_kill_skills',
        'feature_kill_quiz',
        'feature_kill_season',
        // Password Policy
        'password_min_length',
        'password_require_special',
        'password_require_numbers',
    ];

    public function __construct(
        private readonly SettingsRepositoryInterface $settingsRepository,
    ) {
    }

    /**
     * Update a system setting.
     */
    public function execute(SystemSettingsDTO $settings): void
    {
        if (!in_array($settings->settingsKey, self::ALLOWED_KEYS, true)) {
            throw new InvalidArgumentException(
                "Unknown or disallowed setting key: '{$settings->settingsKey}'"
            );
        }

        $this->settingsRepository->set($settings->settingsKey, $settings->settingsValue);
    }

    /**
     * Get all current system settings.
     *
     * @return array<string, string|null>
     */
    public function getAllSettings(): array
    {
        return $this->settingsRepository->getAll();
    }
}

