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
        Schema::create('enrolled_skills', function (Blueprint $table) {
            $table->id();

            // Link to the user and skill
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');

            // Tracking status (great for progress management)
            $table->string('status')->default('active'); // e.g., 'active', 'completed', 'paused'

            // Enrollment timestamp
            $table->timestamp('enrolled_at')->useCurrent();

            // Ensure unique enrollment (prevents duplicate rows)
            $table->unique(['user_id', 'skill_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrolled_skills');
    }
};
