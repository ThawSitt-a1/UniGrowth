<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('questions', 'editor_id')) {
            Schema::table('questions', function (Blueprint $table) {
                $table->foreignId('editor_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
            });
        }

        if (!Schema::hasColumn('questions', 'locked_by_admin')) {
            Schema::table('questions', function (Blueprint $table) {
                $table->boolean('locked_by_admin')
                    ->default(false)
                    ->after('is_active');
            });
        }

        if (!Schema::hasIndex('questions', 'questions_editor_id_index')) {
            Schema::table('questions', function (Blueprint $table) {
                $table->index('editor_id');
            });
        }

        if (!Schema::hasIndex('questions', 'questions_locked_by_admin_index')) {
            Schema::table('questions', function (Blueprint $table) {
                $table->index('locked_by_admin');
            });
        }
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropIndex(['editor_id']);
            $table->dropIndex(['locked_by_admin']);
            $table->dropForeign(['editor_id']);
            $table->dropColumn(['editor_id', 'locked_by_admin']);
        });
    }
};
