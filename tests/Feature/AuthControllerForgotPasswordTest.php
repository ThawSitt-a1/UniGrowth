<?php

namespace Tests\Feature;

use App\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
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

    public function test_request_reset_generates_token_and_sends_email_when_user_exists(): void
    {
        Notification::fake();

        $user = User::query()->create([
            'username' => 'john',
            'email' => 'john@example.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'user',
        ]);

        $response = $this->postJson('/request-reset', [
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'If the email exists in our system, a password reset link has been sent.',
            ]);

        // Verify token exists in the password_resets table
        $this->assertDatabaseHas('password_resets', [
            'user_id' => $user->id,
        ]);

        // Assert that the password reset notification was sent to the user
        Notification::assertSentTo(
            $user,
            ResetPasswordNotification::class,
            function ($notification, $channels) {
                return in_array('mail', $channels);
            }
        );
    }

    public function test_request_reset_web_flow_redirects_with_message(): void
    {
        $user = User::query()->create([
            'username' => 'jane',
            'email' => 'jane@example.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'user',
        ]);

        $response = $this->post('/request-reset', [
            'email' => 'jane@example.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'If the email exists in our system, a password reset link has been sent.');
    }
}
