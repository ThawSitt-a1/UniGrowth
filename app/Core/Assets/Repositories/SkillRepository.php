<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Core\Assets\Models\Skill;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Skeleton implementation — opened for later admin component.
 *
 * @todo Implement full admin skill management.
 */
final class SkillRepository implements SkillRepositoryInterface
{
    public function create(array $data): Skill
    {
        return Skill::query()->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return (bool) Skill::query()->where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return (bool) Skill::query()->where('id', $id)->delete();
    }

    /** @return Skill[] */
    public function findAll(): array
    {
        return Skill::query()->get()->all();
    }

    /**
     * @return Collection<int, Skill>
     */
    public function findAllFiltered(?string $tag = null, string $sortBy = 'newest'): Collection
    {
        $query = Skill::query();

        if ($tag !== null) {
            $query->whereJsonContains('tags', $tag);
        }

        if ($sortBy === 'most_enrolled') {
            // Sort by enrollment count descending
            $query->withCount('enrollments')
                  ->orderBy('enrollments_count', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->get();
    }

    /**
     * @return string[]
     */
    public function getAllTags(): array
    {
        // Fetch all distinct tags from the JSON column
        $skills = Skill::query()->select('tags')->get();

        $allTags = [];
        foreach ($skills as $skill) {
            if (is_array($skill->tags)) {
                $allTags = array_merge($allTags, $skill->tags);
            }
        }

        return array_values(array_unique($allTags));
    }
}
