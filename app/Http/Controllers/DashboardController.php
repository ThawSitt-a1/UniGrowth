<?php

namespace App\Http\Controllers;

use App\Core\Assets\Models\Habit;
use App\Core\Assets\Models\Skill;
use App\Overview\Services\SeasonService;
use App\Overview\Services\StudentOverviewService;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DashboardController
{
    // Inject your services via constructor dependency injection
    public function __construct(
        private readonly SeasonService $seasonService,
        private readonly StudentOverviewService $overviewService,
    ) {}

    public function index(Request $request)
    {
        $user = Auth::user();

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

        $currentSeason = $this->seasonService->getCurrentSeason();

        if ($currentSeason) {
            $leaderboard = $this->seasonService->getSeasonLeaderboard($currentSeason->id, 10);
            $hasActiveSeason = true;
            $currentSeasonName = $currentSeason->name;
            $currentSeasonImage = $currentSeason->image;
        } else {
            $currentSeasonImage = null;
        }

        $overviewData = $this->overviewService->getStudentOverview($user->id)->toArray();

        $recentGoals = collect($overviewData['active_goals'] ?? []);
        $recentEnrolledSkills = collect($overviewData['enrolled_skills'] ?? []);

        // Newly added skills (most recent, active only) for the dashboard
        $newlyAddedSkills = Skill::query()
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->limit(6)
            ->get()
            ->map(fn ($skill) => [
                'skill_id' => $skill->id,
                'title' => $skill->title,
                'slug' => $skill->slug,
                'tags' => $skill->tags ?? [],
                'created_at' => $skill->created_at?->toISOString(),
            ])
            ->toArray();

        // Backend-driven Discord invite link (config/services.php)
        $discordLink = config('services.discord.invite_url', 'https://discord.gg/unigrowth');

        // Habit summary card data (lightweight — counts only)
        $habits = Habit::query()
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

        return view('dashboard', [
            'leaderboard' => $leaderboard,
            'hasActiveSeason' => $hasActiveSeason,
            'currentSeasonName' => $currentSeasonName,
            'currentSeasonImage' => $currentSeasonImage,
            'recentGoals' => $recentGoals,
            'recentEnrolledSkills' => $recentEnrolledSkills,
            'newlyAddedSkills' => $newlyAddedSkills,
            'discordLink' => $discordLink,
            'overviewData' => $overviewData,
            'habitSummary' => $habitSummary,
        ]);
    }

    /**
     * Compute the longest consecutive-day run from a sorted collection of 'Y-m-d' date strings.
     *
     * @param  Collection<int, string>  $dates
     */
    private function longestStreakFromDates($dates): int
    {
        if ($dates->isEmpty()) {
            return 0;
        }

        $longest = 0;
        $run = 1;

        for ($i = 1, $n = $dates->count(); $i < $n; $i++) {
            $prev = CarbonImmutable::parse($dates[$i - 1]);
            $curr = CarbonImmutable::parse($dates[$i]);

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
