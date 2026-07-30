<?php

declare(strict_types=1);

namespace App\Core\Http\Controllers;

use App\Core\Recommendation\UseCases\GenerateRecommendationsUseCase;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Deliberately minimal/ugly testing frontend for the Recommendation Engine.
 *
 * Exercises Core recommendation business logic directly:
 * - GenerateRecommendationsUseCase (Jaccard tag intersection scoring)
 * - Shows cold-start fallback when user has no enrolled skills
 *
 * Not for production — testing only.
 */
final class CoreTestRecommendationsController
{
    public function __construct(
        private readonly GenerateRecommendationsUseCase $generateRecommendationsUseCase,
    ) {
    }

    public function index(Request $request): View
    {
        $userId = (int) $request->user()->getAuthIdentifier();
        $limit = min(max((int) $request->input('limit', 10), 1), 100);

        try {
            $recommendationDtos = $this->generateRecommendationsUseCase->execute($userId, $limit);

            // Convert DTOs to arrays for the blade view (which uses array syntax)
            $recommendations = array_map(
                static fn ($dto) => $dto->toArray(),
                $recommendationDtos
            );

            // Extract enrolled stats
            $repo = app(\App\Core\Recommendation\Repositories\TagRepositoryInterface::class);
            $userTags = $repo->fetchStudentSkillTags($userId);
            $enrolledCount = count($userTags);
            $totalCandidates = count($recommendations);

            $rawApiResponse = [
                'data' => $recommendations,
                'meta' => [
                    'user_id' => $userId,
                    'limit' => $limit,
                    'total_candidates' => $totalCandidates,
                    'cold_start' => empty($userTags),
                ],
            ];

            return view('core.test-recommendations', [
                'recommendations' => $recommendations,
                'userTags' => $userTags,
                'enrolledCount' => $enrolledCount,
                'totalCandidates' => $totalCandidates,
                'limit' => $limit,
                'rawApiResponse' => $rawApiResponse,
            ]);
        } catch (\Exception $e) {
            return view('core.test-recommendations', [
                'recommendations' => [],
                'userTags' => [],
                'enrolledCount' => 0,
                'totalCandidates' => 0,
                'limit' => $limit,
                'rawApiResponse' => ['error' => $e->getMessage()],
            ]);
        }
    }
}
