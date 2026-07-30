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
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $role = (string) ($user->role ?? '');

        if ($role !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden. Admin access required.'], 403);
            }
            abort(403, 'Admin access required.');
        }

        return $next($request);
    }
}

