<?php

declare(strict_types=1);

namespace App\Core\Recommendation\Repositories;

use Illuminate\Support\Collection;

interface TagRepositoryInterface
{
    /**
     * Fetch all unique tags associated with a student's enrolled skills.
     *
     * Queries enrolled_skills ⋈ skills, decodes JSON tags,
     * flattens, and deduplicates.
     *
     * @return string[]
     */
    public function fetchStudentSkillTags(int $userId): array;

    /**
     * Fetch all skills the student is NOT enrolled in as candidates.
     *
     * @return Collection<int, \App\Core\Assets\Models\Skill>
     */
    public function fetchCandidateSkills(int $userId): Collection;
}
