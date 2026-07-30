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
        Schema::create('goals', function (Blueprint $table) {
            $table->id();

            // Link to the user who owns this goal
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Goal text content
            $table->string('text', 255);

            // Status: active | completed
            $table->string('status', 50)->default('active');

            // When the goal was completed (null if not yet completed)
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
