<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Core\Assets\Models\Habit;

final class HabitRepository implements HabitRepositoryInterface
{
    public function create(array $data): Habit
    {
        return Habit::query()->create($data);
    }

    public function delete(int $id): bool
    {
        return (bool) Habit::query()->where('id', $id)->delete();
    }
}

