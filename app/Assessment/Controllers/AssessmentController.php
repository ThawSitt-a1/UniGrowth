<?php

declare(strict_types=1);

namespace App\Assessment\Controllers;

use App\Assessment\Http\Requests\QuizSubmissionRequest;
use App\Assessment\Services\QuizDeliveryService;
use App\Assessment\UseCases\EvaluateQuizUseCase;
use Illuminate\Http\JsonResponse;

final class AssessmentController
{
    public function __construct(
        private readonly QuizDeliveryService $quizDeliveryService,
        private readonly EvaluateQuizUseCase $evaluateQuizUseCase,
    ) {
    }

    /**
     * Fetch an unseen quiz for a given skill.
     *
     * GET /api/skills/{skill_id}/quiz
     */
    public function getQuiz(int $skillId): JsonResponse
    {
        $studentId = (int) request()->user()->getAuthIdentifier();

        try {
            $quiz = $this->quizDeliveryService->generateUnseenQuiz($studentId, $skillId);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Skill not found.'], 404);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json([
            'data' => $quiz->toArray(),
        ]);
    }

    /**
     * Submit quiz answers for evaluation.
     *
     * POST /api/skills/{skill_id}/submit
     */
    public function submitQuiz(QuizSubmissionRequest $request, int $skillId): JsonResponse
    {
        $studentId = $request->getStudentId();
        $answers = $request->getAnswers();

        try {
            $result = $this->evaluateQuizUseCase->execute($studentId, $skillId, $answers);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Skill not found.'], 404);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\RuntimeException $e) {
            // e.g. the season was ended between quiz start and submission
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json([
            'data' => $result->toArray(),
        ]);
    }
}

