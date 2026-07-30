<?php

declare(strict_types=1);

namespace App\Core\Assets\Repositories;

/**
 * Skeleton interface — opened for later admin analytics component.
 *
 * @todo Implement full admin analytics/metrics retrieval.
 */
interface MetricsRepositoryInterface
{
    /** @return array<string, mixed> */
    public function getAnalytics(): array;
}

