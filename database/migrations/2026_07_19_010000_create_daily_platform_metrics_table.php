<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_platform_metrics', function (Blueprint $table) {
            $table->id();

            // One row per day (computed at midnight, storing the day being computed)
            $table->date('metric_date');
            $table->unique('metric_date');

            $table->decimal('goal_completion_rate', 10, 4)->default(0);
            $table->decimal('activation_rate', 10, 4)->default(0);
            $table->decimal('progress_velocity_avg_hours', 18, 6)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_platform_metrics');
    }
};

