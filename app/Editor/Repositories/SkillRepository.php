<?php

declare(strict_types=1);

namespace App\Editor\Repositories;

use App\Core\Assets\Models\Skill;
use App\Editor\DTOs\SkillDataDTO;

final class SkillRepository implements SkillRepositoryInterface
{
    public function save(SkillDataDTO $data): bool
    {
        if ($data->skillId) {
            $skill = Skill::query()->findOrFail($data->skillId);
            if ($skill->locked_by_admin) {
                return false;
            }
            $skill->update([
                'title' => $data->title,
                'slug' => $data->slug,
                'description' => $data->description,
                'tags' => $data->tags ?? [],
                'content' => $data->content ?? '',
                'resource_link' => $data->resourceLink ?? '',
                'resource_links' => $data->resourceLinks ?? [],
            ]);
            return true;
        }

        Skill::query()->create([
            'editor_id' => $data->editorId,
            'title' => $data->title,
            'slug' => $data->slug,
            'description' => $data->description,
            'tags' => $data->tags ?? [],
            'content' => $data->content ?? '',
            'resource_link' => $data->resourceLink ?? '',
            'resource_links' => $data->resourceLinks ?? [],
            'is_active' => true,
            'locked_by_admin' => false,
        ]);
        return true;
    }

    public function deleteByOwner(int $id, int $editorId): bool
    {
        $skill = Skill::query()
            ->where('id', $id)
            ->where('editor_id', $editorId)
            ->where('locked_by_admin', false)
            ->first();

        if (!$skill) {
            return false;
        }

        $skill->questions()->delete();
        return (bool) $skill->delete();
    }

    public function verifyOwnership(int $id, int $editorId): bool
    {
        return Skill::query()
            ->where('id', $id)
            ->where('editor_id', $editorId)
            ->exists();
    }

    public function isLockedByAdmin(int $id): bool
    {
        return Skill::query()
            ->where('id', $id)
            ->where('locked_by_admin', true)
            ->exists();
    }
}
