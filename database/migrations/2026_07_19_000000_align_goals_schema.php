<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;




return new class extends Migration
{
    public function up(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            // Add fields per spec (if they don't exist)
            if (! Schema::hasColumn('goals', 'text')) {
                $table->string('text', 255)->after('id');
            }

            if (! Schema::hasColumn('goals', 'status')) {
                $table->string('status')->default('active')->after('text');
            }

            if (! Schema::hasColumn('goals', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('status');
            }
        });

        // Backfill compatibility between old and new schema
        // - content -> text
        // - is_completed -> status/completed_at

        DB::statement('UPDATE goals SET text = COALESCE(text, content)');

        // is_completed true => completed; set completed_at if missing
        DB::statement("UPDATE goals SET status = 'completed', completed_at = COALESCE(completed_at, created_at) WHERE is_completed = 1");

        // is_completed false => active
        DB::statement("UPDATE goals SET status = 'active', completed_at = NULL WHERE is_completed = 0 OR is_completed IS NULL");

        // Keep old columns for now (reversible safety). They can be removed later.
    }

    public function down(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            if (Schema::hasColumn('goals', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
            if (Schema::hasColumn('goals', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('goals', 'text')) {
                $table->dropColumn('text');
            }
        });
    }
};

