<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Handles theme switching (light / dark mode).
 *
 * - Authenticated users: the choice is persisted in `users.preferences['theme']`.
 * - Guests: the choice is stored in a `theme` cookie for 1 year.
 */
final class ThemeController
{
    public const COOKIE_NAME = 'theme';
    public const COOKIE_MINUTES = 60 * 24 * 365; // 1 year

    public function toggle(Request $request): RedirectResponse
    {
        $theme = $request->string('theme')->toString();

        if (! in_array($theme, ['light', 'dark'], true)) {
            return back();
        }

        // Persist for authenticated users.
        if (Auth::check()) {
            $user = Auth::user();
            $preferences = $user->preferences ?? [];
            $preferences['theme'] = $theme;
            $user->forceFill(['preferences' => $preferences])->save();
        }

        // Persist for guests via cookie (and keeps authed fallback in sync).
        $redirect = back()->withCookie(
            cookie()->forever(self::COOKIE_NAME, $theme)
        );

        return $redirect;
    }
}

