<?php

declare(strict_types=1);

namespace App\Services\Analytics;

interface MetricCalculatorInterface
{
    /**
     * Calculate metric.
     *
     * @return float Metric value (unit depends on implementation)
     */
    public function calculate(?int $userId = null): float;
}

