<?php

declare(strict_types=1);

namespace App\Admin\Repositories;

use App\Admin\DTOs\PlatformMetricsDTO;

interface MetricsRepositoryInterface
{
    /**
     * Fetch platform-wide admin metrics using existing tables.
     *
     * @param string $timeFrame '7d', '30d', or 'all'
     * @return PlatformMetricsDTO
     */
    public function fetchAdminMetrics(string $timeFrame = 'all'): PlatformMetricsDTO;
}

