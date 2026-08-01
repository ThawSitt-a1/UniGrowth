<?php

declare(strict_types=1);

namespace App\Core\Assets\UseCases;

use App\Core\Assets\DTO\AssetActionDTO;
use App\Core\Assets\Models\HabitCompletion;
use App\Core\Assets\Repositories\EnrollmentRepositoryInterface;
use App\Core\Assets\Repositories\GoalRepositoryInterface;
use App\Core\Assets\Repositories\HabitRepositoryInterface;
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
        private readonly HabitRepositoryInterface $habitRepository,
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
            $dto->type === 'habit' && $dto->action === 'create' => $this->createHabit($dto, $userId),
            $dto->type === 'habit' && $dto->action === 'complete' => $this->completeHabit($dto, $userId),
            $dto->type === 'habit' && $dto->action === 'delete' => $this->deleteHabit($dto, $userId),
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
    private function createHabit(AssetActionDTO $dto, int $userId): array
    {
        $name = trim((string) Arr::get($dto->payload, 'name', ''));
        if ($name === '') {
            throw new \InvalidArgumentException('Habit name is required.');
        }

        $habit = $this->habitRepository->create([
            'user_id' => $userId,
            'name' => $name,
            'description' => trim((string) Arr::get($dto->payload, 'description', '')),
            'icon' => trim((string) Arr::get($dto->payload, 'icon', 'bi-check2-circle')),
            'color' => trim((string) Arr::get($dto->payload, 'color', '#6366f1')),
        ]);

        return [
            'habit_id' => $habit->id,
            'name' => $habit->name,
        ];
    }

    /**
     * Complete a habit for a given date (defaults to today).
     *
     * @return array<string, mixed>
     */
    private function completeHabit(AssetActionDTO $dto, int $userId): array
    {
        $habitId = (int) Arr::get($dto->payload, 'habit_id');
        if ($habitId <= 0) {
            throw new \InvalidArgumentException('habit_id is required.');
        }

        $date = trim((string) Arr::get($dto->payload, 'completed_date', ''));
        $completedDate = $date !== '' ? \Carbon\Carbon::parse($date)->toDateString() : now()->toDateString();

        $habit = \App\Core\Assets\Models\Habit::query()
            ->where('user_id', $userId)
            ->where('id', $habitId)
            ->firstOrFail();

        // Idempotent: if already completed today, don't create a duplicate row.
        $existing = HabitCompletion::query()
            ->where('habit_id', $habitId)
            ->where('user_id', $userId)
            ->where('completed_date', $completedDate)
            ->exists();

        if ($existing) {
            return [
                'habit_id' => $habit->id,
                'completed_date' => $completedDate,
                'already_completed' => true,
            ];
        }

        $completion = HabitCompletion::query()->create([
            'habit_id' => $habitId,
            'user_id' => $userId,
            'completed_date' => $completedDate,
        ]);

        return [
            'habit_id' => $habit->id,
            'completion_id' => $completion->id,
            'completed_date' => $completedDate,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function deleteHabit(AssetActionDTO $dto, int $userId): array
    {
        $habitId = (int) Arr::get($dto->payload, 'habit_id');
        if ($habitId <= 0) {
            throw new \InvalidArgumentException('habit_id is required.');
        }

        // Ensure the habit belongs to the authenticated user before deleting.
        $owned = \App\Core\Assets\Models\Habit::query()
            ->where('user_id', $userId)
            ->where('id', $habitId)
            ->exists();

        if (! $owned) {
            throw new \InvalidArgumentException('Habit not found.');
        }

        $deleted = $this->habitRepository->delete($habitId);

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

        if ($type === 'habit') {
            if ($action === 'create') {
                $name = trim((string) Arr::get($payload, 'name', ''));
                if ($name === '') {
                    abort(422, 'Habit name is required.');
                }
                return;
            }

            if ($action === 'complete') {
                $habitId = (int) Arr::get($payload, 'habit_id', 0);
                if ($habitId <= 0) {
                    abort(422, 'habit_id is required.');
                }
                return;
            }

            if ($action === 'delete') {
                $habitId = (int) Arr::get($payload, 'habit_id', 0);
                if ($habitId <= 0) {
                    abort(422, 'habit_id is required.');
                }
                return;
            }

            abort(403, 'Forbidden action for habits.');
        }

        abort(400, 'Unsupported asset type/action.');
    }
}

