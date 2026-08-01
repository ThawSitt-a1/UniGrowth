<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware aliases & rate limiters (Laravel 11 style)
        $middleware->alias([
            'auth.ensure' => \App\Http\Middleware\EnsureAuthenticated::class,
            'role.admin' => \App\Http\Middleware\EnsureIsAdmin::class,
            'role.super_admin' => \App\Http\Middleware\EnsureIsSuperAdmin::class,
        ]);

        // Rate limiting uses built-in `throttle` middleware on routes for now (compatible with this codebase).
        // Global authenticated throttling should be applied to authenticated route groups when present.

        // Apply the user's preferred theme (light/dark) to every HTML response.
        // Registered inside the "web" group (rather than a global prepend) so it
        // runs AFTER EncryptCookies + StartSession — required to read the encrypted
        // theme cookie and the authenticated session preferences correctly.
        $middleware->web(append: \App\Http\Middleware\ApplyUserTheme::class);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
