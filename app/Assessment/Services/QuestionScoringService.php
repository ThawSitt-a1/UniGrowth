<?php

declare(strict_types=1);

namespace App\Assessment\Services;

/**
 * Centralised question scoring logic.
 *
 * Marks are determined by a combination of question type and difficulty:
 *  - Multiple-choice questions are worth more than true/false questions.
 *  - Hard questions are worth more than medium, which are worth more than easy.
 *
 * The "highest score" for a season equals the sum of marks across all active
 * questions — i.e. the maximum achievable score if every question is answered
 * correctly.
 */
final class QuestionScoringService
{
    /**
     * Marks matrix: [question_type => [difficulty => marks]].
     */
    public const MARKS_MATRIX = [
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

    /**
     * Default marks fallback (used when type/difficulty is unexpected).
     */
    public const DEFAULT_MARKS = 10.00;

    /**
     * Calculate the marks for a single question based on its type and difficulty.
     */
    public function calculateMarks(string $questionType, string $difficulty): float
    {
        return self::MARKS_MATRIX[$questionType][$difficulty]
            ?? self::DEFAULT_MARKS;
    }

    /**
     * Calculate the total combined marks for a collection of questions.
     *
     * @param iterable $questions  Each item must expose `question_type` and `difficulty` (or `marks`).
     */
    public function calculateTotalMarks(iterable $questions): float
    {
        $total = 0.0;

        foreach ($questions as $question) {
            // Prefer the stored marks column when available
            if (isset($question->marks)) {
                $total += (float) $question->marks;
                continue;
            }

            $type = $question->question_type ?? 'multiple_choice';
            $difficulty = $question->difficulty ?? 'medium';
            $total += $this->calculateMarks($type, $difficulty);
        }

        return round($total, 2);
    }

    /**
     * Get the full marks matrix (for display in UI / docs).
     *
     * @return array<string, array<string, float>>
     */
    public function getMarksMatrix(): array
    {
        return self::MARKS_MATRIX;
    }
}
