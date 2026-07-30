<?php

declare(strict_types=1);

namespace App\Assessment\Controllers;

use App\Assessment\Services\StudentDashboardService;
use Illuminate\Http\JsonResponse;

final class DashboardController
{
    public function __construct(
        private readonly StudentDashboardService $dashboardService,
    ) {
    }

    /**
     * Get aggregated dashboard metrics for a student.
     *
     * GET /api/dashboard/{student_id}
     */
    public function getDashboardMetrics(int $studentId): JsonResponse
    {
        try {
            $metrics = $this->dashboardService->aggregateProgressMetrics($studentId);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Student not found.'], 404);
        }

        return response()->json([
            'data' => $metrics,
        ]);
    }

    /**
     * Fetch global leaderboard.
     *
     * GET /api/leaderboard
     */
    public function getLeaderboard(): JsonResponse
    {
        $leaderboard = $this->dashboardService->fetchGlobalLeaderboard();

        return response()->json([
            'data' => $leaderboard,
            'meta' => [
                'total' => count($leaderboard),
            ],
        ]);
    }
}

