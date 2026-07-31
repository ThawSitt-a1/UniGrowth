<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Marks matrix: [question_type => [difficulty => marks]].
     * True/false questions are worth less than multiple-choice questions
     * for the same difficulty level.
     */
    private const MARKS_MATRIX = [
        'multiple_choice' => [
            'easy'   => 10.00,
            'medium' => 15.00,
            'hard'   => 20.00,
        ],
        'true_false' => [
            'easy'   => 5.00,
            'medium' => 7.50,
            'hard'   => 10.00,
        ],
    ];

    public function up(): void
    {
        // Backfill marks for every question based on its type + difficulty
        foreach (self::MARKS_MATRIX as $type => $difficulties) {
            foreach ($difficulties as $difficulty => $marks) {
                DB::table('questions')
                    ->where('question_type', $type)
                    ->where('difficulty', $difficulty)
                    ->update(['marks' => $marks]);
            }
        }

        // Any questions that don't match the matrix get the default 10.00
        DB::table('questions')
            ->whereNull('marks')
            ->orWhere('marks', 0)
            ->update(['marks' => 10.00]);
    }

    public function down(): void
    {
        // Revert all marks to the previous default of 10.00
        DB::table('questions')->update(['marks' => 10.00]);
    }
};
