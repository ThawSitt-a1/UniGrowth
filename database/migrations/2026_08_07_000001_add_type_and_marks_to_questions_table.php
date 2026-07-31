<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('questions', 'question_type')) {
            Schema::table('questions', function (Blueprint $table) {
                $table->enum('question_type', ['multiple_choice', 'true_false'])
                    ->default('multiple_choice')
                    ->after('question_text');
            });
        }

        if (!Schema::hasColumn('questions', 'marks')) {
            Schema::table('questions', function (Blueprint $table) {
                $table->decimal('marks', 6, 2)
                    ->default(10.00)
                    ->after('difficulty');
            });
        }

        if (!Schema::hasIndex('questions', 'questions_question_type_index')) {
            Schema::table('questions', function (Blueprint $table) {
                $table->index('question_type');
            });
        }
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropIndex(['question_type']);
            $table->dropColumn(['question_type', 'marks']);
        });
    }
};
