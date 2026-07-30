<?php

declare(strict_types=1);

namespace App\Admin\Repositories;

interface SettingsRepositoryInterface
{
    /**
     * Get a setting value by key.
     */
    public function get(string $key, ?string $default = null): ?string;

    /**
     * Set a setting value.
     */
    public function set(string $key, string $value): bool;

    /**
     * Get all settings as key-value pairs.
     *
     * @return array<string, string|null>
     */
    public function getAll(): array;
}

