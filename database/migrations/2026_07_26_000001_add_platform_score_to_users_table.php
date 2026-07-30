<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('platform_score', 8, 2)->default(0)->after('suspended_until');
        });

        // Add index for leaderboard queries (ORDER BY platform_score DESC)
        Schema::table('users', function (Blueprint $table) {
            $table->index('platform_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['platform_score']);
            $table->dropColumn('platform_score');
        });
    }
};

