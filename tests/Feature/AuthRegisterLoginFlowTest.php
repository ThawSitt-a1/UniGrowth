<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthRegisterLoginFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_register_then_login_flow(): void
    {
        Http::fake(function () {
            return Http::response(['success' => true], 200);
        });

        // Step 1: Register
        $registerResponse = $this->postJson('/register', [
            'username' => 'flowuser',
            'email' => 'flowuser@example.com',
            'password' => 'StrongPass123!',
            'password_confirmation' => 'StrongPass123!',
            'g-recaptcha-response' => 'test-token',
        ]);

        $registerResponse->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'user' => ['id', 'username', 'email', 'role'],
            ]);

        // Step 2: Manually verify email (simulates clicking verification link)
        $user = \App\Auth\Models\User::query()->where('email', 'flowuser@example.com')->first();
        $this->assertNotNull($user);
        $user->markEmailAsVerified();

        // Step 3: Login with the SAME credentials used to register
        $loginResponse = $this->postJson('/login', [
            'email' => 'flowuser@example.com',
            'password' => 'StrongPass123!',
            'g-recaptcha-response' => 'test-token',
        ]);

        // Debug: dump response if login fails
        if ($loginResponse->status() !== 200) {
            dump("Login failed with status: " . $loginResponse->status());
            dump("Response: " . $loginResponse->getContent());

            // Check what's stored
            $storedUser = \App\Auth\Models\User::query()->where('email', 'flowuser@example.com')->first();
            dump("Stored password hash prefix: " . substr($storedUser->password, 0, 20));
            dump("Hash::check result: " . (\Illuminate\Support\Facades\Hash::check('StrongPass123!', $storedUser->password) ? 'TRUE' : 'FALSE'));
            dump("Email verified: " . ($storedUser->hasVerifiedEmail() ? 'TRUE' : 'FALSE'));
        }

        $loginResponse->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'user' => ['id', 'username', 'email', 'role'],
            ]);
    }
}
