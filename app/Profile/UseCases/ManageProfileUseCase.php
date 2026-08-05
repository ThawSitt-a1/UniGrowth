<?php

namespace App\Profile\UseCases;

use App\Profile\DTOs\ProfileDTO;
use App\Profile\Repositories\ProfileRepositoryInterface;

final class ManageProfileUseCase
{
    public function __construct(
        private readonly ProfileRepositoryInterface $profileRepository,
    ) {
    }

    public function getProfile(int $userId): ?ProfileDTO
    {
        $data = $this->profileRepository->findByUserId($userId);

        if ($data === null) {
            return null;
        }

        return ProfileDTO::fromArray($data);
    }

public function updateProfile(int $userId, array $data): bool
    {
        $allowedFields = ['username', 'academic_year', 'major', 'university_name', 'description'];
        $filteredData = array_intersect_key($data, array_flip($allowedFields));
        $filteredData = array_filter($filteredData, fn ($value) => $value !== null);

        if (empty($filteredData)) {
            return false;
        }

        return $this->profileRepository->updateProfileData($userId, $filteredData);
    }
}

