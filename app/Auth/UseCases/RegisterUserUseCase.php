<?php

namespace App\Auth\UseCases;

use App\Auth\DTOs\AuthCredentialsDTO;
use App\Auth\Repositories\UserRepositoryInterface;
use App\Auth\Models\User;
use App\Services\AuthSessionService;
use Illuminate\Auth\Events\Registered;

final class RegisterUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AuthSessionService $authSessionService,
        private readonly User $userModel,
    ) {
    }

    public function execute(AuthCredentialsDTO $credentials): array
    {
        $userData = [
            'username' => $credentials->username,
            'email'    => $credentials->email,
            'password' => $credentials->password,
        ];

        // If "remember me" was checked, pre-generate remember_token with 30-day expiry
        if ($credentials->remember) {
            $userData['remember_token'] = \Illuminate\Support\Str::random(60);
            $userData['remember_token_expires_at'] = now()->addDays(30);
        }

        $user = $this->userRepository->create($userData);

        $eloquentUser = $this->userModel->newQuery()->find($user['id']);

        // Fire the Registered event — triggers email verification notification
        event(new Registered($eloquentUser));

        // Note: User is NOT auto-logged in after registration.
        // They must verify their email first before being allowed to log in.

        return [
            'id'       => $eloquentUser->id,
            'username' => $eloquentUser->username,
            'email'    => $eloquentUser->email,
            'role'     => $eloquentUser->role,
        ];
    }
}
