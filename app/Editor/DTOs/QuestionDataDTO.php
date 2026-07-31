<?php

declare(strict_types=1);

namespace App\Editor\DTOs;

final class QuestionDataDTO
{
    public function __construct(
        public readonly ?int $questionId,
        public readonly int $editorId,
        public readonly int $skillId,
        public readonly string $questionText,
        public readonly string $difficulty,
        public readonly string $questionType = 'multiple_choice',
        public readonly float $marks = 10.00,
    ) {
    }
}
