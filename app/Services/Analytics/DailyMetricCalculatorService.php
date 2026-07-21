<?php

declare(strict_types=1);

namespace App\Services\Analytics;

use App\Services\Analytics\Calculators\ActivationRateCalculator;
use App\Services\Analytics\Calculators\GoalCompletionRateCalculator;
use App\Services\Analytics\Calculators\ProgressVelocityCalculator;

final class DailyMetricCalculatorService
{
    public function __construct(
        private readonly GoalCompletionRateCalculator $goalCompletionRateCalculator,
        private readonly ActivationRateCalculator $activationRateCalculator,
        private readonly ProgressVelocityCalculator $progressVelocityCalculator,
    ) {
    }

    public function calculatePlatformMetrics(): array
    {
        return [
            'goal_completion_rate' => $this->goalCompletionRateCalculator->calculate(),
            'activation_rate' => $this->activationRateCalculator->calculate(),
            'progress_velocity_avg_hours' => $this->progressVelocityCalculator->calculate(),
        ];
    }
}

