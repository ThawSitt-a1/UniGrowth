<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Auth\Models\User;
use App\Core\Assets\Models\Habit;
use Carbon\CarbonImmutable;

final class UserRepository implements UserRepositoryInterface
{
    /** @return array<string, mixed> */
    public function fetchActivityProfile(int $userId): array
    {
        $user = User::query()->with([
            'enrolledSkills.skill',
            'goals',
            'habits.completions',
        ])->findOrFail($userId);

        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'enrolled_skills' => $user->enrolledSkills->map(fn ($enrollment) => [
                'skill_id' => $enrollment->skill_id,
                'skill_title' => $enrollment->skill?->title,
                'status' => $enrollment->status,
                'enrolled_at' => $enrollment->enrolled_at?->toISOString(),
            ]),
            'goals' => $user->goals->map(fn ($goal) => [
                'id' => $goal->id,
                'text' => $goal->text,
                'status' => $goal->status,
                'completed_at' => $goal->completed_at?->toISOString(),
            ]),
            'habits' => $user->habits->map(fn (Habit $habit) => [
                'id' => $habit->id,
                'name' => $habit->name,
                'description' => $habit->description,
                'icon' => $habit->icon,
                'color' => $habit->color,
                'created_at' => $habit->created_at?->toISOString(),
                'current_streak' => $this->currentStreak($habit),
                'longest_streak' => $this->longestStreak($habit),
                'total_completions' => $habit->completions->count(),
                'completed_today' => $habit->completions->contains(fn ($c) => $c->completed_date?->isToday()),
                'completion_dates' => $habit->completions
                    ->sortByDesc('completed_date')
                    ->pluck('completed_date')
                    ->map(fn ($date) => $date?->toDateString())
                    ->values(),
            ]),
        ];
    }

    /**
     * Consecutive-day streak ending today (or yesterday if today not yet done).
     */
    private function currentStreak(Habit $habit): int
    {
        $dates = $habit->completions
            ->pluck('completed_date')
            ->map(fn ($date) => $date?->toDateString())
            ->filter()
            ->values();

        if ($dates->isEmpty()) {
            return 0;
        }

        $set = $dates->flip();
        $streak = 0;

        // Start counting from today; if today isn't done, fall back to yesterday
        // so the streak is preserved until the day is over.
        $cursor = CarbonImmutable::today();
        if (! isset($set[$cursor->toDateString()])) {
            $cursor = $cursor->subDay();
        }

        while (isset($set[$cursor->toDateString()])) {
            $streak++;
            $cursor = $cursor->subDay();
        }

        return $streak;
    }

    /**
     * Longest consecutive-day streak ever recorded for the habit.
     */
    private function longestStreak(Habit $habit): int
    {
        $dates = $habit->completions
            ->pluck('completed_date')
            ->map(fn ($date) => $date?->toDateString())
            ->filter()
            ->sort()
            ->values();

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

