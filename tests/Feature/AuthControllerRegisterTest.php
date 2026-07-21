<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthControllerRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_returns_422_for_invalid_payload(): void
    {
        Http::fake();

        $response = $this->postJson('/register', [
            'username' => '',
            'email' => 'not-an-email',
            'password' => 'short',
            // missing g-recaptcha-response
        ]);

        $response->assertStatus(422);
    }

    public function test_register_happy_path_returns_user_json_shape(): void
    {
        Http::fake(function () {
            return Http::response(['success' => true], 200);
        });

        $response = $this->postJson('/register', [
            'username' => 'johnny',
            'email' => 'johnny@example.com',
            'password' => 'Secret123456!',
            'password_confirmation' => 'Secret123456!',
            'g-recaptcha-response' => 'test-token',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => ['id', 'username', 'email', 'role'],
            ]);
    }

    public function test_register_web_redirects_to_dashboard_and_authenticates(): void
    {
        Http::fake(function () {
            return Http::response(['success' => true], 200);
        });

        $response = $this->post('/register', [
            'username' => 'janedoe',
            'email' => 'jane@example.com',
            'password' => 'Secret123456!',
            'password_confirmation' => 'Secret123456!',
            'g-recaptcha-response' => 'test-token',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }
}


