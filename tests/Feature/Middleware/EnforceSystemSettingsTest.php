<?php

declare(strict_types=1);

namespace Tests\Feature\Middleware;

use App\Admin\Services\SystemSettingsServiceInterface;
use App\Auth\Models\User;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

final class EnforceSystemSettingsTest extends TestCase
{
    private const SKILLS_HTML = '<html><body><h1>Skills Index</h1></body></html>';
    private const GOALS_HTML = '<html><body><h1>Goals & Habits</h1></body></html>';
    private const SKILL_DETAIL_HTML = '<html><body><h1>Skill Detail</h1></body></html>';

    // ---------------------------------------------------------------
    // Helpers
    // ---------------------------------------------------------------

    /**
     * Register a temporary route with the full 'web' middleware group so
     * EnforceSystemSettings runs.
     */
    private function registerRoute(string $uri, string $content, string $name = ''): void
    {
        Route::get($uri, fn () => response($content))
            ->middleware('web')
            ->name($name);
    }

    private function registerPostRoute(string $uri, string $name = ''): void
    {
        Route::post($uri, fn () => response('OK'))
            ->middleware('web')
            ->name($name);
    }

/**
     * Swap the SystemSettingsServiceInterface binding with a mock that
     * returns configured values, using Laravel's test helper.
     *
     * @param  array<string, bool>  $settings
     */
    private function mockSettings(array $settings): void
    {
        $this->mock(SystemSettingsServiceInterface::class, function ($mock) use ($settings): void {
            // Default all kill switches to false
            $mock->shouldReceive('isFeatureKillSkillsEnabled')->andReturn($settings['feature_kill_skills'] ?? false);
            $mock->shouldReceive('isFeatureKillGoalsHabitsEnabled')->andReturn($settings['feature_kill_goals_habits'] ?? false);
            $mock->shouldReceive('isFeatureKillQuizEnabled')->andReturn(false);
            $mock->shouldReceive('isFeatureKillSeasonEnabled')->andReturn(false);
            $mock->shouldReceive('isMaintenanceModeEnabled')->andReturn(false);
            $mock->shouldReceive('isRegistrationAllowed')->andReturn(true);
            $mock->shouldReceive('getPlatformName')->andReturn('UniGrowth');
        });
    }

    // ---------------------------------------------------------------
    // Skills kill switch — must block ONLY skill routes
    // ---------------------------------------------------------------

    /** @test */
    public function skills_disabled_blocks_skill_browse_page(): void
    {
        $this->mockSettings(['feature_kill_skills' => true]);
        $this->registerRoute('core-assets/skills', self::SKILLS_HTML);

        $response = $this->get('core-assets/skills');

        $response->assertStatus(503);
        $response->assertSee('Skills are temporarily disabled');
    }

/** @test */
    public function skills_disabled_blocks_skill_detail_page(): void
    {
        $user = User::factory()->make();

        $this->mockSettings(['feature_kill_skills' => true]);
        $this->registerRoute('core-assets/skills/1', self::SKILL_DETAIL_HTML);

        $response = $this->actingAs($user)->get('core-assets/skills/1');

        $response->assertStatus(503);
        $response->assertSee('Skills are temporarily disabled');
    }

    /** @test */
    public function skills_disabled_blocks_skill_enroll_action(): void
    {
        $this->mockSettings(['feature_kill_skills' => true]);
        $this->registerPostRoute('core-assets/action');

        $response = $this->post('core-assets/action', ['type' => 'skill']);

        $response->assertStatus(503);
        $response->assertSee('Skills are temporarily disabled');
    }

    /** @test */
    public function skills_disabled_allows_goals_and_habits_page(): void
    {
        $this->mockSettings(['feature_kill_skills' => true]);
        $this->registerRoute('core-assets', self::GOALS_HTML);

        $response = $this->get('core-assets');

$response->assertStatus(200);
        $response->assertSee('Goals');
        $response->assertSee('Habits');
        $response->assertDontSee('Skills are temporarily disabled');
    }

