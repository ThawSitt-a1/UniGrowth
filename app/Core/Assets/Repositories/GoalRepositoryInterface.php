<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Core\Assets\Models\Goal;

interface GoalRepositoryInterface
{
    public function create(array $data): Goal;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}

