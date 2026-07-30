<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

interface UserRepositoryInterface
{
    /** @return array<string, mixed> */
    public function fetchActivityProfile(int $userId): array;
}