    /** @test */
    public function skills_disabled_allows_goal_create_action(): void
    {
        $this->mockSettings(['feature_kill_skills' => true]);
        $this->registerPostRoute('core-assets/action');

        $response = $this->post('core-assets/action', ['type' => 'goal']);

        $response->assertStatus(200);
        $response->assertSee('OK');
    }

    /** @test */
    public function skills_disabled_allows_habit_complete_action(): void
    {
        $this->mockSettings(['feature_kill_skills' => true]);
        $this->registerPostRoute('core-assets/action');

        $response = $this->post('core-assets/action', ['type' => 'habit']);

        $response->assertStatus(200);
        $response->assertSee('OK');
    }

    // ---------------------------------------------------------------
    // Goals & Habits kill switch — must block ONLY goals/habits routes
    // ---------------------------------------------------------------

    /** @test */
    public function goals_habits_disabled_blocks_goals_habits_page(): void
    {
        $this->mockSettings(['feature_kill_goals_habits' => true]);
        $this->registerRoute('core-assets', self::GOALS_HTML);

        $response = $this->get('core-assets');

        $response->assertStatus(503);
        $response->assertSee('Goals and habits are temporarily disabled');
    }

    /** @test */
    public function goals_habits_disabled_blocks_goal_create_action(): void
    {
        $this->mockSettings(['feature_kill_goals_habits' => true]);
        $this->registerPostRoute('core-assets/action');

        $response = $this->post('core-assets/action', ['type' => 'goal']);

        $response->assertStatus(503);
        $response->assertSee('Goals and habits are temporarily disabled');
    }

    /** @test */
    public function goals_habits_disabled_blocks_habit_complete_action(): void
    {
        $this->mockSettings(['feature_kill_goals_habits' => true]);
        $this->registerPostRoute('core-assets/action');

        $response = $this->post('core-assets/action', ['type' => 'habit']);

        $response->assertStatus(503);
        $response->assertSee('Goals and habits are temporarily disabled');
    }

    /** @test */
    public function goals_habits_disabled_allows_skill_browse_page(): void
    {
        $this->mockSettings(['feature_kill_goals_habits' => true]);
        $this->registerRoute('core-assets/skills', self::SKILLS_HTML);

        $response = $this->get('core-assets/skills');

        $response->assertStatus(200);
        $response->assertSee('Skills Index');
    }

    /** @test */
    public function goals_habits_disabled_allows_skill_enroll_action(): void
    {
        $this->mockSettings(['feature_kill_goals_habits' => true]);
        $this->registerPostRoute('core-assets/action');

        $response = $this->post('core-assets/action', ['type' => 'skill']);

        $response->assertStatus(200);
        $response->assertSee('OK');
    }

    // ---------------------------------------------------------------
    // Both enabled — all routes accessible
    // ---------------------------------------------------------------

    /** @test */
    public function all_features_enabled_allows_all_routes(): void
    {
        $this->mockSettings([
            'feature_kill_skills' => false,
            'feature_kill_goals_habits' => false,
        ]);

        $this->registerRoute('core-assets', self::GOALS_HTML);
        $this->registerRoute('core-assets/skills', self::SKILLS_HTML);
        $this->registerPostRoute('core-assets/action');

        $this->get('core-assets')->assertStatus(200);
        $this->get('core-assets/skills')->assertStatus(200);
        $this->post('core-assets/action', ['type' => 'goal'])->assertStatus(200);
        $this->post('core-assets/action', ['type' => 'habit'])->assertStatus(200);
        $this->post('core-assets/action', ['type' => 'skill'])->assertStatus(200);
    }

    // ---------------------------------------------------------------
    // Unrelated action type (not goal/habit/skill) — not blocked
    // ---------------------------------------------------------------

    /** @test */
    public function action_with_unknown_type_is_not_blocked_by_either_kill_switch(): void
    {
        $this->mockSettings([
            'feature_kill_skills' => true,
            'feature_kill_goals_habits' => true,
        ]);

        $this->registerPostRoute('core-assets/action');

        $response = $this->post('core-assets/action', ['type' => 'unknown']);

        $response->assertStatus(200);
        $response->assertSee('OK');
    }
}
