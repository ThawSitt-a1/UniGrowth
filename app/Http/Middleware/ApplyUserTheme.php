<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Applies the user's preferred color theme to every HTML response.
 *
 * - Light theme (default): `data-bs-theme="light"` is set on the `<html>`
 *   tag and no extra stylesheet is injected, so the original light design
 *   renders as-is.
 * - Dark theme: sets `data-bs-theme="dark"` on the `<html>` tag, which
 *   activates Bootstrap 5.3+ built-in dark mode, and additionally injects
 *   the `dark-mode.css` stylesheet to neutralize the hardcoded light inline
 *   styles used throughout the Blade views.
 *
 * Theme resolution order:
 *   1. Authenticated user's `preferences['theme']` (persisted in DB).
 *   2. `theme` cookie (used for guests and as a fallback).
 *   3. Final fallback → `light`.
 *
 * The resolved theme is also exposed to the client via
 * `window.__unigrowthTheme` so the theme-toggle button can swap its icon.
 */
final class ApplyUserTheme
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        if ($response->isRedirect()) {
            return $response;
        }

        $contentType = $response->headers->get('Content-Type');
        if ($contentType === null || ! str_contains($contentType, 'text/html')) {
            return $response;
        }

        $content = $response->getContent();
        if ($content === null) {
            return $response;
        }

        $theme = $this->resolveTheme($request);

        // Set `data-bs-theme` on the <html> tag to activate Bootstrap 5.3+
        // built-in dark mode. We capture the existing attributes and rebuild
        // the opening tag with `data-bs-theme` added, so the original tag is
        // NOT duplicated (which previously produced a stray `>` at the top of
        // every rendered page).
        $content = preg_replace_callback(
            '/<html\b([^>]*)>/i',
            fn (array $matches): string => '<html data-bs-theme="' . $theme . '"' . ($matches[1] ?? '') . '>',
            $content,
            1,
            $replaced
        );

        if ($replaced === 0) {
            // Fallback: no <html> tag found — inject a wrapper right at the top.
            $content = '<html data-bs-theme="' . $theme . '">' . $content;
        }

        $injections = '';

        if ($theme === 'dark') {
            $injections .= "\n" . '<link rel="stylesheet" href="' . asset('css/dark-mode.css') . '">';
        }

        // Expose the active theme to JS (used by the theme-toggle partial).
        $injections .= "\n" . '<script>window.__unigrowthTheme = ' . json_encode($theme) . ';</script>' . "\n";

        if (str_contains($content, '</head>')) {
            $content = str_replace('</head>', $injections . '</head>', $content);
        } elseif (str_contains($content, '</body>')) {
            $content = str_replace('</body>', $injections . '</body>', $content);
        }

        $response->setContent($content);

        return $response;
    }

    private function resolveTheme(Request $request): string
    {
        $theme = null;

        // 1. Authenticated user preference (stored in users.preferences JSON).
        if (Auth::check()) {
            $theme = Auth::user()->preferences['theme'] ?? null;
        }

        // 2. Cookie fallback (guests, or authed users without a preference yet).
        if (! in_array($theme, ['light', 'dark'], true)) {
            $theme = $request->cookie('theme');
        }

        // 3. Final default → light.
        return in_array($theme, ['light', 'dark'], true) ? $theme : 'light';
    }
}

