<?php

declare(strict_types=1);

namespace App\Core\Assets\UseCases;

use App\Core\Assets\DTO\AssetActionDTO;
use App\Core\Assets\Repositories\EnrollmentRepositoryInterface;
use App\Core\Assets\Repositories\GoalRepositoryInterface;
use App\Core\Assets\Models\Enrollment;
use App\Core\Assets\Models\Skill;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

final class ManageUserAssetsUseCase
{
    public function __construct(
        private readonly GoalRepositoryInterface $goalRepository,
        private readonly EnrollmentRepositoryInterface $enrollmentRepository,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function execute(AssetActionDTO $dto): array
    {
        $user = Auth::guard('web')->user();

        if (! $user instanceof Authenticatable) {
            throw new \RuntimeException('Unauthenticated.');
        }

        if ($user === null) {
            throw new \RuntimeException('Unauthenticated.');
        }

        $userId = (int) $user->getAuthIdentifier();

        $this->assertActionAllowed($dto, $userId);

        return match (true) {
            $dto->type === 'goal' && $dto->action === 'create' => $this->createGoal($dto, $userId),
            $dto->type === 'goal' && $dto->action === 'complete' => $this->completeGoal($dto, $userId),
            $dto->type === 'goal' && $dto->action === 'delete' => $this->deleteGoal($dto, $userId),
            $dto->type === 'skill' && $dto->action === 'enroll' => $this->enrollSkill($dto, $userId),
            $dto->type === 'skill' && $dto->action === 'unenroll' => $this->unenrollSkill($dto, $userId),
            default => throw new \InvalidArgumentException('Unsupported asset action.'),
        };
    }

    /**
     * @return array<string, mixed>
     */
    private function createGoal(AssetActionDTO $dto, int $userId): array
    {
        $text = trim((string) Arr::get($dto->payload, 'text', ''));
        if ($text === '') {
            throw new \InvalidArgumentException('Goal text is required.');
        }

        $goal = $this->goalRepository->create([
            'user_id' => $userId,
            'text' => $text,
            'status' => 'active',
            'completed_at' => null,
        ]);

        return [
            'goal_id' => $goal->id,
            'status' => $goal->status,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function completeGoal(AssetActionDTO $dto, int $userId): array
    {
        $goalId = (int) Arr::get($dto->payload, 'goal_id');
        if ($goalId <= 0) {
            throw new \InvalidArgumentException('goal_id is required.');
        }

        $goal = \App\Core\Assets\Models\Goal::query()
            ->where('user_id', $userId)
            ->where('id', $goalId)
            ->firstOrFail();

        $goal->status = 'completed';
        $goal->completed_at = now();
        $goal->save();

        return [
            'goal_id' => $goal->id,
            'status' => $goal->status,
            'completed_at' => $goal->completed_at?->toISOString(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function deleteGoal(AssetActionDTO $dto, int $userId): array
    {
        $goalId = (int) Arr::get($dto->payload, 'goal_id');
        if ($goalId <= 0) {
            throw new \InvalidArgumentException('goal_id is required.');
        }

        $deleted = $this->goalRepository->delete($goalId);

        return [
            'deleted' => $deleted,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function enrollSkill(AssetActionDTO $dto, int $userId): array
    {
        $skillId = (int) Arr::get($dto->payload, 'skill_id');
        if ($skillId <= 0) {
            throw new \InvalidArgumentException('skill_id is required.');
        }

        // Explicitly check skill exists — throws readable error if not
        if (! Skill::query()->where('id', $skillId)->exists()) {
            throw new \InvalidArgumentException("Skill with ID {$skillId} does not exist.");
        }

        $enrollment = $this->enrollmentRepository->enroll($userId, $skillId);

        return [
            'enrollment_id' => $enrollment->id,
            'skill_id' => $enrollment->skill_id,
            'status' => $enrollment->status,
            'enrolled_at' => $enrollment->enrolled_at?->toISOString(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function unenrollSkill(AssetActionDTO $dto, int $userId): array
    {
        $skillId = (int) Arr::get($dto->payload, 'skill_id');
        if ($skillId <= 0) {
            throw new \InvalidArgumentException('skill_id is required.');
        }

        // Verify user was actually enrolled before unenrolling
        $enrollment = Enrollment::query()
            ->where('user_id', $userId)
            ->where('skill_id', $skillId)
            ->first();

        if ($enrollment === null) {
            throw new \InvalidArgumentException("You are not enrolled in skill ID {$skillId}.");
        }

        $this->enrollmentRepository->unenroll($userId, $skillId);

        return [
            'skill_id' => $skillId,
            'unenrolled' => true,
        ];
    }

    private function assertActionAllowed(AssetActionDTO $dto, int $userId): void
    {
        $type = $dto->type;
        $action = $dto->action;
        $payload = $dto->payload;

        if ($type === 'skill') {
            if ($action === 'enroll') {
                return;
            }

            if ($action === 'unenroll') {
                return;
            }

            // users cannot create/delete skills
            abort(403, 'Forbidden action for skills.');
        }

        if ($type === 'goal') {
            if ($action === 'create') {
                $text = trim((string) Arr::get($payload, 'text', ''));
                if ($text === '') {
                    abort(422, 'Goal text is required.');
                }
                return;
            }

            if ($action === 'complete') {
                $goalId = (int) Arr::get($payload, 'goal_id', 0);
                if ($goalId <= 0) {
                    abort(422, 'goal_id is required.');
                }
                return;
            }

            if ($action === 'delete') {
                $goalId = (int) Arr::get($payload, 'goal_id', 0);
                if ($goalId <= 0) {
                    abort(422, 'goal_id is required.');
                }
                return;
            }

            // Users cannot edit goals (no update action provided)
            abort(403, 'Forbidden action for goals.');
        }

        abort(400, 'Unsupported asset type/action.');
    }
}

