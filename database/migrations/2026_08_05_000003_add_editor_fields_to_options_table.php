<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('options', 'editor_id')) {
            Schema::table('options', function (Blueprint $table) {
                $table->foreignId('editor_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('options', 'locked_by_admin')) {
            Schema::table('options', function (Blueprint $table) {
                $table->boolean('locked_by_admin')
                    ->default(false)
                    ->after('is_correct');
            });
        }

        if (!Schema::hasIndex('options', 'options_editor_id_index')) {
            Schema::table('options', function (Blueprint $table) {
                $table->index('editor_id');
            });
        }

        if (!Schema::hasIndex('options', 'options_locked_by_admin_index')) {
            Schema::table('options', function (Blueprint $table) {
                $table->index('locked_by_admin');
            });
        }
    }

    public function down(): void
    {
        Schema::table('options', function (Blueprint $table) {
            $table->dropIndex(['editor_id']);
            $table->dropIndex(['locked_by_admin']);
            $table->dropForeign(['editor_id']);
            $table->dropColumn(['editor_id', 'locked_by_admin']);
        });
    }
};
