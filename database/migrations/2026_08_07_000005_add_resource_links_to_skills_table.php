<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('skills', 'resource_links')) {
            Schema::table('skills', function (Blueprint $table) {
                $table->json('resource_links')
                    ->nullable()
                    ->after('resource_link');
            });
        }
    }

    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn('resource_links');
        });
    }
};
