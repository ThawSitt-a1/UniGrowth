<?php

declare(strict_types=1);

namespace App\Services\Analytics\Calculators;

use App\Core\Assets\Models\Goal;
use App\Services\Analytics\MetricCalculatorInterface;

final class GoalCompletionRateCalculator implements MetricCalculatorInterface
{
    public function calculate(?int $userId = null): float
    {
        $query = Goal::query();
        if ($userId !== null) {
            $query->where('user_id', $userId);
        }

        $total = (int) $query->count();
        if ($total === 0) {
            return 0.0;
        }

        $done = (int) $query->clone()->where('status', 'completed')->count();

        return ($done / $total) * 100.0;
    }
}

