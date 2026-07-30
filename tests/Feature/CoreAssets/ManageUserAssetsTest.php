<?php

declare(strict_types=1);

namespace Tests\Feature\CoreAssets;

use App\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ManageUserAssetsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_requests_are_rejected(): void
    {
        $this->post('/core-assets/action', [
            'type' => 'goal',
            'action' => 'create',
            'payload' => ['text' => 'Ship core-service'],
        ])->assertStatus(302)->assertRedirect('/login');

        $this->get('/core-assets')->assertStatus(302)->assertRedirect('/login');
    }

    /** @test */
    public function user_can_create_complete_and_delete_own_goals(): void
    {
       /** @var \App\Auth\Models\User $user */
       $user = User::factory()->create(['account_status' => 'allowed']);
       $this->actingAs($user);

        // Create
        $this->post('/core-assets/action', [
            'type' => 'goal',
            'action' => 'create',
            'payload' => ['text' => 'Ship core-service'],
        ])->assertStatus(302)->assertSessionHas('success');

        $goal = \App\Core\Assets\Models\Goal::query()->where('user_id', $user->id)->first();
        $this->assertNotNull($goal);
        $this->assertSame('active', $goal->status);

        // Complete
        $this->post('/core-assets/action', [
            'type' => 'goal',
            'action' => 'complete',
            'payload' => ['goal_id' => $goal->id],
        ])->assertStatus(302)->assertSessionHas('success');

        $goal->refresh();
        $this->assertSame('completed', $goal->status);
        $this->assertNotNull($goal->completed_at);

        // Delete
        $this->post('/core-assets/action', [
            'type' => 'goal',
            'action' => 'delete',
            'payload' => ['goal_id' => $goal->id],
        ])->assertStatus(302)->assertSessionHas('success');

        $this->assertDatabaseMissing('goals', ['id' => $goal->id]);
    }

    /** @test */
    public function user_cannot_create_skill_via_asset_action(): void
    {
        /** @var \App\Auth\Models\User $user */
        $user = User::factory()->create(['account_status' => 'allowed']);
        $this->actingAs($user);

        $this->post('/core-assets/action', [
            'type' => 'skill',
            'action' => 'create',
            'payload' => ['skill_id' => 999],
        ])->assertStatus(302)->assertSessionHas('error');
    }

    /** @test */
    public function user_can_enroll_in_a_skill(): void
    {
        /** @var \App\Auth\Models\User $user */
        $user = User::factory()->create(['account_status' => 'allowed']);
        $this->actingAs($user);

        // Admin pre-seeds skills. In tests we create one directly.
        $skill = \App\Core\Assets\Models\Skill::query()->create([
            'title' => 'PHP 8.2 Mastery',
            'tags' => ['php'],
            'description' => 'Learn and master PHP 8.2.',
            'content' => 'Content...',
            'resource_link' => null,
        ]);

        $this->post('/core-assets/action', [
            'type' => 'skill',
            'action' => 'enroll',
            'payload' => ['skill_id' => $skill->id],
        ])->assertStatus(302)->assertSessionHas('success');

        $this->assertDatabaseHas('enrolled_skills', [
            'user_id' => $user->id,
            'skill_id' => $skill->id,
        ]);
    }

    /** @test */
    public function user_can_view_own_activity_profile_on_index(): void
    {
        /** @var \App\Auth\Models\User $user */
        $user = User::factory()->create(['account_status' => 'allowed']);
        $this->actingAs($user);

        // Create a goal and enrollment to populate the profile
        \App\Core\Assets\Models\Goal::query()->create([
            'user_id' => $user->id,
            'text' => 'My test goal',
            'status' => 'active',
        ]);

        $skill = \App\Core\Assets\Models\Skill::query()->create([
            'title' => 'Laravel Testing',
            'tags' => ['php', 'testing'],
            'description' => 'Master Laravel testing.',
            'content' => 'Content...',
            'resource_link' => null,
        ]);

        \App\Core\Assets\Models\Enrollment::query()->create([
            'user_id' => $user->id,
            'skill_id' => $skill->id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        $response = $this->get('/core-assets')
            ->assertStatus(200);

        $response->assertSee('My test goal');
        $response->assertSee('Laravel Testing');
    }
}

