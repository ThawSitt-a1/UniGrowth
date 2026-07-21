<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class DailyPlatformMetric extends Model
{
    use HasFactory;

    protected $table = 'daily_platform_metrics';

    protected $fillable = [
        'metric_date',
        'goal_completion_rate',
        'activation_rate',
        'progress_velocity_avg_hours',
    ];

    protected $casts = [
        'metric_date' => 'date',
        'goal_completion_rate' => 'float',
        'activation_rate' => 'float',
        'progress_velocity_avg_hours' => 'float',
    ];
}

