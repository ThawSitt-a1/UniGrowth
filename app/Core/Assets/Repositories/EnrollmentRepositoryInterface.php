<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Core\Assets\Models\Enrollment;

interface EnrollmentRepositoryInterface
{
    public function enroll(int $userId, int $skillId): Enrollment;

    public function unenroll(int $userId, int $skillId): bool;
}

