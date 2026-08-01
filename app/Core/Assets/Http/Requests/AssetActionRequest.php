<?php

declare(strict_types=1);

namespace App\Core\Assets\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AssetActionRequest extends FormRequest
{
    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:goal,skill,habit'],
            'action' => ['required', 'string', 'in:create,complete,delete,enroll,unenroll'],
            'payload' => ['required', 'array'],
            'payload.text' => [
                $this->isGoalCreate() ? 'required' : 'nullable',
                'string',
                'max:255',
            ],
            'payload.goal_id' => [
                $this->isGoalAction('complete') || $this->isGoalAction('delete') ? 'required' : 'nullable',
                'integer',
                'min:1',
            ],
            'payload.skill_id' => [
                $this->isSkillAction('enroll') || $this->isSkillAction('unenroll') ? 'required' : 'nullable',
                'integer',
                'min:1',
            ],
            'payload.name' => [
                $this->isHabitCreate() ? 'required' : 'nullable',
                'string',
                'max:100',
            ],
            'payload.description' => [
                'nullable',
                'string',
                'max:255',
            ],
            'payload.habit_id' => [
                $this->isHabitAction('complete') || $this->isHabitAction('delete') ? 'required' : 'nullable',
                'integer',
                'min:1',
            ],
            'payload.completed_date' => [
                $this->isHabitAction('complete') ? 'nullable' : 'nullable',
                'date',
            ],
            'payload.icon' => ['nullable', 'string', 'max:50'],
            'payload.color' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function authorize(): bool
    {
        return true; // Authorization is handled by middleware + use case
    }

    private function isGoalCreate(): bool
    {
        return $this->input('type') === 'goal' && $this->input('action') === 'create';
    }

    private function isGoalAction(string $action): bool
    {
        return $this->input('type') === 'goal' && $this->input('action') === $action;
    }

    private function isSkillAction(string $action): bool
    {
        return $this->input('type') === 'skill' && $this->input('action') === $action;
    }

    private function isHabitCreate(): bool
    {
        return $this->input('type') === 'habit' && $this->input('action') === 'create';
    }

    private function isHabitAction(string $action): bool
    {
        return $this->input('type') === 'habit' && $this->input('action') === $action;
    }
}

