<?php

declare(strict_types=1);

namespace App\Overview\Controllers;

use App\Overview\Services\SeasonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SeasonAdminController
{
    public function __construct(
        private readonly SeasonService $seasonService,
    ) {
    }

    /**
     * End the current season (snapshot scores, reset, create new).
     *
     * POST /api/admin/seasons/end
     */
    public function endCurrentSeason(): JsonResponse
    {
        try {
            $newSeason = $this->seasonService->endCurrentSeason();
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        return response()->json([
            'message' => 'Season ended successfully. New season created.',
            'data' => [
                'season_id' => $newSeason->id,
                'name' => $newSeason->name,
                'started_at' => $newSeason->started_at?->toISOString(),
                'ends_at' => $newSeason->ends_at?->toISOString(),
            ],
        ]);
    }

    /**
     * Create a new season manually.
     *
     * POST /api/admin/seasons
     */
    public function createSeason(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'ends_at' => 'required|date|after:now',
        ]);

        try {
            $season = $this->seasonService->initializeNewSeason(
                $request->input('name'),
                $request->input('ends_at'),
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json([
            'message' => 'Season created successfully.',
            'data' => [
                'season_id' => $season->id,
                'name' => $season->name,
                'started_at' => $season->started_at?->toISOString(),
                'ends_at' => $season->ends_at?->toISOString(),
                'is_active' => $season->is_active,
            ],
        ], 201);
    }
}

