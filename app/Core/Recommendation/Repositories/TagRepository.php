<?php

declare(strict_types=1);

namespace App\Core\Recommendation\Repositories;

use App\Core\Assets\Models\Enrollment;
use App\Core\Assets\Models\Skill;
use Illuminate\Support\Collection;

final class TagRepository implements TagRepositoryInterface
{
    /**
     * @return string[]
     */
    public function fetchStudentSkillTags(int $userId): array
    {
        $enrollments = Enrollment::query()
            ->where('user_id', $userId)
            ->with('skill')
            ->get();

        $allTags = [];

        foreach ($enrollments as $enrollment) {
            $skill = $enrollment->skill;
            if ($skill !== null && is_array($skill->tags)) {
                $allTags = array_merge($allTags, $skill->tags);
            }
        }

        return array_values(array_unique($allTags));
    }

    /**
     * @return Collection<int, Skill>
     */
    public function fetchCandidateSkills(int $userId): Collection
    {
        $enrolledSkillIds = Enrollment::query()
            ->where('user_id', $userId)
            ->pluck('skill_id')
            ->toArray();

        return Skill::query()
            ->whereNotIn('id', $enrolledSkillIds)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
