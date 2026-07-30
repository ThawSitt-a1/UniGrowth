<?php

namespace App\Profile\Repositories;

interface ProfileRepositoryInterface
{
    public function findByUserId(int $userId): ?array;

    public function updateProfileData(int $userId, array $data): bool;

    public function updateAvatarPath(int $userId, string $path): bool;
}

