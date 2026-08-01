<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Assets\DTO\AssetActionDTO;
use App\Core\Assets\Models\Goal;
use App\Core\Assets\Repositories\EnrollmentRepositoryInterface;
use App\Core\Assets\Repositories\GoalRepositoryInterface;
use App\Core\Assets\Repositories\HabitRepositoryInterface;
use App\Core\Assets\UseCases\ManageUserAssetsUseCase;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

final class ManageUserAssetsUseCaseTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_creates_a_goal(): void
    {
        $user = Mockery::mock(Authenticatable::class);
        $user->shouldReceive('getAuthIdentifier')->once()->andReturn(1);

        Auth::shouldReceive('guard')
            ->with('web')
            ->once()
            ->andReturnSelf();
        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        $goalModel = new Goal();
        $goalModel->id = 1;
        $goalModel->status = 'active';

        $goalRepo = Mockery::mock(GoalRepositoryInterface::class);
        $goalRepo->shouldReceive('create')
            ->once()
            ->with([
                'user_id' => 1,
                'text' => 'Test goal',
                'status' => 'active',
                'completed_at' => null,
            ])
            ->andReturn($goalModel);

$enrollmentRepo = Mockery::mock(EnrollmentRepositoryInterface::class);
        $habitRepo = Mockery::mock(HabitRepositoryInterface::class);

        $useCase = new ManageUserAssetsUseCase($goalRepo, $enrollmentRepo, $habitRepo);

        $dto = new AssetActionDTO('goal', 'create', ['text' => 'Test goal']);

        $result = $useCase->execute($dto);

        $this->assertSame(1, $result['goal_id']);
        $this->assertSame('active', $result['status']);
    }

    /** @test */
    public function it_throws_runtime_exception_when_unauthenticated(): void
    {
        Auth::shouldReceive('guard')
            ->with('web')
            ->once()
            ->andReturnSelf();
        Auth::shouldReceive('user')
            ->once()
            ->andReturn(null);

        $goalRepo = Mockery::mock(GoalRepositoryInterface::class);
        $enrollmentRepo = Mockery::mock(EnrollmentRepositoryInterface::class);
        $habitRepo = Mockery::mock(HabitRepositoryInterface::class);

        $useCase = new ManageUserAssetsUseCase($goalRepo, $enrollmentRepo, $habitRepo);

        $dto = new AssetActionDTO('goal', 'create', ['text' => 'Test goal']);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unauthenticated.');

        $useCase->execute($dto);
    }

    /** @test */
    public function it_throws_runtime_exception_for_unsupported_action(): void
    {
        $user = Mockery::mock(Authenticatable::class);
        $user->shouldReceive('getAuthIdentifier')->once()->andReturn(1);

        Auth::shouldReceive('guard')
            ->with('web')
            ->once()
            ->andReturnSelf();
        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        $goalRepo = Mockery::mock(GoalRepositoryInterface::class);
        $enrollmentRepo = Mockery::mock(EnrollmentRepositoryInterface::class);
        $habitRepo = Mockery::mock(HabitRepositoryInterface::class);

        $useCase = new ManageUserAssetsUseCase($goalRepo, $enrollmentRepo, $habitRepo);

        $dto = new AssetActionDTO('goal', 'update', ['text' => 'Test']);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $this->expectExceptionMessage('Forbidden action for goals.');

        $useCase->execute($dto);
    }
}

