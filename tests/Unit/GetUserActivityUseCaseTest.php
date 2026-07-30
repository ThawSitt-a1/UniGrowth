<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Assets\Repositories\UserRepositoryInterface;
use App\Core\Assets\UseCases\GetUserActivityUseCase;
use Mockery;
use Tests\TestCase;

final class GetUserActivityUseCaseTest extends TestCase
{
    /** @test */
    public function it_returns_user_activity_profile(): void
    {
        $expectedProfile = [
            'id' => 1,
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'enrolled_skills' => [
                ['skill_id' => 1, 'skill_title' => 'PHP 8.2', 'status' => 'active', 'enrolled_at' => '2026-01-01T00:00:00Z'],
            ],
            'goals' => [
                ['id' => 1, 'text' => 'Ship core-service', 'status' => 'active', 'completed_at' => null],
            ],
        ];

        $mockRepo = Mockery::mock(UserRepositoryInterface::class);
        $mockRepo->shouldReceive('fetchActivityProfile')
            ->once()
            ->with(1)
            ->andReturn($expectedProfile);

        $useCase = new GetUserActivityUseCase($mockRepo);

        $result = $useCase->execute(1);

        $this->assertSame($expectedProfile, $result);
    }
}

