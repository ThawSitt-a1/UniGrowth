<?php

namespace App\Auth\Repositories;

use App\Auth\Models\PasswordReset;
use App\Auth\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?array
    {
        $user = User::query()->where('email', $email)->first();
        if ($user === null) {
            return null;
        }

        return [
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role,
            'password_hash' => $user->password,
            'session_id' => null,
        ];
    }

    public function create(array $data): array
    {
$user = User::query()->create([
        'username'        => $data['username'],
        'email'           => $data['email'],
        'role'            => $data['role'] ?? 'user',
        // The 'hashed' cast on the User model handles hashing automatically
        'password'        => $data['password'],
        'remember_token'  => $data['remember_token'] ?? null,
        'academic_year'   => $data['academic_year'] ?? null,
        'major'           => $data['major'] ?? null,
        'university_name' => $data['university_name'] ?? null,
        'agreed_to_terms' => $data['agreed_to_terms'] ?? false,
        ]);

    return [
        'id'         => $user->id,
        'email'      => $user->email,
        'role'       => $user->role,
        'session_id' => null,
        ];
    }

    public function createPasswordResetForEmail(string $email): void
    {
        $user = User::query()->where('email', $email)->first();

        // Anti-enumeration: do not reveal whether user exists.
        if ($user === null) {
            return;
        }

        $token = Str::random(60);

        PasswordReset::query()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'token' => $token,
                'expires_at' => now()->addMinutes(60),
                'created_at' => now(),
            ]
        );

        // Email dispatch intentionally omitted (Notification Hub responsibility later).
    }

    public function updatePassword(string $email, string $password): void
    {
        $user = User::query()->where('email', $email)->first();

        if ($user === null) {
            return;
        }

        $user->forceFill([
            'password' => $password, // The 'hashed' cast handles hashing automatically
        ])->save();
    }
}

