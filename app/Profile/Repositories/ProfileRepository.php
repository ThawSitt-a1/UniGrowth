<?php

namespace App\Profile\Repositories;

use App\Auth\Models\User;
use App\Profile\Models\UserSocialAccount;
use Illuminate\Support\Facades\DB;

final class ProfileRepository implements ProfileRepositoryInterface
{
public function findByUserId(int $userId): ?array
    {
        $user = User::query()->with('socialAccounts')->find($userId);

        if ($user === null) {
            return null;
        }

        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role,
            'avatar_path' => $user->avatar_path,
            'platform_score' => $user->platform_score,
            'academic_year' => $user->academic_year,
            'major' => $user->major,
            'university_name' => $user->university_name,
            'description' => $user->description,
            'preferences' => $user->preferences,
            'social_links' => $user->relationLoaded('socialAccounts')
                ? $user->socialAccounts->map(fn ($a) => [
                    'platform' => $a->platform,
                    'url' => $a->url,
                ])->toArray()
                : [],
            'email_verified_at' => $user->email_verified_at?->toDateTimeString(),
            'created_at' => $user->created_at->toDateTimeString(),
        ];
    }

    public function updateProfileData(int $userId, array $data): bool
    {
        return User::query()->where('id', $userId)->update($data) > 0;
    }

    public function updateAvatarPath(int $userId, string $path): bool
    {
        return User::query()->where('id', $userId)->update(['avatar_path' => $path]) > 0;
    }
}

