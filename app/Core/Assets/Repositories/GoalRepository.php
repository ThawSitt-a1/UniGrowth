<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Core\Assets\Models\Goal;

final class GoalRepository implements GoalRepositoryInterface
{
    public function create(array $data): Goal
    {
        return Goal::query()->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return (bool) Goal::query()->where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return (bool) Goal::query()->where('id', $id)->delete();
    }
}

