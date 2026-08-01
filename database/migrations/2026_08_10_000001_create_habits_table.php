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
        Schema::create('habits', function (Blueprint $table) {
            $table->id();

            // Link to the user who owns this habit
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Habit identity
            $table->string('name', 100);
            $table->string('description', 255)->nullable();

            // Presentation (Bootstrap icon class + hex color)
            $table->string('icon', 50)->default('bi-check2-circle');
            $table->string('color', 20)->default('#6366f1');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habits');
    }
};

