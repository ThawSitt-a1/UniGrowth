<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Indexed for fast lookups during login and filtering
            $table->string('username', 50)->unique();
            $table->string('email', 254)->unique()->index();

            // Indexed for fast role-based authorization checks
            $table->enum('role', ['admins', 'user', 'superadmin'])->default('user')->index();

            // Indexed for fast security filtering
            $table->enum('account_status', ['allowed', 'banned', 'suspended'])->default('allowed')->index();
            $table->timestamp('suspended_until')->nullable();

            $table->string('password', 255);
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();

           // Timestamps
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // 2. Sessions Table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('username')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
    }
};
