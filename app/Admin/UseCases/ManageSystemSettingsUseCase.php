<?php

declare(strict_types=1);

namespace App\Admin\UseCases;

use App\Admin\DTOs\SystemSettingsDTO;
use App\Admin\Repositories\SettingsRepositoryInterface;
use InvalidArgumentException;

final class ManageSystemSettingsUseCase
{
    private const ALLOWED_KEYS = [
        'maintenance_mode',
        'app_timezone',
        'default_language',
        'system_sender_email',
        'notifications_enabled',
        'content_approval_required',
        'allow_user_registration',
        'require_email_verification',
        'max_login_attempts',
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

