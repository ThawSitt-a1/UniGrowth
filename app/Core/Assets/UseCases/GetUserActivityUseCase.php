<?php

declare(strict_types=1);

namespace App\Core\Assets\UseCases;

use App\Core\Assets\Repositories\UserRepositoryInterface;

final class GetUserActivityUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    /** @return array<string, mixed> */
    public function execute(int $userId): array
    {
        return $this->userRepository->fetchActivityProfile($userId);
    }
}

