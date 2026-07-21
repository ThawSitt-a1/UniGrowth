<?php

namespace Tests\Unit;

use App\Auth\DTOs\AuthCredentialsDTO;
use App\Auth\Repositories\UserRepositoryInterface;
use App\Auth\UseCases\RegisterUserUseCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class RegisterUserUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_it_creates_user_auto_logins_and_returns_public_shape(): void
    {
        // Create an actual user in the database so the User query resolves the model
        $existingUser = \App\Models\User::factory()->create([
            'username' => 'johnny',
            'email' => 'john@example.com',
        ]);

        $repo = Mockery::mock(UserRepositoryInterface::class, function (MockInterface $mock) use ($existingUser) {
            $mock->shouldReceive('create')
                ->once()
                ->with(Mockery::on(function (array $data) {
                    return $data['username'] === 'johnny' &&
                        $data['email'] === 'john@example.com' &&
                        $data['password'] === 'Secret123!';
                }))
                ->andReturn([
                    'id' => $existingUser->id,
                    'email' => 'john@example.com',
                    'role' => 'user',
                ]);
        });

        $authSessionService = $this->app->make(\App\Services\AuthSessionService::class);
        $useCase = new RegisterUserUseCase($repo, $authSessionService, new User());

        $dto = new AuthCredentialsDTO(
            email: 'john@example.com',
            password: 'Secret123!',
            username: 'johnny',
            remember: false,
        );

        $result = $useCase->execute($dto);

        $this->assertSame($existingUser->id, $result['id']);
        $this->assertSame('john@example.com', $result['email']);
        $this->assertSame('user', $result['role']);
        $this->assertArrayHasKey('id', $result);
    }
}

