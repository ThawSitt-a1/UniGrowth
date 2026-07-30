<?php

declare(strict_types=1);

namespace App\Assessment\DTO;

final class AssessmentResultDTO
{
    /**
     * @param array<int, array{question_id: int, correct: bool, correct_option_ids: int[]}> $questionResults
     */
    public function __construct(
        public readonly int $attemptId,
        public readonly int $skillId,
        public readonly string $skillTitle,
        public readonly float $score,
        public readonly float $maxScore,
        public readonly float $percentage,
        public readonly bool $passed,
        public readonly array $questionResults,
        public readonly float $proficiencyScore,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'attempt_id' => $this->attemptId,
            'skill_id' => $this->skillId,
            'skill_title' => $this->skillTitle,
            'score' => $this->score,
            'max_score' => $this->maxScore,
            'percentage' => $this->percentage,
            'passed' => $this->passed,
            'question_results' => $this->questionResults,
            'proficiency_score' => $this->proficiencyScore,
        ];
    }
}

