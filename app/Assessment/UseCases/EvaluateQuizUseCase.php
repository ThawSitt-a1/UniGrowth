<?php

declare(strict_types=1);

namespace App\Assessment\UseCases;

use App\Assessment\DTO\AssessmentResultDTO;
use App\Assessment\Repositories\AssessmentRepositoryInterface;
use App\Assessment\Services\QuestionScoringService;
use App\Assessment\Services\RankingAggregatorService;
use App\Core\Assets\Models\Skill;
use App\Overview\Services\SeasonService;
use Illuminate\Support\Facades\DB;

final class EvaluateQuizUseCase
{
    /**
     * Passing percentage threshold.
     */
    private const PASSING_PERCENTAGE = 60.0;

    public function __construct(
        private readonly AssessmentRepositoryInterface $assessmentRepository,
        private readonly RankingAggregatorService $rankingService,
        private readonly SeasonService $seasonService,
        private readonly QuestionScoringService $scoringService,
    ) {
    }

    /**
     * Orchestrate the transactional grading workflow.
     *
     * @param int $studentId
     * @param int $skillId
     * @param array<int, array{question_id: int, selected_option_id: int}> $answers
     * @return AssessmentResultDTO
     */
    public function execute(int $studentId, int $skillId, array $answers): AssessmentResultDTO
    {
        $skill = Skill::query()->findOrFail($skillId);

        // Extract question IDs from answers
        $questionIds = array_map(fn(array $answer): int => (int) $answer['question_id'], $answers);

        // Fetch correct options from the server (never trust client-side)
        $correctOptionsMap = $this->assessmentRepository->fetchCorrectOptions($questionIds);

        // Fetch question marks from the database (marks are based on type + difficulty)
        $questionsMap = \App\Assessment\Models\Question::query()
            ->whereIn('id', $questionIds)
            ->get()
            ->keyBy('id');

        // Evaluate each answer server-side
        $questionResults = [];
        $rawScore = 0;
        $totalRawScore = 0;

        foreach ($answers as $answer) {
            $questionId = (int) $answer['question_id'];
            $selectedOptionId = (int) $answer['selected_option_id'];

            $correctOptionIds = $correctOptionsMap[$questionId] ?? [];
            $isCorrect = in_array($selectedOptionId, $correctOptionIds, true);

            // Get the marks for this question from the database
            $question = $questionsMap->get($questionId);
            $marks = $question?->marks ?? $this->scoringService->calculateMarks(
                $question?->question_type ?? 'multiple_choice',
                $question?->difficulty ?? 'medium',
            );

            $totalRawScore += $marks;

            if ($isCorrect) {
                $rawScore += $marks;
            }

            $questionResults[] = [
                'question_id' => $questionId,
                'correct' => $isCorrect,
                'correct_option_ids' => $correctOptionIds,
                'marks' => $marks,
            ];
        }

        // Calculate percentage
        $percentage = $totalRawScore > 0
            ? round(($rawScore / $totalRawScore) * 100, 2)
            : 0.0;

        // Check if passed
        $passed = $percentage >= self::PASSING_PERCENTAGE;

        // Build answered questions map for logging
        $answeredMap = [];
        foreach ($answers as $answer) {
            $answeredMap[(int) $answer['question_id']] = (int) $answer['selected_option_id'];
        }

        // Persist attempt and answered questions within a transaction
        $attemptData = [
            'user_id' => $studentId,
            'skill_id' => $skillId,
            'score' => $rawScore,
            'max_score' => $totalRawScore,
            'percentage' => $percentage,
            'passed' => $passed,
        ];

        $attempt = DB::transaction(function () use ($studentId, $attemptData, $answeredMap): \App\Assessment\Models\Attempt {
            return $this->assessmentRepository->logAttemptAndAnsweredQuestions(
                $studentId,
                $attemptData,
                $answeredMap,
            );
        });

        // Calculate weighted proficiency score
        $weightedScore = $this->rankingService->calculateWeightedScore(
            $this->getAverageDifficulty($questionIds),
            $percentage,
        );

// Update proficiency (weighted) and lifetime platform score (raw marks earned)
        $this->rankingService->updateProficiencyAndPlatformScore(
            $studentId,
            $skillId,
            $weightedScore,
            $rawScore,
        );

        // Record score in the current season
        $this->seasonService->recordScoreForSeason(
            $studentId,
            $rawScore,
            count($answers),
        );

        return new AssessmentResultDTO(
            attemptId: (int) $attempt->id,
            skillId: $skillId,
            skillTitle: $skill->title,
            score: $rawScore,
            maxScore: $totalRawScore,
            percentage: $percentage,
            passed: $passed,
            questionResults: $questionResults,
            proficiencyScore: $weightedScore,
        );
    }

    /**
     * Get difficulty of a question.
     */
    private function getQuestionDifficulty(int $questionId): string
    {
        $question = \App\Assessment\Models\Question::query()->find($questionId);

        return $question?->difficulty ?? 'medium';
    }

    /**
     * Calculate average difficulty across all questions.
     */
    private function getAverageDifficulty(array $questionIds): string
    {
        $difficulties = \App\Assessment\Models\Question::query()
            ->whereIn('id', $questionIds)
            ->pluck('difficulty')
            ->toArray();

        if (empty($difficulties)) {
            return 'medium';
        }

        $scoreMap = ['easy' => 1, 'medium' => 2, 'hard' => 3];
        $totalScore = 0;

        foreach ($difficulties as $difficulty) {
            $totalScore += $scoreMap[$difficulty] ?? 2;
        }

        $average = $totalScore / count($difficulties);

        if ($average <= 1.5) {
            return 'easy';
        }
        if ($average <= 2.5) {
            return 'medium';
        }

        return 'hard';
    }
}

