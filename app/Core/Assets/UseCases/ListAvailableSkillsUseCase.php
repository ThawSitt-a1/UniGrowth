<?php

declare(strict_types=1);

namespace App\Core\Assets\UseCases;

use App\Core\Assets\Models\Enrollment;
use App\Core\Assets\Repositories\SkillRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class ListAvailableSkillsUseCase
{
    public function __construct(
        private readonly SkillRepositoryInterface $skillRepository,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function execute(?string $tag = null, string $sortBy = 'newest'): array
    {
        $userId = (int) Auth::guard('web')->id();

        // Get user's enrolled skill IDs to mark which skills are already enrolled
        $enrolledSkillIds = Enrollment::query()
            ->where('user_id', $userId)
            ->pluck('skill_id')
            ->toArray();

        // Get filtered and sorted skills
        $skills = $this->skillRepository->findAllFiltered($tag, $sortBy);

        // Get all available tags
        $allTags = $this->skillRepository->getAllTags();

        // Build structured skill data with enrollment counts and enrollment status
        $skillsData = $skills->map(function ($skill) use ($enrolledSkillIds) {
            return [
                'id' => $skill->id,
                'title' => $skill->title,
                'description' => $skill->description,
                'tags' => $skill->tags ?? [],
                'resource_link' => $skill->resource_link,
                'is_enrolled' => in_array($skill->id, $enrolledSkillIds, true),
                'enrollments_count' => $skill->enrollments_count ?? $skill->enrollments()->count(),
                'created_at' => $skill->created_at?->toISOString(),
            ];
        })->values()->toArray();

        return [
            'skills' => $skillsData,
            'all_tags' => $allTags,
            'selected_tag' => $tag,
            'sort_by' => $sortBy,
        ];
    }
}
