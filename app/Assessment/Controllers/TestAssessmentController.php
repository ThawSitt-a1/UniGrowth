<?php

declare(strict_types=1);

namespace App\Assessment\Controllers;

use App\Assessment\Services\QuizDeliveryService;
use App\Assessment\Services\StudentDashboardService;
use App\Assessment\UseCases\EvaluateQuizUseCase;
use App\Core\Assets\Models\Skill;
use App\Overview\Services\SeasonService;
use App\Overview\Services\StudentOverviewService;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class TestAssessmentController
{
    public function __construct(
        private readonly QuizDeliveryService $quizDeliveryService,
        private readonly EvaluateQuizUseCase $evaluateQuizUseCase,
        private readonly StudentDashboardService $dashboardService,
        private readonly SeasonService $seasonService,
        private readonly StudentOverviewService $overviewService,
    ) {
    }

    /**
     * Browser-based test UI for the Skill Assessment & Ranking system.
     *
     * GET /assessment/test
     */
    public function index(Request $request): View
    {
        $studentId = (int) $request->user()->getAuthIdentifier();
        $skills = Skill::query()->orderBy('title')->get(['id', 'title']);
$selectedSkillId = (int) $request->query('skill_id');
        $quiz = null;
        $result = null;
        $dashboard = null;
        $leaderboard = null;

        if ($selectedSkillId) {
            try {
                $quiz = $this->quizDeliveryService->generateUnseenQuiz($studentId, $selectedSkillId);
            } catch (\RuntimeException $e) {
                session()->flash('error', $e->getMessage());
            } catch (\Exception $e) {
                session()->flash('error', 'Could not generate quiz: ' . $e->getMessage());
            }
        }

        // Keep the assessment-specific progress metrics (attempts, avg, answered).
        $dashboard = $this->dashboardService->aggregateProgressMetrics($studentId);

        // Season-based data (same sources as the /dashboard page).
        $seasonInfo = $this->seasonService->getCurrentSeasonInfo();
        $overview = $this->overviewService->getStudentOverview($studentId);
        $currentSeason = $this->seasonService->getCurrentSeason();
        $seasonLeaderboard = $currentSeason
            ? $this->seasonService->getSeasonLeaderboard($currentSeason->id, 10)
            : [];

        $seasonScore = $overview->totalSeasonScore;
        $seasonRank = $overview->seasonRank;

        return view('assessment.test-assessment', [
            'skills' => $skills,
            'selectedSkillId' => $selectedSkillId,
            'quiz' => $quiz?->toArray(),
            'result' => $result,
            'dashboard' => $dashboard,
            'leaderboard' => $seasonLeaderboard,
            'seasonInfo' => $seasonInfo,
            'hasActiveSeason' => $seasonInfo->isActive,
            'currentSeasonName' => $seasonInfo->seasonName,
            'seasonScore' => $seasonScore,
            'seasonRank' => $seasonRank,
        ]);
    }

    /**
     * Handle quiz submission from the test UI.
     *
     * POST /assessment/test/submit
     */
    public function submit(Request $request): \Illuminate\Http\RedirectResponse
    {
        $studentId = (int) $request->user()->getAuthIdentifier();
        $skillId = (int) $request->input('skill_id');
        $answersInput = $request->input('answers', []);

        // Build structured answers array
        $answers = [];
        foreach ($answersInput as $questionId => $selectedOptionId) {
            $answers[] = [
                'question_id' => (int) $questionId,
                'selected_option_id' => (int) $selectedOptionId,
            ];
        }

        try {
            $result = $this->evaluateQuizUseCase->execute($studentId, $skillId, $answers);

            return redirect()
                ->route('assessment.test.index', ['skill_id' => $skillId])
                ->with('result', $result->toArray())
                ->with('success', 'Quiz submitted successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->route('assessment.test.index', ['skill_id' => $skillId])
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
}

