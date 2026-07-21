<?php

namespace Tests\Unit;

use App\Auth\DTOs\AuthCredentialsDTO;
use App\Auth\Repositories\UserRepositoryInterface;
use App\Auth\UseCases\AuthenticateUserUseCase;
use App\Models\User;
use App\Services\AuthSessionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Mockery\MockInterface;
use RuntimeException;
use Tests\TestCase;

class AuthenticateUserUseCaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_executes_successfully(): void
    {
        // Create a real user in the database
        $user = User::query()->create([
            'username' => 'john',
            'email' => 'john@example.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'user',
        ]);

        $repo = Mockery::mock(UserRepositoryInterface::class, function (MockInterface $mock) use ($user) {
            $mock->shouldReceive('findByEmail')
                ->once()
                ->with('john@example.com')
                ->andReturn([
                    'id' => $user->id,
                    'email' => 'john@example.com',
                    'role' => 'user',
                    'password_hash' => $user->password,
                    'session_id' => null,
                ]);
        });

        $authSessionService = $this->app->make(AuthSessionService::class);
        $userModel = new User();

        $useCase = new AuthenticateUserUseCase($repo, $authSessionService, $userModel);

        $dto = new AuthCredentialsDTO(
            email: 'john@example.com',
            password: 'Secret123!',
            username: 'john',
            remember: false,
        );

        $result = $useCase->execute($dto);

        $this->assertSame($user->id, $result['id']);
        $this->assertSame('john@example.com', $result['email']);
        $this->assertSame('user', $result['role']);

        // Verify the user is now authenticated in the session
        $this->assertAuthenticated();
    }

    public function test_it_throws_when_password_is_invalid(): void
    {
        $user = User::query()->create([
            'username' => 'john',
            'email' => 'john@example.com',
            'password' => Hash::make('Different123!'),
            'role' => 'user',
        ]);

        $repo = Mockery::mock(UserRepositoryInterface::class);
        $repo->shouldReceive('findByEmail')
            ->once()
            ->with('john@example.com')
            ->andReturn([
                'id' => $user->id,
                'email' => 'john@example.com',
                'role' => 'user',
                'password_hash' => $user->password,
                'session_id' => null,
            ]);

        $authSessionService = $this->app->make(AuthSessionService::class);
        $userModel = new User();

        $useCase = new AuthenticateUserUseCase($repo, $authSessionService, $userModel);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid credentials');

        $useCase->execute(new AuthCredentialsDTO(
            email: 'john@example.com',
            password: 'Secret123!',
            username: 'john',
        ));
    }
}

