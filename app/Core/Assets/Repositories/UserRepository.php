<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Auth\Models\User;

final class UserRepository implements UserRepositoryInterface
{
    /** @return array<string, mixed> */
    public function fetchActivityProfile(int $userId): array
    {
        $user = User::query()->with([
            'enrolledSkills.skill',
            'goals',
        ])->findOrFail($userId);

        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'enrolled_skills' => $user->enrolledSkills->map(fn ($enrollment) => [
                'skill_id' => $enrollment->skill_id,
                'skill_title' => $enrollment->skill?->title,
                'status' => $enrollment->status,
                'enrolled_at' => $enrollment->enrolled_at?->toISOString(),
            ]),
            'goals' => $user->goals->map(fn ($goal) => [
                'id' => $goal->id,
                'text' => $goal->text,
                'status' => $goal->status,
                'completed_at' => $goal->completed_at?->toISOString(),
            ]),
        ];
    }
}

