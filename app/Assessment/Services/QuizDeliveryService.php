<?php

declare(strict_types=1);

namespace App\Assessment\Services;

use App\Assessment\DTO\QuizPayloadDTO;
use App\Assessment\Repositories\AssessmentRepositoryInterface;
use App\Core\Assets\Models\Skill;
use App\Overview\Services\SeasonService;

final class QuizDeliveryService
{
    public function __construct(
        private readonly AssessmentRepositoryInterface $assessmentRepository,
        private readonly SeasonService $seasonService,
    ) {
    }

    /**
     * Generate a quiz for the student containing only unseen questions.
     * Strips the `is_correct` flag from options before returning.
     *
     * @throws \RuntimeException if no active season exists
     */
    public function generateUnseenQuiz(int $studentId, int $skillId): QuizPayloadDTO
    {
        // Ensure an active season exists - users cannot answer questions outside a season
        if (!$this->seasonService->hasActiveSeason()) {
            throw new \RuntimeException(
                'No active season is running. Quizzes are only available during an active season.'
            );
        }

        $skill = Skill::query()->findOrFail($skillId);
        $questions = $this->assessmentRepository->fetchUnseenActiveQuestionsForSkill($studentId, $skillId);

        $sanitizedQuestions = [];
        foreach ($questions as $question) {
            // Skip questions with no options - they cannot be answered
            if ($question->options->isEmpty()) {
                continue;
            }
            $sanitizedOptions = [];
            foreach ($question->options as $option) {
                $sanitizedOptions[] = [
                    'id' => $option->id,
                    'option_text' => $option->option_text,
                ];
            }

            $sanitizedQuestions[] = [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'question_type' => $question->question_type,
                'difficulty' => $question->difficulty,
                'marks' => (float) $question->marks,
                'options' => $sanitizedOptions,
            ];
        }

        return new QuizPayloadDTO(
            skillId: (int) $skill->id,
            skillTitle: $skill->title,
            totalQuestions: count($sanitizedQuestions),
            questions: $sanitizedQuestions,
        );
    }
}

