<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class EnsureAuthenticatedTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Route::get('/test-auth', function () {
            return response()->json(['message' => 'allowed']);
        })->middleware(\App\Http\Middleware\EnsureAuthenticated::class);
    }

    /** @test */
    public function it_allows_authenticated_active_user()
    {
        /** @var User $user */
        $user = User::factory()->create(['account_status' => 'allowed']);

        $this->actingAs($user)
             ->getJson('/test-auth')
             ->assertStatus(200);
    }

    /** @test */
    public function it_rejects_inactive_user()
    {
        /** @var User $user */
        $user = User::factory()->create(['account_status' => 'banned']);

        $this->actingAs($user)
             ->getJson('/test-auth')
             ->assertStatus(403)
             ->assertJson(['error' => 'Forbidden. Your account is not active.']);
    }

    /** @test */
    public function it_rejects_if_remember_token_mismatch()
    {
        /** @var User $user */
        $user = User::factory()->create(['account_status' => 'allowed', 'remember_token' => 'correct-token']);

        // 1. Mock the session data
        session(['login_via_remember' => true, 'remember_token' => 'wrong-token']);

        // 2. IMPORTANT: Mock the Auth Guard to return true for viaRemember()
        Auth::shouldReceive('guard')->with('web')->andReturnSelf();
        Auth::shouldReceive('viaRemember')->andReturn(true);

        $this->actingAs($user);

        // 3. This should now fail because 'wrong-token' !== 'correct-token'
        $this->getJson('/test-auth')
             ->assertStatus(401)
             ->assertJson(['error' => 'Invalid or expired session token.']);
    }
}
