<?php

namespace App\Http\Middleware;

use App\Admin\Services\SystemSettingsServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnforceSystemSettings
{
    public function __construct(private readonly SystemSettingsServiceInterface $systemSettings)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->systemSettings->isMaintenanceModeEnabled()) {
            if ($this->shouldBlockForMaintenance($request)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'The platform is currently under maintenance. Please try again later.',
                    ], 503);
                }

                return redirect()->route('maintenance');
            }
        }

        if ($this->isRegistrationRoute($request) && ! $this->systemSettings->isRegistrationAllowed()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'User registration is currently disabled.',
                ], 403);
            }

            return redirect()->route('login')->with('error', 'User registration is currently disabled.');
        }

        if ($this->systemSettings->isFeatureKillSkillsEnabled() && $this->isSkillRoute($request)) {
            return $this->featureKilledResponse($request, 'Skills are temporarily disabled by an administrator.');
        }

        if ($this->systemSettings->isFeatureKillGoalsHabitsEnabled() && $this->isGoalsHabitsRoute($request)) {
            return $this->featureKilledResponse($request, 'Goals and habits are temporarily disabled by an administrator.');
        }

        if ($this->systemSettings->isFeatureKillQuizEnabled() && $this->isQuizRoute($request)) {
            return $this->featureKilledResponse($request, 'Quiz access is temporarily disabled by an administrator.');
        }

        if ($this->systemSettings->isFeatureKillSeasonEnabled() && $this->isSeasonRoute($request)) {
            return $this->featureKilledResponse($request, 'Season and competition features are temporarily disabled by an administrator.');
        }

        return $next($request);
    }

    private function featureKilledResponse(Request $request, string $message): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
            ], 503);
        }

        return response()->view('maintenance', [
            'platformName' => $this->systemSettings->getPlatformName(),
            'message' => $message,
        ], 503);
    }

    private function shouldBlockForMaintenance(Request $request): bool
    {
        if ($request->routeIs('maintenance')) {
            return false;
        }

        if ($request->is('admin*')) {
            $user = $request->user();
            return $user === null || ($user->role ?? '') !== 'admin';
        }

        return true;
    }

    private function isRegistrationRoute(Request $request): bool
    {
        return $request->is('register') || $request->routeIs('register');
    }

    /**
     * Skill-specific routes (browsing, detail, and skill enroll/unenroll actions).
     * The Goals & Habits page and goal/habit actions are intentionally NOT
     * matched here so they remain accessible when only Skills are disabled.
     */
    private function isSkillRoute(Request $request): bool
    {
        // Skill browse & detail pages
        if ($request->is('core-assets/skills') || $request->is('core-assets/skills/*')) {
            return true;
        }

        // Skill enroll/unenroll via POST /core-assets/action (type=skill)
        if ($request->isMethod('POST') && $request->is('core-assets/action')) {
            return $request->input('type') === 'skill';
        }

        return false;
    }

    /**
     * Goals & Habits routes (page + goal/habit create/complete/delete actions).
     */
    private function isGoalsHabitsRoute(Request $request): bool
    {
        // Goals & Habits page (GET /core-assets)
        if ($request->isMethod('GET') && $request->is('core-assets')) {
            return true;
        }

        // Goal / habit actions via POST /core-assets/action (type=goal|habit)
        if ($request->isMethod('POST') && $request->is('core-assets/action')) {
            $type = $request->input('type');
            return $type === 'goal' || $type === 'habit';
        }

        return false;
    }

    private function isQuizRoute(Request $request): bool
    {
        return $request->routeIs('api.skills.*') || $request->routeIs('assessment.test.*');
    }

    private function isSeasonRoute(Request $request): bool
    {
        return $request->routeIs('overview.*') || $request->routeIs('season.*') || $request->routeIs('api.seasons.*');
    }
}
