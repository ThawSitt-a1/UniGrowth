<?php

declare(strict_types=1);

namespace App\Assessment\Controllers;

use App\Assessment\Services\StudentDashboardService;
use App\Overview\Services\SeasonService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

final class DashboardController
{
    public function __construct(
        private readonly StudentDashboardService $dashboardService,
        private readonly SeasonService $seasonService,
    ) {}

    /**
     * Get aggregated dashboard metrics for a student.
     *
     * GET /api/dashboard/{student_id}
     */
    public function getDashboardMetrics(int $studentId): JsonResponse
    {
        try {
            $metrics = $this->dashboardService->aggregateProgressMetrics($studentId);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        return response()->json([
            'data' => $metrics,
        ]);
    }

    /**
     * Fetch seasonal leaderboard for the current active season.
     *
     * GET /api/leaderboard
     */
    public function getLeaderboard(): JsonResponse
    {
        $currentSeason = $this->seasonService->getCurrentSeason();

        if (! $currentSeason) {
            return response()->json([
                'data' => [],
                'meta' => [
                    'total' => 0,
                    'season_id' => null,
                    'season_name' => null,
                ],
            ]);
        }

        $leaderboard = $this->seasonService->getSeasonLeaderboard($currentSeason->id, 10);

        return response()->json([
            'data' => $leaderboard,
            'meta' => [
                'total' => count($leaderboard),
                'season_id' => $currentSeason->id,
                'season_name' => $currentSeason->name,
            ],
        ]);
    }
}
