<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class AuthSessionService
{
    public function __construct()
    {
    }

    public function login(Authenticatable $user, bool $remember): void
    {
        if ($remember) {
            // Only generate a new token+expiry if none exists or the existing one is expired.
            // This ensures the same token persists across logins until it naturally expires.
            if (empty($user->getRememberToken()) || ($user instanceof \App\Auth\Models\User && $user->isRememberTokenExpired())) {
                $token = \Illuminate\Support\Str::random(60);
                $user->forceFill([
                    'remember_token' => $token,
                    'remember_token_expires_at' => now()->addDays(30),
                ])->save();

                // Reload the user so the guard picks up the fresh token
                $user->refresh();
            }

            Auth::guard('web')->login($user, true);

            session()->put('login_via_remember', true);
            session()->put('remember_token', $user->getRememberToken());

            return;
        }

        Auth::guard('web')->login($user, false);
    }

    /**
     * Invalidate all sessions for a given user ID.
     * This is used after password reset where the user
     * may not have an active session (guest middleware).
     */
    public function invalidateAllSessionsForUser(int $userId): void
    {
        DB::table('sessions')
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * Log out all other sessions for the current user.
     * This is called after a password reset to invalidate
     * any old sessions that may be compromised.
     */
    public function logoutOtherDevices(Authenticatable $user, string $password): void
    {
        Auth::guard('web')->logoutOtherDevices($password);
    }

    /**
     * Forcefully terminate the current session.
     */
    public function logout(): void
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}


