<?php

declare(strict_types=1);

namespace App\Services;

use App\Auth\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthSessionService
{
    public function __construct() {}

    public function login(Authenticatable $user, bool $remember): void
    {
        if ($remember) {
            $token = Str::random(60);
            $user->forceFill([
                'remember_token' => $token,
                'remember_token_expires_at' => now()->addWeek(),
            ])->save();

            Auth::guard('web')->login($user, true);

            session()->put('login_via_remember', true);
            session()->put('remember_token', $token);

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
