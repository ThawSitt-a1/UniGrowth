<?php

declare(strict_types=1);

namespace App\Core\Recommendation\Services;

use App\Core\Assets\Models\Skill;
use Illuminate\Support\Collection;

final class TagIntersectionSimilarityService
{
    /**
     * Rank candidate skills by tag overlap with user's skill tags.
     *
     * Cold-start path: if user has no tags, return a randomized fallback.
     *
     * @param string[] $userTags
     * @param Collection<int, Skill> $candidates
     * @return array<int, array{skill: Skill, matching_tags_count: int, matching_tags: string[], score: float}>
     */
    public function rank(array $userTags, Collection $candidates, int $limit = 5): array
    {
        // Cold-start: user has no enrolled skills → return random subset of candidates
        if (empty($userTags)) {
            $shuffled = $candidates->shuffle()->take($limit);

            $results = [];
            foreach ($shuffled as $skill) {
                $results[] = [
                    'skill' => $skill,
                    'matching_tags_count' => 0,
                    'matching_tags' => [],
                    'score' => 0.0,
                ];
            }

            return $results;
        }

        $userTags = array_map('strtolower', $userTags);
        $userTags = array_values(array_unique($userTags));

        $scored = [];

        foreach ($candidates as $skill) {
            $skillTags = $skill->tags ?? [];
            $skillTags = array_map('strtolower', $skillTags);
            $skillTags = array_values(array_unique($skillTags));

            $intersection = array_intersect($userTags, $skillTags);
            $matchingCount = count($intersection);

            if ($matchingCount === 0) {
                continue; // Skip skills with no matching tags
            }

            // Jaccard-like score: |intersection| / |union|
            $union = count(array_unique(array_merge($userTags, $skillTags)));
            $score = $union > 0 ? $matchingCount / $union : 0.0;

            $scored[] = [
                'skill' => $skill,
                'matching_tags_count' => $matchingCount,
                'matching_tags' => array_values($intersection),
                'score' => $score,
            ];
        }

        // Sort by score descending, then by matching_tags_count descending as tiebreaker
        usort($scored, function (array $a, array $b): int {
            return $b['score'] <=> $a['score'] ?: $b['matching_tags_count'] <=> $a['matching_tags_count'];
        });

        return array_slice($scored, 0, $limit);
    }
}
