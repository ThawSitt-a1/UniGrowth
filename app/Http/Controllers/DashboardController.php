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
        }

        // Always show a Top 10 leaderboard. When no active season exists (or
        // the season has no scores yet), fall back to the overall top students
        // by platform score so the dashboard always reflects the latest scores
        // on every page refresh.
        $leaderboardSource = 'season';
        if (empty($leaderboard)) {
            $leaderboard = $this->buildPlatformLeaderboard();
            $leaderboardSource = 'platform';
        }

        $overviewData = $this->overviewService->getStudentOverview($user->id)->toArray();

$recentGoals = collect($overviewData['active_goals'] ?? []);
        $recentEnrolledSkills = collect($overviewData['enrolled_skills'] ?? []);

        // Newly added skills (most recent, active only) for the dashboard
        $newlyAddedSkills = \App\Core\Assets\Models\Skill::query()
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

return view('dashboard', [
            'leaderboard' => $leaderboard,
            'leaderboardSource' => $leaderboardSource,
            'hasActiveSeason' => $hasActiveSeason,
            'currentSeasonName' => $currentSeasonName,
            'recentGoals' => $recentGoals,
            'recentEnrolledSkills' => $recentEnrolledSkills,
            'newlyAddedSkills' => $newlyAddedSkills,
            'discordLink' => $discordLink,
            'overviewData' => $overviewData,
            'habitSummary' => $habitSummary,
        ]);
    }

/**
     * Build a Top 10 leaderboard from overall platform scores.
     *
     * Used as a fallback when there is no active season (or the season has no
     * scores yet) so the dashboard always shows the latest top scores and
     * refreshes on every page load. Excludes admins/editors and respects the
     * same privacy flags the season leaderboard uses.
     *
     * @return array<int, array<string, mixed>>
     */
    private function buildPlatformLeaderboard(): array
    {
        $users = \App\Auth\Models\User::query()
            ->whereNotIn('role', [\App\Auth\Models\User::ROLE_ADMIN, \App\Auth\Models\User::ROLE_EDITOR])
            ->where('platform_score', '>', 0)
            ->orderByDesc('platform_score')
            ->limit(10)
            ->get();

        $leaderboard = [];
        $rank = 1;
        foreach ($users as $user) {
            $preferences = $user->preferences ?? [];
            $isHiddenLeaderboards = (bool) ($preferences['privacy_hide_leaderboards'] ?? false);
            $isProfilePrivate = (bool) ($preferences['make_profile_private'] ?? false);

            $base = [
                'rank' => $rank++,
                'user_id' => $user->id,
                'username' => $user->username ?? 'Unknown',
                'season_score' => (float) $user->platform_score,
                'skill_count' => 0,
                'last_active_at' => $user->updated_at?->toISOString(),
                'is_hidden_leaderboards' => $isHiddenLeaderboards,
                'is_profile_private' => $isProfilePrivate,
                'is_profile_viewable' => !$isProfilePrivate && !$isHiddenLeaderboards,
            ];

            if (!$isHiddenLeaderboards && !$isProfilePrivate) {
                $base['avatar_path'] = $user->avatar_path;
                $base['university_name'] = $user->university_name;
                $base['major'] = $user->major;
            }

            // Lifetime rank title based on cumulative platform_score.
            $base['rank_title'] = \App\Auth\Models\User::rankTitle((float) $user->platform_score);

            $leaderboard[] = $base;
        }

        return $leaderboard;
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
