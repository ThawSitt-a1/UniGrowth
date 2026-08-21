<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('skills', 'project_suggestion')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->longText('project_suggestion')->nullable()->after('resource_links');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('skills', 'project_suggestion')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->dropColumn('project_suggestion');
            });
        }
    }
};
