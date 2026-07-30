<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Recommendation;

use App\Auth\Models\User;
use App\Core\Assets\Models\Enrollment;
use App\Core\Assets\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RecommendationEngineTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_authentication(): void
    {
        $response = $this->getJson('/api/recommendations');

        $response->assertStatus(401);
    }

    /** @test */
    public function it_returns_empty_recommendations_when_no_candidate_skills_exist(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/recommendations?limit=5');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [],
        ]);
    }

    /** @test */
    public function it_returns_recommendations_based_on_tag_intersection(): void
    {
        $user = User::factory()->create();

        // Create skills
        $phpSkill = Skill::create([
            'title' => 'PHP Advanced',
            'tags' => ['php', 'laravel', 'backend'],
            'description' => 'Advanced PHP techniques.',
            'content' => 'Content',
        ]);

        Skill::create([
            'title' => 'JavaScript Basics',
            'tags' => ['javascript', 'frontend'],
            'description' => 'Learn JS.',
            'content' => 'Content',
        ]);

        $matchedSkill = Skill::create([
            'title' => 'Laravel Testing',
            'tags' => ['php', 'testing', 'laravel'],
            'description' => 'Testing with Laravel.',
            'content' => 'Content',
        ]);

        // Enroll user in PHP skill to get tags: php, laravel, backend
        Enrollment::create([
            'user_id' => $user->id,
            'skill_id' => $phpSkill->id,
            'status' => 'active',
        ]);

        $response = $this->actingAs($user)->getJson('/api/recommendations?limit=5');

        $response->assertStatus(200);

        $data = $response->json('data');

        // Should recommend Laravel Testing (matching tags: php, laravel). JavaScript Basics has no match so it's filtered out.
        $this->assertCount(1, $data);

        $this->assertEquals('Laravel Testing', $data[0]['title']);
        $this->assertEquals(2, $data[0]['matching_tags_count']);
    }

    /** @test */
    public function it_respects_the_limit_parameter(): void
    {
        $user = User::factory()->create();

        // Create 3 skills
        Skill::create(['title' => 'Skill 1', 'tags' => ['tag1'], 'description' => 'Desc', 'content' => 'C']);
        Skill::create(['title' => 'Skill 2', 'tags' => ['tag2'], 'description' => 'Desc', 'content' => 'C']);
        Skill::create(['title' => 'Skill 3', 'tags' => ['tag3'], 'description' => 'Desc', 'content' => 'C']);

        $response = $this->actingAs($user)->getJson('/api/recommendations?limit=2');

        $response->assertStatus(200);

        $data = $response->json('data');

        $this->assertCount(2, $data);
    }

    /** @test */
    public function it_validates_limit_parameter_rules(): void
    {
        $user = User::factory()->create();

        // Test invalid limit: string instead of integer
        $response = $this->actingAs($user)->getJson('/api/recommendations?limit=abc');

        $response->assertStatus(422);

        // Test invalid limit: 0 (min is 1)
        $response = $this->actingAs($user)->getJson('/api/recommendations?limit=0');

        $response->assertStatus(422);

        // Test invalid limit: > 100 (max is 100)
        $response = $this->actingAs($user)->getJson('/api/recommendations?limit=101');

        $response->assertStatus(422);
    }

    /** @test */
    public function it_returns_cold_start_fallback_when_user_has_no_enrollments(): void
    {
        $user = User::factory()->create();

        Skill::create([
            'title' => 'Database Design',
            'tags' => ['sql', 'database'],
            'description' => 'DB principles.',
            'content' => 'Content',
        ]);

        Skill::create([
            'title' => 'Vue.js',
            'tags' => ['javascript', 'frontend'],
            'description' => 'Learn Vue.',
            'content' => 'Content',
        ]);

        $response = $this->actingAs($user)->getJson('/api/recommendations?limit=5');

        $response->assertStatus(200);

        $data = $response->json('data');

        // Cold-start: should return random skills with score 0
        $this->assertCount(2, $data);

        foreach ($data as $item) {
            $this->assertEquals(0, $item['score']);
            $this->assertEquals(0, $item['matching_tags_count']);
        }
    }
}
