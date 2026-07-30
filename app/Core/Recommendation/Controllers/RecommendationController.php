<?php

declare(strict_types=1);

namespace App\Core\Recommendation\Controllers;

use App\Core\Recommendation\Http\Requests\RecommendationRequest;
use App\Core\Recommendation\UseCases\GenerateRecommendationsUseCase;
use Illuminate\Http\JsonResponse;

final class RecommendationController
{
    public function __construct(
        private readonly GenerateRecommendationsUseCase $recommendationUseCase,
    ) {
    }

    /**
     * Get personalized skill recommendations for the authenticated student.
     *
     * GET /api/recommendations?limit=5
     *
     * Can also be triggered internally by other backend
     * components injecting GenerateRecommendationsUseCase directly.
     */
    public function getPersonalizedSuggestions(RecommendationRequest $request): JsonResponse
    {
        $studentId = $request->getStudentId();
        $limit = $request->getLimit();

        $recommendations = $this->recommendationUseCase->execute($studentId, $limit);

        $data = array_map(
            static fn ($dto) => $dto->toArray(),
            $recommendations
        );

        return response()->json([
            'data' => $data,
            'meta' => [
                'student_id' => $studentId,
                'total' => count($data),
                'limit' => $limit,
            ],
        ]);
    }
}
