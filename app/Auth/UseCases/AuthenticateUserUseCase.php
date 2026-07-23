<?php

namespace App\Auth\UseCases;

use App\Auth\DTOs\AuthCredentialsDTO;
use App\Auth\Repositories\UserRepositoryInterface;
use App\Auth\Models\User;
use App\Services\AuthSessionService;
use Illuminate\Support\Facades\Hash;

final class AuthenticateUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AuthSessionService $authSessionService,
        private readonly User $userModel,
    ) {
    }

    public function execute(AuthCredentialsDTO $credentials): array
    {
        // Use the repository for credential check (keeps the interface contract)
        $userData = $this->userRepository->findByEmail($credentials->email);

        if ($userData === null || !Hash::check($credentials->password, $userData['password_hash'] ?? '')) {
            throw new \RuntimeException('Invalid credentials');
        }

        // Fetch the Eloquent model for session creation
        $user = $this->userModel->newQuery()->where('email', $credentials->email)->first();

        if ($user === null) {
            throw new \RuntimeException('Invalid credentials');
        }

        // Enforce email verification: unverified users cannot log in
        if (!$user->hasVerifiedEmail()) {
            throw new \RuntimeException('Email not verified.');
        }

        // Create the authenticated session via AuthSessionService
        $this->authSessionService->login($user, $credentials->remember);

        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role,
        ];
    }
}

