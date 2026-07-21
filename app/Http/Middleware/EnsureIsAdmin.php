<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user() ?? Auth::guard('sanctum')->user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $role = (string) ($user->role ?? '');

        // Enforce 'admin' or 'super_admin' as "admin or above".
        $isAllowed = in_array($role, ['admin', 'super_admin'], true);

        if (! $isAllowed) {
            return response()->json(['error' => 'Forbidden. Admin access required.'], 403);
        }

        return $next($request);
    }
}

