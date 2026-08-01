<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Overview\Services\SeasonService;
use App\Overview\Services\StudentOverviewService;
use Illuminate\Support\Facades\Auth;

class DashboardController
{

    // Inject your services via constructor dependency injection
    public function __construct(
        private readonly  SeasonService $seasonService,
        private readonly StudentOverviewService $overviewService,
    ) {
    }

    public function index(Request $request)
    {
        $isAuthenticated = Auth::check();

        $leaderboard = [];
        $hasActiveSeason = false;
        $currentSeasonName = 'No active season';
        $recentGoals = collect();
        $recentEnrolledSkills = collect();
        $overviewData = [];
        $habitSummary = [
            'total' => 0,
            'completed_today' => 0,
            'best_streak' => 0,
        ];

        if ($isAuthenticated) {
            $user = Auth::user();

            $currentSeason = $this->seasonService->getCurrentSeason();

            if ($currentSeason) {
                $leaderboard = $this->seasonService->getSeasonLeaderboard($currentSeason->id, 10);
                $hasActiveSeason = true;
                $currentSeasonName = $currentSeason->name;
            }

            $overviewData = $this->overviewService->getStudentOverview($user->id)->toArray();

            $recentGoals = collect($overviewData['active_goals'] ?? []);
            $recentEnrolledSkills = collect($overviewData['enrolled_skills'] ?? []);

            // Habit summary card data (lightweight — counts only)
            $habits = \App\Core\Assets\Models\Habit::query()
                ->where('user_id', $user->id)
                ->with('completions')
                ->get();

            $today = now()->toDateString();
            $bestStreak = 0;

            foreach ($habits as $habit) {
                $completedDates = $habit->completions
                    ->pluck('completed_date')
                    ->map(fn ($d) => $d?->toDateString())
                    ->filter()
                    ->sort()
                    ->values();

                if ($completedDates->contains($today)) {
                    $habitSummary['completed_today']++;
                }

                $bestStreak = max($bestStreak, $this->longestStreakFromDates($completedDates));
            }

            $habitSummary['total'] = $habits->count();
            $habitSummary['best_streak'] = $bestStreak;
        }

        return view('dashboard', [
            'leaderboard' => $leaderboard,
            'hasActiveSeason' => $hasActiveSeason,
            'currentSeasonName' => $currentSeasonName,
            'isAuthenticated' => $isAuthenticated,
            'recentGoals' => $recentGoals,
            'recentEnrolledSkills' => $recentEnrolledSkills,
            'overviewData' => $overviewData,
            'habitSummary' => $habitSummary,
        ]);
    }

    /**
     * Compute the longest consecutive-day run from a sorted collection of 'Y-m-d' date strings.
     *
     * @param  \Illuminate\Support\Collection<int, string>  $dates
     */
    private function longestStreakFromDates($dates): int
    {
        if ($dates->isEmpty()) {
            return 0;
        }

        $longest = 0;
        $run = 1;

        for ($i = 1, $n = $dates->count(); $i < $n; $i++) {
            $prev = \Carbon\CarbonImmutable::parse($dates[$i - 1]);
            $curr = \Carbon\CarbonImmutable::parse($dates[$i]);

            if ($prev->addDay()->eq($curr)) {
                $run++;
            } else {
                $longest = max($longest, $run);
                $run = 1;
            }
        }

        return max($longest, $run);
    }
}
