<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('season_score_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('username', 100);
            $table->decimal('final_score', 10, 2)->default(0);
            $table->integer('final_rank')->default(0);
            $table->integer('skill_count')->default(0);
            $table->timestamp('snapshot_date')->useCurrent();
            $table->timestamps();

            $table->index(['season_id', 'final_rank']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('season_score_snapshots');
    }
};

