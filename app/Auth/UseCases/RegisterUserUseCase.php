<?php

namespace App\Auth\UseCases;

use App\Auth\DTOs\AuthCredentialsDTO;
use App\Auth\Repositories\UserRepositoryInterface;
use App\Models\User;
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
        $user = $this->userRepository->create([
            'username' => $credentials->username,
            'email'    => $credentials->email,
            'password' => $credentials->password,
        ]);

        $eloquentUser = $this->userModel->newQuery()->find($user['id']);

        // Fire the Registered event — triggers email verification notification
        event(new Registered($eloquentUser));

        // Auto-login the user after successful registration
        $this->authSessionService->login($eloquentUser, $credentials->remember);

        return [
            'id'       => $eloquentUser->id,
            'username' => $eloquentUser->username,
            'email'    => $eloquentUser->email,
            'role'     => $eloquentUser->role,
        ];
    }
}
