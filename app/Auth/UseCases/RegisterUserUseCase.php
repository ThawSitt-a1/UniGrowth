<?php

namespace App\Auth\UseCases;

use App\Admin\Services\SystemSettingsServiceInterface;
use App\Auth\DTOs\AuthCredentialsDTO;
use App\Auth\Models\User;
use App\Auth\Repositories\UserRepositoryInterface;
use App\Services\AuthSessionService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

final class RegisterUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AuthSessionService $authSessionService,
        private readonly User $userModel,
        private readonly SystemSettingsServiceInterface $settingsService,
    ) {}

    public function execute(AuthCredentialsDTO $credentials): array
    {
        if (! $this->settingsService->isRegistrationAllowed()) {
            throw new \RuntimeException('User registration is currently disabled.');
        }

        $userData = [
            'username' => $credentials->username,
            'email' => $credentials->email,
            'password' => $credentials->password,
            'academic_year' => $credentials->academic_year,
            'major' => $credentials->major,
            'university_name' => $credentials->university_name,
            'terms_version' => $credentials->terms_version,
            'privacy_policy_version' => $credentials->privacy_policy_version,
            'consented_at' => $credentials->consented ? now() : null,
        ];

        // If "remember me" was checked, pre-generate remember_token with 30-day expiry
        if ($credentials->remember) {
            $userData['remember_token'] = Str::random(60);
            $userData['remember_token_expires_at'] = now()->addDays(30);
        }

        $user = $this->userRepository->create($userData);

        $eloquentUser = $this->userModel->newQuery()->find($user['id']);

        // Fire the Registered event — triggers email verification notification
        event(new Registered($eloquentUser));

        // Note: User is NOT auto-logged in after registration.
        // They must verify their email first before being allowed to log in.

        return [
            'id' => $eloquentUser->id,
            'username' => $eloquentUser->username,
            'email' => $eloquentUser->email,
            'role' => $eloquentUser->role,
        ];
    }
}
