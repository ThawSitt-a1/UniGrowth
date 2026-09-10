<?php

namespace Tests\Feature;

use App\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthControllerLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_invalid_credentials_returns_401(): void
    {
        Http::fake(function () {
            return Http::response(['success' => true], 200);
        });

        User::query()->create([
            'username' => 'john',
            'email' => 'john@example.com',
            'password' => Hash::make('CorrectPassword1!'),
            'role' => 'user',
        ]);

        $response = $this->postJson('/login', [
            'email' => 'john@example.com',
            'password' => 'WrongPassword1!',
            'g-recaptcha-response' => 'test-token',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials.',
            ]);
    }

    public function test_login_with_valid_credentials_succeeds(): void
    {
        Http::fake(function () {
            return Http::response(['success' => true], 200);
        });

        User::query()->create([
            'username' => 'john',
            'email' => 'john@example.com',
            'password' => Hash::make('CorrectPassword1!'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $response = $this->postJson('/login', [
            'email' => 'john@example.com',
            'password' => 'CorrectPassword1!',
            'g-recaptcha-response' => 'test-token',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'user' => ['id', 'username', 'email', 'role'],
            ]);

        // Verify user is now authenticated
        $this->assertAuthenticated();
    }

    public function test_login_with_nonexistent_email_returns_422(): void
    {
        Http::fake(function () {
            return Http::response(['success' => true], 200);
        });

        $response = $this->postJson('/login', [
            'email' => 'doesnotexist@example.com',
            'password' => 'SomePassword1!',
            'g-recaptcha-response' => 'test-token',
        ]);

        $response->assertStatus(422); // validation: exists:users,email
    }

    public function test_login_with_unverified_email_returns_401(): void
    {
        Http::fake(function () {
            return Http::response(['success' => true], 200);
        });

        // Create user with unverified email (email_verified_at = null)
        User::query()->create([
            'username' => 'unverifieduser',
            'email' => 'unverified@example.com',
            'password' => Hash::make('CorrectPassword1!'),
            'role' => 'user',
            'email_verified_at' => null,
        ]);

        $response = $this->postJson('/login', [
            'email' => 'unverified@example.com',
            'password' => 'CorrectPassword1!',
            'g-recaptcha-response' => 'test-token',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials.',
            ]);

        // Verify the user is NOT authenticated
        $this->assertGuest();
    }

    public function test_login_with_banned_account_returns_banned_message(): void
    {
        Http::fake(function () {
            return Http::response(['success' => true], 200);
        });

        User::query()->create([
            'username' => 'banneduser',
            'email' => 'banned@example.com',
            'password' => Hash::make('CorrectPassword1!'),
            'role' => 'user',
            'email_verified_at' => now(),
            'account_status' => 'banned',
        ]);

        $response = $this->postJson('/login', [
            'email' => 'banned@example.com',
            'password' => 'CorrectPassword1!',
            'g-recaptcha-response' => 'test-token',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'You are banned due to violation of our policy. Contact ourcompany@gmail.com',
            ]);

        $this->assertGuest();
    }

    public function test_login_with_suspended_account_returns_suspended_message(): void
    {
        Http::fake(function () {
            return Http::response(['success' => true], 200);
        });

        User::query()->create([
            'username' => 'suspendeduser',
            'email' => 'suspended@example.com',
            'password' => Hash::make('CorrectPassword1!'),
            'role' => 'user',
            'email_verified_at' => now(),
            'account_status' => 'suspended',
            'suspended_until' => now()->addDays(7),
        ]);

        $response = $this->postJson('/login', [
            'email' => 'suspended@example.com',
            'password' => 'CorrectPassword1!',
            'g-recaptcha-response' => 'test-token',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Your account has been suspended due to a policy violation. Contact ourcompany@gmail.com',
            ]);

        $this->assertGuest();
    }
}
