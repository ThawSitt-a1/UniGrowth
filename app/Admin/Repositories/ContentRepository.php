<?php

declare(strict_types=1);

namespace App\Admin\Repositories;

use App\Assessment\Models\Question;
use App\Core\Assets\Models\Goal;
use App\Core\Assets\Models\Skill;

final class ContentRepository implements ContentRepositoryInterface
{
    public function suspendQuestion(int $questionId): bool
    {
        return (bool) Question::query()
            ->where('id', $questionId)
            ->update(['is_active' => false]);
    }

    public function restoreQuestion(int $questionId): bool
    {
        return (bool) Question::query()
            ->where('id', $questionId)
            ->update(['is_active' => true]);
    }

    public function deleteQuestion(int $questionId): bool
    {
        $question = Question::query()->findOrFail($questionId);
        return (bool) $question->delete();
    }

    public function suspendSkill(int $skillId): bool
    {
        return (bool) Skill::query()
            ->where('id', $skillId)
            ->update(['is_active' => false]);
    }

    public function restoreSkill(int $skillId): bool
    {
        return (bool) Skill::query()
            ->where('id', $skillId)
            ->update(['is_active' => true]);
    }

    public function deleteSkill(int $skillId): bool
    {
        $skill = Skill::query()->findOrFail($skillId);
        return (bool) $skill->delete();
    }

    public function addSkillAdminComment(int $skillId, string $comment): bool
    {
        return (bool) Skill::query()
            ->where('id', $skillId)
            ->update(['admin_comment' => $comment]);
    }

    public function fetchSuspendedContent(): array
    {
        $suspended = [];

        $questions = Question::query()
            ->where('is_active', false)
            ->with('skill:id,title')
            ->get();

        foreach ($questions as $q) {
            $suspended[] = [
                'id' => $q->id,
                'type' => 'QUESTION',
                'title' => substr($q->question_text, 0, 100),
                'skill' => $q->skill?->title ?? 'Unknown',
                'status' => 'suspended',
                'created_at' => $q->created_at?->toISOString(),
            ];
        }

        $skills = Skill::query()
            ->where('is_active', false)
            ->get();

        foreach ($skills as $s) {
            $suspended[] = [
                'id' => $s->id,
                'type' => 'SKILL',
                'title' => $s->title,
                'skill' => $s->title,
                'status' => 'suspended',
                'created_at' => $s->created_at?->toISOString(),
            ];
        }

        return $suspended;
    }

    public function fetchAllEditorContent(): array
    {
        return Skill::query()
            ->select(['skills.id', 'skills.title', 'skills.is_active', 'skills.editor_id', 'skills.admin_comment', 'skills.created_at', 'users.username as editor_name', 'users.email as editor_email'])
            ->leftJoin('users', 'skills.editor_id', '=', 'users.id')
            ->orderBy('skills.created_at', 'desc')
            ->get()
            ->toArray();
    }
}

