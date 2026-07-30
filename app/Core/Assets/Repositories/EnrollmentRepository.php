<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Core\Assets\Models\Enrollment;
use Illuminate\Support\Facades\DB;

final class EnrollmentRepository implements EnrollmentRepositoryInterface
{
    public function enroll(int $userId, int $skillId): Enrollment
    {
        return DB::transaction(function () use ($userId, $skillId) {
            return Enrollment::query()->firstOrCreate(
                ['user_id' => $userId, 'skill_id' => $skillId],
                ['status' => 'active', 'enrolled_at' => now()]
            );
        });
    }

    public function unenroll(int $userId, int $skillId): bool
    {
        return (bool) Enrollment::query()
            ->where('user_id', $userId)
            ->where('skill_id', $skillId)
            ->delete();
    }
}

