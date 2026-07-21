<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Core\Assets\DTO\AssetActionDTO;
use App\Core\Assets\Models\Enrollment;
use App\Core\Assets\Models\Goal;
use App\Core\Assets\Models\Skill;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class AssetRepository implements AssetRepositoryInterface
{

    /**
     * @return array<string, mixed>
     */
    public function execute(AssetActionDTO $action, int $userId): array
    {
        return match (true) {
            $action->type === 'goal' && $action->action === 'create' => $this->createGoal($action, $userId),
            $action->type === 'goal' && $action->action === 'complete' => $this->completeGoal($action, $userId),
            $action->type === 'goal' && $action->action === 'delete' => $this->deleteGoal($action, $userId),

            $action->type === 'skill' && $action->action === 'enroll' => $this->enrollSkill($action, $userId),

            default => throw new \InvalidArgumentException('Unsupported asset action.'),
        };
    }

    /**
     * @return array<string, mixed>
     */
    private function createGoal(AssetActionDTO $action, int $userId): array
    {
        $text = (string) Arr::get($action->payload, 'text');
        $text = trim($text);
        if ($text === '') {
            throw new \InvalidArgumentException('Goal text is required.');
        }

        $goal = Goal::query()->create([
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
    private function completeGoal(AssetActionDTO $action, int $userId): array
    {
        $goalId = (int) Arr::get($action->payload, 'goal_id');
        if ($goalId <= 0) {
            throw new \InvalidArgumentException('goal_id is required.');
        }

        $goal = Goal::query()
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
    private function deleteGoal(AssetActionDTO $action, int $userId): array
    {
        $goalId = (int) Arr::get($action->payload, 'goal_id');
        if ($goalId <= 0) {
            throw new \InvalidArgumentException('goal_id is required.');
        }

        $deleted = Goal::query()
            ->where('user_id', $userId)
            ->where('id', $goalId)
            ->delete();

        return [
            'deleted' => $deleted > 0,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function enrollSkill(AssetActionDTO $action, int $userId): array
    {
        $skillId = (int) Arr::get($action->payload, 'skill_id');
        if ($skillId <= 0) {
            throw new \InvalidArgumentException('skill_id is required.');
        }

        // Validate skill exists (admins pre-seed). If you want to allow enrolling non-existing, remove this.
        Skill::query()->findOrFail($skillId);

        // Unique constraint exists; use firstOrCreate to avoid duplicates.
        $enrollment = DB::transaction(function () use ($userId, $skillId) {
            $enrollment = Enrollment::query()->firstOrCreate(
                ['user_id' => $userId, 'skill_id' => $skillId],
                ['status' => 'active', 'enrolled_at' => now()]
            );

            return $enrollment;
        });

        return [
            'enrollment_id' => $enrollment->id,
            'skill_id' => $enrollment->skill_id,
            'status' => $enrollment->status,
            'enrolled_at' => $enrollment->enrolled_at?->toISOString(),
        ];
    }
}

