<?php

declare(strict_types=1);

namespace App\Overview\Controllers;

use App\Overview\Services\StudentOverviewService;
use App\Overview\Services\SeasonService;
use Illuminate\Http\JsonResponse;

final class StudentOverviewController
{
    public function __construct(
        private readonly StudentOverviewService $overviewService,
        private readonly SeasonService $seasonService,
    ) {
    }

    /**
     * Get the full student overview dashboard.
     *
     * GET /api/overview
     */
    public function getOverview(): JsonResponse
    {
        $studentId = (int) request()->user()->getAuthIdentifier();

        try {
            $overview = $this->overviewService->getStudentOverview($studentId);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        return response()->json([
            'data' => $overview->toArray(),
        ]);
    }

    /**
     * Get the current season info.
     *
     * GET /api/seasons/current
     */
    public function getCurrentSeasonInfo(): JsonResponse
    {
        $seasonInfo = $this->seasonService->getCurrentSeasonInfo();

        return response()->json([
            'data' => $seasonInfo->toArray(),
        ]);
    }

    /**
     * Get season leaderboard.
     *
     * GET /api/seasons/{season_id}/leaderboard?limit=10
     */
    public function getSeasonLeaderboard(int $seasonId): JsonResponse
    {
        $limit = (int) request()->query('limit', 10);
        $leaderboard = $this->seasonService->getSeasonLeaderboard($seasonId, $limit);

        return response()->json([
            'data' => $leaderboard,
        ]);
    }

    /**
     * Get season history.
     *
     * GET /api/seasons/history
     */
    public function getSeasonHistory(): JsonResponse
    {
        $history = $this->seasonService->getSeasonHistory();

        return response()->json([
            'data' => $history,
        ]);
    }
}

