<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Resolve User
        $user = Auth::guard('web')->user() ?: Auth::guard('sanctum')->user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // 2. Strict "Remember Me" Validation
        if (Auth::guard('web')->viaRemember()) {

            $isFlaggedAsRemembered = (bool) $request->session()->get('login_via_remember', false);
            $candidateToken = $request->session()->get('remember_token');

            // If we have flagged them as "remembered" in the session but the token is missing,
            // that is a security inconsistency: force logout.
            if ($isFlaggedAsRemembered && empty($candidateToken)) {
                $this->performLogout($request);
                return response()->json(['error' => 'Invalid or expired session token.'], 401);
            }

            // Verify session token against the user object (Source of Truth already in memory)
            if (!empty($candidateToken)) {
                // Use $user->remember_token directly—it is already fetched from the DB by the Guard
                if (empty($user->remember_token) || !hash_equals((string)$user->remember_token, (string)$candidateToken)) {
                    $this->performLogout($request);
                    return response()->json(['error' => 'Invalid or expired session token.'], 401);
                }

                // Check if the remember token has expired (date-based expiration)
                if (method_exists($user, 'isRememberTokenExpired') && $user->isRememberTokenExpired()) {
                    $this->performLogout($request);
                    return response()->json(['error' => 'Remember token has expired. Please log in again.'], 401);
                }
            }
        }

        // 3. Email verification check
        if (!$user->hasVerifiedEmail()) {
            $this->performLogout($request);
            return response()->json([
                'error' => 'Email not verified. Please verify your email before accessing this page.',
            ], 403);
        }

        // 4. Account status check
        $accountStatus = (string) ($user->account_status ?? 'allowed');

        if ($accountStatus === 'suspended') {
            // Auto-restore if the suspension period has expired
            $suspendedUntil = $user->suspended_until;
            if ($suspendedUntil !== null && now()->greaterThan($suspendedUntil)) {
                $user->update([
                    'account_status' => 'allowed',
                    'suspended_until' => null,
                ]);
                $accountStatus = 'allowed';
            }
        }

        if ($accountStatus !== 'allowed') {
            $this->performLogout($request);

            if ($accountStatus === 'suspended') {
                $contactMessage = 'Your account has been suspended due to a policy violation. Contact ourcompany@gmail.com';
            } else {
                $contactMessage = 'You are banned due to violation of our policy. Contact ourcompany@gmail.com';
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => $contactMessage,
                    'account_status' => $accountStatus,
                ], 403);
            }
            abort(403, $contactMessage);
        }

        // Ensure session is available for any downstream logic (this middleware may be tested via JSON requests)
        // Do not try to force a session into existence for JSON test requests.
        // If a session is not present, performLogout() must not touch the session.


        $request->setUserResolver(fn () => $user);

        return $next($request);
    }

    /**
     * Forcefully terminate the user's session.
     */
    private function performLogout(Request $request): void
    {
        Auth::guard('web')->logout();

        // Sanctum guard may not be configured in this app/test environment.
        if (array_key_exists('sanctum', config('auth.guards', []))) {
            Auth::guard('sanctum')->logout();
        }

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }
}
