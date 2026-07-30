<?php

declare(strict_types=1);

namespace App\Editor\DTOs;

final class QuestionOptionDTO
{
    public function __construct(
        public readonly ?int $optionId,
        public readonly int $editorId,
        public readonly int $questionId,
        public readonly string $optionText,
        public readonly bool $isCorrect,
    ) {
    }
}
