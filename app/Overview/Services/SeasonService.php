<?php

declare(strict_types=1);

namespace App\Overview\Services;

use App\Assessment\Models\Question;
use App\Assessment\Services\QuestionScoringService;
use App\Auth\Models\User;
use App\Overview\DTO\SeasonInfoDTO;
use App\Overview\Models\Season;
use App\Overview\Repositories\SeasonRepositoryInterface;
use App\Overview\Repositories\SeasonScoreRepositoryInterface;

final class SeasonService
{
    public function __construct(
        private readonly SeasonRepositoryInterface $seasonRepo,
        private readonly SeasonScoreRepositoryInterface $seasonScoreRepo,
        private readonly QuestionScoringService $scoringService,
    ) {
    }

    /**
     * Get the current active season info.
     */
    public function getCurrentSeason(): ?Season
    {
        return $this->seasonRepo->getCurrentActiveSeason();
    }

    /**
     * Get current season as DTO.
     */
    public function getCurrentSeasonInfo(): SeasonInfoDTO
    {
        $season = $this->getCurrentSeason();

        // Ensure highest_score is up-to-date
        $highestScore = 0.0;
        if ($season) {
            $highestScore = $this->calculateHighestScore();
            if ($season->highest_score != $highestScore) {
                $this->seasonRepo->updateHighestScore($season->id, $highestScore);
                $season->refresh();
            }
            $highestScore = (float) $season->highest_score;
        }

        return new SeasonInfoDTO(
            seasonId: $season?->id,
            seasonName: $season?->name,
            startedAt: $season?->started_at?->toISOString(),
            endsAt: $season?->ends_at?->toISOString(),
            isActive: $season?->is_active ?? false,
daysRemaining: $season?->ends_at
                ? (int) max(0, now()->diffInDays($season->ends_at, false))
                : 0,
            highestScore: $highestScore,
        );
    }

    /**
     * Ensure an active season exists.
     * Also updates the highest_score for the season.
     *
     * @throws \RuntimeException if no active season exists (admin must start one).
     */
    public function ensureActiveSeason(): Season
    {
        $season = $this->seasonRepo->getCurrentActiveSeason();

        if (!$season) {
            throw new \RuntimeException(
                'No active season is running. Scores can only be recorded during an active season.'
            );
        }

        // Update highest_score = sum of all active question marks
        $highestScore = $this->calculateHighestScore();
        if ($season->highest_score != $highestScore) {
            $this->seasonRepo->updateHighestScore($season->id, $highestScore);
            $season->refresh();
        }

        return $season;
    }

    /**
     * Calculate the highest possible score for the current season.
     * This equals the total combined marks of all active questions.
     */
    public function calculateHighestScore(): float
    {
        $questions = Question::query()
            ->where('is_active', true)
            ->get(['marks', 'question_type', 'difficulty']);

        return $this->scoringService->calculateTotalMarks($questions);
    }

    /**
     * Check if an active season exists.
     */
    public function hasActiveSeason(): bool
    {
        return $this->seasonRepo->getCurrentActiveSeason() !== null;
    }

    /**
     * Record a score for a user in the current season.
     */
    public function recordScoreForSeason(int $userId, float $scoreEarned, int $questionsAnswered): void
    {
        $season = $this->ensureActiveSeason();

        $this->seasonScoreRepo->upsertScore(
            $userId,
            $season->id,
            $scoreEarned,
            $questionsAnswered,
        );
    }

    /**
     * End the current season: snapshot scores, reset platform scores.
     *
     * Note: No new season is created here — the admin decides when to start
     * the next season via initializeNewSeason()/createSeason().
     */
    public function endCurrentSeason(): Season
    {
        $currentSeason = $this->seasonRepo->getCurrentActiveSeason();

        if (!$currentSeason) {
            throw new \RuntimeException('No active season to end.');
        }

        // 1. Snapshot all final scores
        $this->seasonScoreRepo->archiveScores($currentSeason->id);

        // 2. Reset platform_score for all users
        User::query()->update(['platform_score' => 0]);

        // 3. End the current season
        $this->seasonRepo->endSeason($currentSeason->id);

        // Return the ended (now inactive) season
        return $currentSeason->refresh();
    }

    /**
     * Initialize a new season manually.
     *
     * @throws \RuntimeException if an active season already exists. The admin
     *                           must explicitly end the current season first —
     *                           ending and starting are kept as separate actions.
     */
    public function initializeNewSeason(string $name, string $endsAt): Season
    {
        $existing = $this->seasonRepo->getCurrentActiveSeason();
        if ($existing) {
            throw new \RuntimeException(
                "An active season ('{$existing->name}') is already running. End it first before starting a new season."
            );
        }

        return $this->seasonRepo->create([
            'name' => $name,
            'started_at' => now(),
            'ends_at' => $endsAt,
            'is_active' => true,
        ]);
    }

    /**
     * Get season leaderboard with privacy-aware display.
     *
     * If the user has `privacy_show_profile` enabled (public), the entry includes:
     *   - university_name, major, avatar_path, social_links
     * Otherwise (private), only username and score are shown.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getSeasonLeaderboard(int $seasonId, int $limit = 10): array
    {
        $entries = $this->seasonScoreRepo->getLeaderboard($seasonId, $limit);

        $leaderboard = [];
        $rank = 1;
        foreach ($entries as $entry) {
            $user = $entry->user;
            $preferences = $user?->preferences ?? [];
            $isPublic = (bool) ($preferences['privacy_show_profile'] ?? false);

            $base = [
                'rank' => $rank++,
                'user_id' => $entry->user_id,
                'username' => $user?->username ?? 'Unknown',
                'season_score' => $entry->total_score,
                'skill_count' => $entry->skill_count,
                'last_active_at' => $entry->last_active_at?->toISOString(),
                'is_public' => $isPublic,
            ];

            if ($isPublic && $user) {
                // Load social accounts if not already loaded
                if (!$user->relationLoaded('socialAccounts')) {
                    $user->load('socialAccounts');
                }
                $base['avatar_path'] = $user->avatar_path;
                $base['university_name'] = $user->university_name;
                $base['major'] = $user->major;
                $base['social_links'] = $user->socialAccounts->map(fn($a) => [
                    'platform' => $a->platform,
                    'url' => $a->url,
                ])->toArray();
            }

            $leaderboard[] = $base;
        }

        return $leaderboard;
    }

    /**
     * Get season history.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getSeasonHistory(int $limit = 10): array
    {
        $seasons = $this->seasonRepo->getSeasonHistory($limit);

        return $seasons->map(fn(Season $s) => [
            'season_id' => $s->id,
            'name' => $s->name,
            'started_at' => $s->started_at?->toISOString(),
            'ended_at' => $s->ends_at?->toISOString(),
            'total_participants' => $s->snapshots()->distinct('user_id')->count('user_id'),
        ])->toArray();
    }
}
