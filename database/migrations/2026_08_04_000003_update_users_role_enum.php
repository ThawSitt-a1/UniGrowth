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

        // 2. For MySQL, use the raw MODIFY COLUMN statement since the Schema
        // builder does not support changing ENUM values. For SQLite (used by
        // the test-suite) the column is a plain TEXT column, so no change is
        // required — the application layer validates role values in PHP.
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'admin', 'editor') NOT NULL DEFAULT 'user'");
        }
    }

    public function down(): void
    {
        // Restore original enum (safe revert)
        DB::table('users')
            ->where('role', 'editor')
            ->update(['role' => 'user']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admins', 'user', 'superadmin') NOT NULL DEFAULT 'user'");
        }
    }
};

