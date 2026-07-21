<?php

declare(strict_types=1);

namespace App\Services\Analytics\Calculators;

use App\Core\Assets\Models\Goal;
use App\Services\Analytics\MetricCalculatorInterface;
use Illuminate\Support\Facades\DB;

final class ProgressVelocityCalculator implements MetricCalculatorInterface
{
    public function calculate(?int $userId = null): float
    {
        $query = Goal::query()->where('status', 'completed')->whereNotNull('completed_at');
        if ($userId !== null) {
            $query->where('user_id', $userId);
        }

        $avgSeconds = (float) $query
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, goals.created_at, goals.completed_at)) as avg_seconds')
            ->value('avg_seconds');

        if ($avgSeconds === 0.0) {
            return 0.0;
        }

        // MVP unit: average HOURS
        return $avgSeconds / 3600.0;
    }
}

