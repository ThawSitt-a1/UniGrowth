<?php

declare(strict_types=1);

namespace App\Core\Recommendation\UseCases;

use App\Core\Recommendation\DTO\RecommendationDTO;
use App\Core\Recommendation\Repositories\TagRepositoryInterface;
use App\Core\Recommendation\Services\TagIntersectionSimilarityService;

final class GenerateRecommendationsUseCase
{
    public function __construct(
        private readonly TagRepositoryInterface $tagRepository,
        private readonly TagIntersectionSimilarityService $similarityService,
    ) {
    }

    /**
     * Generate personalized skill recommendations for a student.
     *
     * Workflow:
     *  1. Harvest user tags from enrolled skills
     *  2. Source candidate skills (un-enrolled)
     *  3. Rank by tag overlap (Jaccard-like)
     *  4. Return top N as DTOs
     *
     * @return RecommendationDTO[]
     */
    public function execute(int $studentId, int $limit = 5): array
    {
        // Step 1: Harvest user tags from enrolled skills
        $userTags = $this->tagRepository->fetchStudentSkillTags($studentId);

        // Step 2: Source candidate skills (un-enrolled)
        $candidates = $this->tagRepository->fetchCandidateSkills($studentId);

        // Step 3: Rank by tag overlap
        $ranked = $this->similarityService->rank($userTags, $candidates, $limit);

        // Step 4: Map to DTOs
        $results = [];
        foreach ($ranked as $item) {
            $skill = $item['skill'];

            $results[] = new RecommendationDTO(
                skill_id: $skill->id,
                title: $skill->title,
                description: $skill->description,
                tags: $skill->tags ?? [],
                matching_tags_count: $item['matching_tags_count'],
                matching_tags: $item['matching_tags'],
                score: $item['score'],
                resource_link: $skill->resource_link,
            );
        }

        return $results;
    }
}
