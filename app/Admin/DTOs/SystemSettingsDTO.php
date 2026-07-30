<?php

declare(strict_types=1);

namespace App\Admin\DTOs;

final class SystemSettingsDTO
{
    public function __construct(
        public readonly string $settingsKey,
        public readonly string $settingsValue,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'settings_key' => $this->settingsKey,
            'settings_value' => $this->settingsValue,
        ];
    }
}

