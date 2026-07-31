<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('skills', 'admin_comment')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->text('admin_comment')->nullable()->after('locked_by_admin');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('skills', 'admin_comment')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->dropColumn('admin_comment');
            });
        }
    }
};
