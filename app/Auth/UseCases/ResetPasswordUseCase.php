<?php

namespace App\Auth\UseCases;

use App\Auth\DTOs\ResetPasswordDTO;
use App\Auth\Models\PasswordReset;
use App\Auth\Models\User;
use App\Services\AuthSessionService;
use Illuminate\Support\Str;

final class ResetPasswordUseCase
{
    public function __construct(
        private readonly User $userModel,
        private readonly PasswordReset $passwordResetModel,
        private readonly AuthSessionService $authSessionService,
    ) {
    }

    public function requestReset(string $email): string
    {
        $user = $this->userModel->newQuery()->where('email', $email)->first();

        if ($user === null) {
            throw new \RuntimeException('User not found.');
        }

        $token = Str::uuid()->toString();

        $this->passwordResetModel->newQuery()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'token' => $token,
                'expires_at' => now()->addMinutes(config('auth.passwords.users.expire', 60)),
                'created_at' => now(),
            ]
        );

        // Send password reset notification email with the token
        $user->sendPasswordResetNotification($token);

        return $token;
    }

    public function execute(ResetPasswordDTO $dto): array
    {
        // Find the user by email using Eloquent
        $user = $this->userModel->newQuery()->where('email', $dto->email)->first();

        if ($user === null) {
            return [
                'success' => false,
                'message' => 'User not found.',
            ];
        }

        // Find the reset record using the PasswordReset model
        $resetRecord = $this->passwordResetModel->newQuery()
            ->where('user_id', $user->id)
            ->notExpired()
            ->first();

        if ($resetRecord === null) {
            return [
                'success' => false,
                'message' => 'Invalid or expired reset token.',
            ];
        }

        // Check if token matches using hash_equals for timing-safe comparison
        if (!hash_equals($resetRecord->token, $dto->token)) {
            return [
                'success' => false,
                'message' => 'Invalid or expired reset token.',
            ];
        }

        // Check if token has expired using the model's method
        if ($resetRecord->isExpired()) {
            $resetRecord->delete();
            return [
                'success' => false,
                'message' => 'Reset token has expired. Please request a new one.',
            ];
        }

        // Update ONLY the password field using Eloquent (no email changes allowed)
        // The 'hashed' cast on the User model will handle hashing automatically
        $user->password = $dto->password;
        $user->save();

        // Delete the used token so it cannot be reused
        $resetRecord->delete();

        // Invalidate ALL existing sessions for this user (old password sessions)
        $this->authSessionService->invalidateAllSessionsForUser($user->id);

        // Auto-login the user with their new password
        $this->authSessionService->login($user, $dto->remember);

        return [
            'success' => true,
            'message' => 'Password has been reset successfully. You are now logged in.',
            'user' => [
                'id'       => $user->id,
                'username' => $user->username,
                'email'    => $user->email,
                'role'     => $user->role,
            ],
        ];
    }
}
