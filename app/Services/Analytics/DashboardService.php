<?php

declare(strict_types=1);

namespace App\Services\Analytics;

use App\Models\DailyPlatformMetric;
use Carbon\Carbon;

final class DashboardService
{
    /**
     * Logic-thin: read precomputed metrics.
     *
     * @return array<string, float|string|null>
     */
    public function getDashboardMetrics(?int $userId = null, ?Carbon $date = null): array
    {
        // MVP: platform-wide metrics only (ignore $userId for now).
        $date = $date ?? Carbon::today();

        $row = DailyPlatformMetric::query()
            ->whereDate('metric_date', $date->toDateString())
            ->latest('metric_date')
            ->first();

        if ($row === null) {
            return [
                'metric_date' => $date->toDateString(),
                'goal_completion_rate' => 0.0,
                'activation_rate' => 0.0,
                'progress_velocity_avg_hours' => 0.0,
            ];
        }

        return [
            'metric_date' => $row->metric_date?->toDateString(),
            'goal_completion_rate' => (float) $row->goal_completion_rate,
            'activation_rate' => (float) $row->activation_rate,
            'progress_velocity_avg_hours' => (float) $row->progress_velocity_avg_hours,
        ];
    }
}

