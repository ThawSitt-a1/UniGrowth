<?php

namespace Tests\Unit\Assessment;

use App\Assessment\Models\StudentSkill;
use App\Assessment\Repositories\AssessmentRepository;
use App\Assessment\Services\RankingAggregatorService;
use App\Auth\Models\User;
use App\Core\Assets\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RankingAggregatorServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Skill $skill;
    private RankingAggregatorService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['platform_score' => 0]);
        $this->skill = Skill::factory()->create(['title' => 'Test']);
        $repo = $this->app->make(AssessmentRepository::class);
        $this->service = new RankingAggregatorService($repo);
    }

    /** @test */
    public function it_calculates_weighted_score(): void
    {
        $this->assertEquals(100.0, $this->service->calculateWeightedScore('easy', 100.0));
        $this->assertEquals(200.0, $this->service->calculateWeightedScore('medium', 100.0));
        $this->assertEquals(300.0, $this->service->calculateWeightedScore('hard', 100.0));
    }

    /** @test */
    public function it_defaults_to_1x_multiplier_for_unknown_difficulty(): void
    {
        $this->assertEquals(85.0, $this->service->calculateWeightedScore('unknown', 85.0));
    }

    /** @test */
    public function it_updates_proficiency_and_platform_score(): void
    {
        $this->service->updateProficiencyAndPlatformScore(
            (int) $this->user->id,
            (int) $this->skill->id,
            85.5,
            42.0,
        );

        $this->assertDatabaseHas('student_skills', [
            'user_id' => $this->user->id,
            'skill_id' => $this->skill->id,
            'proficiency_score' => 85.5,
        ]);

        $this->user->refresh();
        $this->assertEquals(42.0, (float) $this->user->platform_score);
    }

    /** @test */
    public function it_accumulates_platform_score_across_multiple_skills(): void
    {
        $skill2 = Skill::factory()->create(['title' => 'Another Skill']);

        $this->service->updateProficiencyAndPlatformScore(
            (int) $this->user->id,
            (int) $this->skill->id,
            50.0,
            30.0,
        );

        $this->service->updateProficiencyAndPlatformScore(
            (int) $this->user->id,
            (int) $skill2->id,
            75.0,
            45.0,
        );

        $this->user->refresh();
        $this->assertEquals(75.0, (float) $this->user->platform_score);
    }
}
