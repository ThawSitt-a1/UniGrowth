<?php

declare(strict_types=1);

namespace App\Editor\Repositories;

use App\Assessment\Models\Question;
use App\Editor\DTOs\ContentQueryFilterDTO;

final class EditorContentRepository implements EditorContentRepositoryInterface
{
    public function fetchFiltered(ContentQueryFilterDTO $filters): array
    {
        $query = Question::query()->with(['skill', 'options']);

        if ($filters->editorId !== null) {
            $query->where('editor_id', $filters->editorId);
        }

        if ($filters->skillId !== null) {
            $query->where('skill_id', $filters->skillId);
        }

        if ($filters->searchQuery !== null) {
            $query->where(function ($q) use ($filters) {
                $q->where('question_text', 'like', '%' . $filters->searchQuery . '%');
            });
        }

        $query->orderBy('created_at', 'desc');

        return $query->paginate($filters->perPage)->toArray();
    }
}
