<?php

namespace Tests\Feature;

use App\Auth\Models\User;
use App\Auth\Models\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::query()->create([
            'username' => 'john',
            'email' => 'john@example.com',
            'password' => Hash::make('OldPassword123!'),
            'role' => 'user',
        ]);

        // Generate a reset token directly via the use case through the controller
        $this->postJson('/request-reset', [
            'email' => $this->user->email,
        ]);

        // Retrieve the token from the database
        $resetRecord = PasswordReset::query()->where('user_id', $this->user->id)->first();
        $this->assertNotNull($resetRecord);
        $this->token = $resetRecord->token;
    }

    public function test_request_reset_generates_token(): void
    {
        $response = $this->postJson('/request-reset', [
            'email' => $this->user->email,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'If the email exists in our system, a password reset link has been sent.',
            ]);

        // Verify token exists in the password_resets table
        $this->assertDatabaseHas('password_resets', [
            'user_id' => $this->user->id,
        ]);
    }

    public function test_it_resets_password_successfully(): void
    {
        $response = $this->postJson('/reset-password', [
            'token' => $this->token,
            'email' => $this->user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Password has been reset successfully. You are now logged in.',
            ]);

        // Verify the password was actually changed
        $this->assertTrue(
            password_verify('NewPassword123!', $this->user->fresh()->password)
        );

        // Verify the old password no longer works
        $this->assertFalse(
            password_verify('OldPassword123!', $this->user->fresh()->password)
        );

        // Verify the token was deleted
        $this->assertDatabaseMissing('password_resets', [
            'user_id' => $this->user->id,
        ]);
    }

    public function test_it_returns_error_with_invalid_token(): void
    {
        $response = $this->postJson('/reset-password', [
            'token' => 'invalid-token-here',
            'email' => $this->user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Invalid or expired reset token.',
            ]);

        // Verify password was NOT changed
        $this->assertTrue(
            password_verify('OldPassword123!', $this->user->fresh()->password)
        );
    }

    public function test_it_returns_error_with_missing_fields(): void
    {
        $response = $this->postJson('/reset-password', [
            'token' => $this->token,
            'email' => $this->user->email,
            // missing password and password_confirmation
        ]);

        $response->assertStatus(422);
    }

    public function test_it_returns_error_when_passwords_do_not_match(): void
    {
        $response = $this->postJson('/reset-password', [
            'token' => $this->token,
            'email' => $this->user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'DifferentPassword456!',
        ]);

        $response->assertStatus(422);
    }

    public function test_it_returns_error_with_non_existent_email(): void
    {
        $response = $this->postJson('/reset-password', [
            'token' => $this->token,
            'email' => 'does-not-exist@example.com',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $response->assertStatus(422); // validation: exists:users,email
    }

    public function test_it_auto_logs_in_after_password_reset(): void
    {
        $this->postJson('/reset-password', [
            'token' => $this->token,
            'email' => $this->user->email,
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        // Assert the user IS now authenticated (auto-logged in after reset)
        $this->assertAuthenticated();
    }
}
