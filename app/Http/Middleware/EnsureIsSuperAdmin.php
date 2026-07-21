<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user() ?? Auth::guard('sanctum')->user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $role = (string) ($user->role ?? '');

        if ($role !== 'super_admin') {
            return response()->json(['error' => 'Forbidden. Super admin access required.'], 403);
        }

        return $next($request);
    }
}

