<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('season_scores', 'total_attempts')) {
            Schema::table('season_scores', function (Blueprint $table) {
                $table->integer('total_attempts')
                    ->default(0)
                    ->after('total_questions_answered');
            });
        }
    }

    public function down(): void
    {
        Schema::table('season_scores', function (Blueprint $table) {
            $table->dropColumn('total_attempts');
        });
    }
};
