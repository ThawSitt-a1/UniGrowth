<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsEditor
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

        // Editors and Admins both have access to editor-protected paths
        if (!in_array($role, ['editor', 'admin'], true)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden. Editor or admin access required.'], 403);
            }
            abort(403, 'Editor or admin access required.');
        }

        return $next($request);
    }
}

