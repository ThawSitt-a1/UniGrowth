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
            $table->string('academic_year', 50)->nullable()->after('platform_score');
            $table->string('major', 100)->nullable()->after('academic_year');
            $table->string('university_name', 150)->nullable()->after('major');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['academic_year', 'major', 'university_name']);
        });
    }
};

