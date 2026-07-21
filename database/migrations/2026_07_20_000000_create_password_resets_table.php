<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('token', 255);
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Index for fast lookups
            $table->index('user_id');
            $table->index('token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_resets');
    }
};

