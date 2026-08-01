<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

final class ApplyUserThemeTest extends TestCase
{
    private const HTML = '<html><head><title>Test</title></head><body><h1>Hello</h1></body></html>';

    // ---------------------------------------------------------------
    // Guest resolution
    // ---------------------------------------------------------------

    /** @test */
    public function it_defaults_to_light_theme_for_guests_without_any_setting(): void
    {
        Route::get('/_test-theme-guest-default', fn () => response(self::HTML))->middleware('web');

        $response = $this->get('/_test-theme-guest-default');

        $response->assertStatus(200);
        $this->assertStringContainsString('data-bs-theme="light"', $response->getContent());
        $this->assertStringNotContainsString('dark-mode.css', $response->getContent());
        $this->assertStringContainsString('"light"', $response->getContent());
    }

    /** @test */
    public function it_sets_dark_data_bs_theme_when_guest_has_dark_cookie(): void
    {
        Route::get('/_test-theme-guest-dark', fn () => response(self::HTML))->middleware('web');

        $response = $this->withCookie('theme', 'dark')->get('/_test-theme-guest-dark');

        $response->assertStatus(200);
        $this->assertStringContainsString('data-bs-theme="dark"', $response->getContent());
        $this->assertStringContainsString('dark-mode.css', $response->getContent());
        $this->assertStringContainsString('"dark"', $response->getContent());
    }

    // ---------------------------------------------------------------
    // Authenticated resolution (Auth facade mocked to avoid DB)
    // ---------------------------------------------------------------

    /** @test */
    public function it_applies_dark_theme_for_authenticated_user_with_dark_preference(): void
    {
        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($this->fakeUser(['theme' => 'dark']));

        Route::get('/_test-theme-authed-dark', fn () => response(self::HTML))->middleware('web');

        $response = $this->get('/_test-theme-authed-dark');

        $this->assertStringContainsString('data-bs-theme="dark"', $response->getContent());
        $this->assertStringContainsString('dark-mode.css', $response->getContent());
    }

    /** @test */
    public function it_applies_light_theme_for_authenticated_user_with_light_preference(): void
    {
        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($this->fakeUser(['theme' => 'light']));

        Route::get('/_test-theme-authed-light', fn () => response(self::HTML))->middleware('web');

        $response = $this->get('/_test-theme-authed-light');

        $this->assertStringContainsString('data-bs-theme="light"', $response->getContent());
        $this->assertStringNotContainsString('dark-mode.css', $response->getContent());
        $this->assertStringContainsString('"light"', $response->getContent());
    }

    /** @test */
    public function authenticated_user_preference_takes_priority_over_cookie(): void
    {
        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($this->fakeUser(['theme' => 'light']));

        Route::get('/_test-theme-priority', fn () => response(self::HTML))->middleware('web');

        $response = $this->withCookie('theme', 'dark')->get('/_test-theme-priority');

        $response->assertStatus(200);
        $this->assertStringContainsString('data-bs-theme="light"', $response->getContent());
        $this->assertStringNotContainsString('dark-mode.css', $response->getContent());
    }

    // ---------------------------------------------------------------
    // Guards
    // ---------------------------------------------------------------

    /** @test */
    public function it_skips_redirect_responses(): void
    {
        Route::get('/_test-theme-redirect', fn () => redirect('/login'))->middleware('web');

        $response = $this->get('/_test-theme-redirect');

        $response->assertRedirect('/login');
        $this->assertStringNotContainsString('dark-mode.css', $response->getContent());
        $this->assertStringNotContainsString('__unigrowthTheme', $response->getContent());
    }

    /** @test */
    public function html_tag_is_well_formed_without_stray_character(): void
    {
        Route::get('/_test-theme-wellformed', fn () => response(self::HTML))->middleware('web');

        $response = $this->withCookie('theme', 'dark')->get('/_test-theme-wellformed');

        $response->assertStatus(200);

        $html = $response->getContent();

        // The <html> opening tag must be rebuilt once, not duplicated, and it
        // must preserve the original attributes (self::HTML has none here, so
        // the result is a single clean `<html data-bs-theme="dark">`).
        $this->assertStringContainsString('<html data-bs-theme="dark">', $html);
        $this->assertSame(1, substr_count($html, '<html '));
        $this->assertSame(1, substr_count($html, '</html>'));

        // No stray `>` should appear before the real <html> tag.
        $pos = strpos($html, '<html');
        $before = substr($html, 0, $pos);
        $this->assertStringNotContainsString('>', $before);
    }

    /** @test */
    public function it_skips_non_html_responses(): void
    {
        Route::get('/_test-theme-json', fn () => response()->json(['ok' => true]))->middleware('web');

        $response = $this->get('/_test-theme-json');

        $response->assertOk();
        $this->assertStringNotContainsString('dark-mode.css', $response->getContent());
        $this->assertStringNotContainsString('__unigrowthTheme', $response->getContent());
    }

    // ---------------------------------------------------------------
    // Theme toggle endpoint
    // ---------------------------------------------------------------

    /** @test */
    public function theme_toggle_route_sets_dark_cookie_for_guests(): void
    {
        $response = $this->post('/theme', ['theme' => 'dark'], ['Referer' => '/login']);

        $response->assertRedirect('/login');
        $response->assertCookie('theme', 'dark');
    }

    /** @test */
    public function theme_toggle_route_sets_light_cookie_for_guests(): void
    {
        $response = $this->post('/theme', ['theme' => 'light'], ['Referer' => '/login']);

        $response->assertRedirect('/login');
        $response->assertCookie('theme', 'light');
    }

    /** @test */
    public function theme_toggle_route_rejects_invalid_theme_values(): void
    {
        $response = $this->post('/theme', ['theme' => 'neon'], ['Referer' => '/login']);

        $response->assertRedirect('/login');
        $response->assertCookieMissing('theme');
    }

    /** @test */
    public function theme_toggle_persists_preference_for_authenticated_user(): void
    {
        $user = $this->fakeUser(['theme' => 'light']);
        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($user);

        $response = $this->post('/theme', ['theme' => 'dark'], ['Referer' => '/profile']);

        $response->assertRedirect('/profile');
        $this->assertSame('dark', $user->preferences['theme']);
    }

    // ---------------------------------------------------------------
    // Helpers
    // ---------------------------------------------------------------

    /**
     * @param  array<string, mixed>  $preferences
     */
    private function fakeUser(array $preferences = []): object
    {
        return new class($preferences)
        {
            public array $preferences;

            public function __construct(array $preferences)
            {
                $this->preferences = $preferences;
            }

            public function forceFill(array $attributes): self
            {
                $this->preferences = $attributes['preferences'] ?? $this->preferences;

                return $this;
            }

            public function save(): bool
            {
                return true;
            }
        };
    }
}

