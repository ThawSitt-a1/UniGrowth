<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Core\Assets\DTO\AssetActionDTO;

interface AssetRepositoryInterface
{
    /** @return array<string, mixed> */
    public function execute(AssetActionDTO $action, int $userId): array;

}

