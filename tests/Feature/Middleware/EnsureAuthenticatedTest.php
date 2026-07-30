<?php

namespace Tests\Feature;

use App\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
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
        $user = User::factory()->create(['account_status' => 'allowed']);

        $this->actingAs($user)
             ->getJson('/test-auth')
             ->assertStatus(200);
    }

    /** @test */
    public function it_rejects_unverified_user()
    {
        $user = User::factory()->unverified()->create(['account_status' => 'allowed']);

        $this->actingAs($user)
             ->getJson('/test-auth')
             ->assertStatus(403)
             ->assertJson(['error' => 'Email not verified. Please verify your email before accessing this page.']);

        $this->assertGuest();
    }

    /** @test */
    public function it_rejects_inactive_user()
    {
        $user = User::factory()->create(['account_status' => 'banned']);

        $this->actingAs($user)
             ->getJson('/test-auth')
             ->assertStatus(403)
             ->assertJson(['error' => 'Forbidden. Your account is not active.']);
    }
}
