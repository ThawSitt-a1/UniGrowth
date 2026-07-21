<?php

declare(strict_types=1);

namespace Tests\Feature\CoreAssets;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ManageUserAssetsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_requests_are_rejected(): void
    {


        $this->postJson('/core-assets/action', [
            'type' => 'goal',
            'action' => 'create',
            'payload' => ['text' => 'Ship core-service'],
        ])->assertStatus(401);
    }

    /** @test */
    public function user_can_create_complete_and_delete_own_goals(): void
    {
       /** @var \App\Models\User $user */
       $user = User::factory()->create(['account_status' => 'allowed']);
       $this->actingAs($user);

        $create = $this->postJson('/core-assets/action', [
            'type' => 'goal',
            'action' => 'create',
            'payload' => ['text' => 'Ship core-service'],
        ])->assertStatus(200)->json();

        $goalId = (int) $create['goal_id'];
        $this->assertSame('active', $create['status']);

        $complete = $this->postJson('/core-assets/action', [
            'type' => 'goal',
            'action' => 'complete',
            'payload' => ['goal_id' => $goalId],
        ])->assertStatus(200)->json();

        $this->assertSame('completed', $complete['status']);
        $this->assertArrayHasKey('completed_at', $complete);

        $delete = $this->postJson('/core-assets/action', [
            'type' => 'goal',
            'action' => 'delete',
            'payload' => ['goal_id' => $goalId],
        ])->assertStatus(200)->json();

        $this->assertTrue((bool) $delete['deleted']);
    }

    /** @test */
    public function user_cannot_create_skill_via_asset_action(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['account_status' => 'allowed']);
        $this->actingAs($user);

        $this->postJson('/core-assets/action', [
            'type' => 'skill',
            'action' => 'create',
            'payload' => [],
        ])->assertStatus(403);
    }

    /** @test */
    public function user_can_enroll_in_a_skill(): void
    {
        /** @var \App\Models\User $user */
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

        $enroll = $this->postJson('/core-assets/action', [
            'type' => 'skill',
            'action' => 'enroll',
            'payload' => ['skill_id' => $skill->id],
        ])->assertStatus(200)->json();

        $this->assertSame($skill->id, (int) $enroll['skill_id']);
        $this->assertSame('active', $enroll['status']);
    }
}

