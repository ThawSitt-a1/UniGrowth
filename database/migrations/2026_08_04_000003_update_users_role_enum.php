<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Migrate existing data: convert 'superadmin' → 'admin', 'admins' → 'admin'
        DB::table('users')
            ->whereIn('role', ['superadmin', 'admins'])
            ->update(['role' => 'admin']);

        // 2. For MySQL 8.0+ we can use MODIFY COLUMN; for older versions we use raw SQL
        // MySQL doesn't support changing ENUM values via Schema builder, so use raw statement.
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'admin', 'editor') NOT NULL DEFAULT 'user'");
    }

    public function down(): void
    {
        // Restore original enum (safe revert)
        DB::table('users')
            ->where('role', 'editor')
            ->update(['role' => 'user']);

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admins', 'user', 'superadmin') NOT NULL DEFAULT 'user'");
    }
};

