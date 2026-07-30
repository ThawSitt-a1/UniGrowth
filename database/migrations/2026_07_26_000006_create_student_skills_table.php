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
        Schema::create('student_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->decimal('proficiency_score', 8, 2)->default(0);
            $table->integer('attempts_count')->default(0);
            $table->timestamp('last_attempted_at')->nullable();
            $table->timestamps();

            // Ensure one proficiency record per user-skill pair
            $table->unique(['user_id', 'skill_id']);

            // Index for dashboard queries
            $table->index(['user_id', 'skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_skills');
    }
};

