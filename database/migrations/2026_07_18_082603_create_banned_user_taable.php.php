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
        Schema::create('banned_users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 254)->unique(); // Use email to track bans
            $table->text('reason')->nullable();      // Why they were banned

            // Link to the admin who banned them
            // If the admin account is deleted, we keep the record (null)
            $table->foreignId('banned_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banned_users');
    }
};
