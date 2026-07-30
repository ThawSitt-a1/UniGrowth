<?php

declare(strict_types=1);

namespace App\Assessment\DTO;

final class QuizPayloadDTO
{
    /**
     * @param array<int, array{id: int, question_text: string, difficulty: string, options: array<int, array{id: int, option_text: string}>}> $questions
     */
    public function __construct(
        public readonly int $skillId,
        public readonly string $skillTitle,
        public readonly int $totalQuestions,
        public readonly array $questions,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'skill_id' => $this->skillId,
            'skill_title' => $this->skillTitle,
            'total_questions' => $this->totalQuestions,
            'questions' => $this->questions,
        ];
    }
}

