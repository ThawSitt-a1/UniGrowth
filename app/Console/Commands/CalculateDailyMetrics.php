<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\DailyPlatformMetric;
use App\Services\Analytics\DailyMetricCalculatorService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

final class CalculateDailyMetrics extends Command
{
    protected $signature = 'analytics:calculate-daily-metrics';

    protected $description = 'Compute and persist daily platform metrics';

    public function __construct(
        private readonly DailyMetricCalculatorService $dailyMetricCalculatorService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $metricDate = Carbon::today();

        $metrics = $this->dailyMetricCalculatorService->calculatePlatformMetrics();

        DailyPlatformMetric::query()->updateOrCreate(
            ['metric_date' => $metricDate->toDateString()],
            $metrics,
        );

        Log::info('Daily metrics calculated', [
            'metric_date' => $metricDate->toDateString(),
            'metrics' => $metrics,
        ]);

        return self::SUCCESS;
    }
}

