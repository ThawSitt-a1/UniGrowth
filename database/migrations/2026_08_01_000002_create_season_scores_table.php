<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('season_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade');
            $table->decimal('total_score', 10, 2)->default(0);
            $table->integer('skill_count')->default(0);
            $table->integer('total_questions_answered')->default(0);
            $table->timestamp('last_active_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'season_id']);
            $table->index(['season_id', 'total_score']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('season_scores');
    }
};

