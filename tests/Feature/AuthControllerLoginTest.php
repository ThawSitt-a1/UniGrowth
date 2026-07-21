<?php

namespace Tests\Feature;

use App\Models\User;
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
}

