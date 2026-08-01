<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Core\Assets\Models\Habit;

interface HabitRepositoryInterface
{
    public function create(array $data): Habit;

    public function delete(int $id): bool;
}

