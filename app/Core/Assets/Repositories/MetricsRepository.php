<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

use App\Models\DailyPlatformMetric;

/**
 * Skeleton implementation — opened for later admin analytics component.
 *
 * @todo Implement full admin analytics/metrics retrieval.
 */
final class MetricsRepository implements MetricsRepositoryInterface
{
    /** @return array<string, mixed> */
    public function getAnalytics(): array
    {
        return DailyPlatformMetric::query()
            ->orderByDesc('metric_date')
            ->limit(30)
            ->get()
            ->toArray();
    }
}

