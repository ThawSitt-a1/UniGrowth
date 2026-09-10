<?php

declare(strict_types=1);

namespace Tests\Feature\CoreAssets;

use App\Auth\Models\User;
use App\Core\Assets\Models\Enrollment;
use App\Core\Assets\Models\Goal;
use App\Core\Assets\Models\Skill;
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
        /** @var User $user */
        $user = User::factory()->create(['account_status' => 'allowed']);
        $this->actingAs($user);

        // Create
        $this->post('/core-assets/action', [
            'type' => 'goal',
            'action' => 'create',
            'payload' => ['text' => 'Ship core-service'],
        ])->assertStatus(302)->assertSessionHas('success');

        $goal = Goal::query()->where('user_id', $user->id)->first();
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
        /** @var User $user */
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
        /** @var User $user */
        $user = User::factory()->create(['account_status' => 'allowed']);
        $this->actingAs($user);

        // Admin pre-seeds skills. In tests we create one directly.
        $skill = Skill::query()->create([
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
    public function user_can_unenroll_from_an_enrolled_skill(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['account_status' => 'allowed']);
        $this->actingAs($user);

        $skill = Skill::query()->create([
            'title' => 'PHP 8.2 Mastery',
            'tags' => ['php'],
            'description' => 'Learn and master PHP 8.2.',
            'content' => 'Content...',
            'resource_link' => null,
        ]);

        Enrollment::query()->create([
            'user_id' => $user->id,
            'skill_id' => $skill->id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        $this->assertDatabaseHas('enrolled_skills', [
            'user_id' => $user->id,
            'skill_id' => $skill->id,
        ]);

        $this->post('/core-assets/action', [
            'type' => 'skill',
            'action' => 'unenroll',
            'payload' => ['skill_id' => $skill->id],
        ])->assertStatus(302)->assertSessionHas('success', 'You have been unenrolled from this skill.');

        $this->assertDatabaseMissing('enrolled_skills', [
            'user_id' => $user->id,
            'skill_id' => $skill->id,
        ]);
    }

    /** @test */
    public function unenrolling_from_a_skill_user_is_not_enrolled_in_returns_error(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['account_status' => 'allowed']);
        $this->actingAs($user);

        $skill = Skill::query()->create([
            'title' => 'Unrelated Skill',
            'tags' => ['php'],
            'description' => 'Some skill the user has not enrolled in.',
            'content' => 'Content...',
            'resource_link' => null,
        ]);

        $this->post('/core-assets/action', [
            'type' => 'skill',
            'action' => 'unenroll',
            'payload' => ['skill_id' => $skill->id],
        ])->assertStatus(302)->assertSessionHas('error');

        $this->assertDatabaseMissing('enrolled_skills', [
            'user_id' => $user->id,
            'skill_id' => $skill->id,
        ]);
    }

    /** @test */
    public function user_cannot_unenroll_another_users_skill_enrollment(): void
    {
        /** @var User $owner */
        $owner = User::factory()->create(['account_status' => 'allowed']);
        $otherUser = User::factory()->create(['account_status' => 'allowed']);

        $skill = Skill::query()->create([
            'title' => 'Owner Only Skill',
            'tags' => ['php'],
            'description' => 'Skill only the owner is enrolled in.',
            'content' => 'Content...',
            'resource_link' => null,
        ]);

        Enrollment::query()->create([
            'user_id' => $owner->id,
            'skill_id' => $skill->id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        $this->actingAs($otherUser);

        $this->post('/core-assets/action', [
            'type' => 'skill',
            'action' => 'unenroll',
            'payload' => ['skill_id' => $skill->id],
        ])->assertStatus(302)->assertSessionHas('error');

        $this->assertDatabaseHas('enrolled_skills', [
            'user_id' => $owner->id,
            'skill_id' => $skill->id,
        ]);
    }

    /** @test */
    public function user_can_view_own_activity_profile_on_index(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['account_status' => 'allowed']);
        $this->actingAs($user);

        // Create a goal and enrollment to populate the profile
        Goal::query()->create([
            'user_id' => $user->id,
            'text' => 'My test goal',
            'status' => 'active',
        ]);

        $skill = Skill::query()->create([
            'title' => 'Laravel Testing',
            'tags' => ['php', 'testing'],
            'description' => 'Master Laravel testing.',
            'content' => 'Content...',
            'resource_link' => null,
        ]);

        Enrollment::query()->create([
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
