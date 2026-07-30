<?php

declare(strict_types=1);

namespace App\Admin\Repositories;

use App\Admin\Models\SystemSetting;
use Illuminate\Support\Facades\Cache;

final class SettingsRepository implements SettingsRepositoryInterface
{
    private const CACHE_KEY = 'system_settings';
    private const CACHE_TTL = 3600; // 1 hour

    public function get(string $key, ?string $default = null): ?string
    {
        $setting = SystemSetting::query()
            ->where('setting_key', $key)
            ->first();

        return $setting?->setting_value ?? $default;
    }

    public function set(string $key, string $value): bool
    {
        $result = SystemSetting::query()
            ->updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => $value]
            );

        // Clear cache after update
        Cache::forget(self::CACHE_KEY);

        return $result !== null;
    }

    public function getAll(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return SystemSetting::query()
                ->pluck('setting_value', 'setting_key')
                ->toArray();
        });
    }
}

