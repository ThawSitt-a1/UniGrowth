<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Drops the legacy 'content' and 'is_completed' columns that were replaced
     * by 'text', 'status', and 'completed_at' in a previous schema update.
     *
     * The 'content' column was NOT NULL with no default, causing SQL errors
     * on insert because the code no longer writes to it.
     */
    public function up(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            if (Schema::hasColumn('goals', 'content')) {
                $table->dropColumn('content');
            }

            if (Schema::hasColumn('goals', 'is_completed')) {
                $table->dropColumn('is_completed');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->string('content', 255)->nullable();
            $table->boolean('is_completed')->default(false);
        });
    }
};

