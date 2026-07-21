<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_request_reset_returns_error_for_nonexistent_email(): void
    {
        $response = $this->postJson('/request-reset', [
            'email' => 'does-not-exist@example.com',
        ]);

        $response->assertStatus(422); // validation: exists:users,email
    }

    public function test_request_reset_generates_token_when_user_exists(): void
    {
        $user = User::query()->create([
            'username' => 'john',
            'email' => 'john@example.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'user',
        ]);

        $response = $this->postJson('/request-reset', [
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('password_resets', [
            'user_id' => $user->id,
        ]);
    }
}

