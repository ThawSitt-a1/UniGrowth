<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('seasons', 'highest_score')) {
            Schema::table('seasons', function (Blueprint $table) {
                $table->decimal('highest_score', 12, 2)
                    ->default(0)
                    ->after('is_active');
            });
        }
    }

    public function down(): void
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->dropColumn('highest_score');
        });
    }
};
