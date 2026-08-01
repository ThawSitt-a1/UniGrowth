<?php

declare(strict_types=1);

namespace App\Overview\Controllers;

use App\Overview\Services\StudentOverviewService;
use App\Overview\Services\SeasonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class StudentOverviewWebController
{
    public function __construct(
        private readonly StudentOverviewService $overviewService,
        private readonly SeasonService $seasonService,
    ) {
    }

    /**
     * Display the student overview dashboard.
     *
     * GET /overview
     */
    public function index(Request $request): RedirectResponse
    {
        return redirect()->route('dashboard');
    }

    /**
     * End current season (admin action via web).
     *
     * POST /overview/season/end
     */
    public function endSeason(Request $request): RedirectResponse
    {
        try {
            $endedSeason = $this->seasonService->endCurrentSeason();
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('dashboard')
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Season "' . $endedSeason->name . '" ended. No new season was created — an administrator can start one at any time.');
    }
}

