<?php

declare(strict_types=1);

namespace App\Admin\UseCases;

use App\Admin\DTOs\MetricsFilterDTO;
use App\Admin\DTOs\PlatformMetricsDTO;
use App\Admin\Repositories\MetricsRepositoryInterface;

final class GetPlatformMetricsUseCase
{
    public function __construct(
        private readonly MetricsRepositoryInterface $metricsRepository,
    ) {
    }

    /**
     * Execute the use case to gather platform telemetry data.
     */
    public function execute(MetricsFilterDTO $filters): PlatformMetricsDTO
    {
        return $this->metricsRepository->fetchAdminMetrics($filters->timeFrame);
    }
}

