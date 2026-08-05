<?php

declare(strict_types=1);

namespace App\Editor\Controllers;

use App\Editor\DTOs\ContentDeleteDTO;
use App\Editor\DTOs\ContentQueryFilterDTO;
use App\Editor\DTOs\QuestionDataDTO;
use App\Editor\DTOs\QuestionOptionDTO;
use App\Editor\DTOs\SkillDataDTO;
use App\Editor\Http\Requests\OptionRequest;
use App\Editor\Http\Requests\QuestionRequest;
use App\Editor\Http\Requests\SkillRequest;
use App\Editor\UseCases\FetchEditorContentUseCase;
use App\Editor\UseCases\ManageOptionUseCase;
use App\Editor\UseCases\ManageQuestionUseCase;
use App\Editor\UseCases\ManageSkillUseCase;
use App\Core\Assets\Models\Skill;
use App\Assessment\Models\Question;
use App\Assessment\Services\QuestionScoringService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class EditorConsoleController
{
    public function __construct(
        private readonly ManageSkillUseCase $manageSkillUseCase,
        private readonly ManageQuestionUseCase $manageQuestionUseCase,
        private readonly ManageOptionUseCase $manageOptionUseCase,
        private readonly FetchEditorContentUseCase $fetchEditorContentUseCase,
        private readonly QuestionScoringService $scoringService,
    ) {
    }

    /**
     * Editor dashboard listing all content.
     *
     * GET /editor
     */
    public function dashboard(Request $request): View
    {
        $editorId = (int) $request->user()->id;
        $perPage = (int) $request->query('per_page', 15);

        $filters = new ContentQueryFilterDTO(
            editorId: $editorId,
            searchQuery: $request->query('search'),
            skillId: $request->query('skill_id') ? (int) $request->query('skill_id') : null,
            perPage: $perPage,
        );

        $content = $this->fetchEditorContentUseCase->execute($filters);

        // Fetch skills with enrollment counts for dashboard metrics
        $skills = Skill::query()
            ->where('editor_id', $editorId)
            ->withCount('enrollments')
            ->orderBy('created_at', 'desc')
            ->get();

        // Top enrolled skill
        $topEnrolledSkill = $skills->sortByDesc('enrollments_count')->first();

        // Recent skills with enrollment
        $recentSkills = $skills->take(5);

        // Total stats
        $totalSkills = $skills->count();
        $totalQuestions = Question::query()->where('editor_id', $editorId)->count();
        $totalEnrollments = $skills->sum('enrollments_count');

        return view('editor.dashboard', [
            'content' => $content,
            'skills' => $skills,
            'topEnrolledSkill' => $topEnrolledSkill,
            'recentSkills' => $recentSkills,
            'totalSkills' => $totalSkills,
            'totalQuestions' => $totalQuestions,
            'totalEnrollments' => $totalEnrollments,
        ]);
    }

    /** Skill management index view. GET /editor/skills */
    public function skillsIndex(Request $request): View
    {
        $editorId = (int) $request->user()->id;

        $skills = Skill::query()
            ->where('editor_id', $editorId)
            ->withCount('enrollments')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('editor.skills-index', [
            'skills' => $skills,
        ]);
    }

    /**
     * Show create/edit skill form.
     *
     * GET /editor/skills/create
     * GET /editor/skills/{id}/edit
     */
    public function editSkill(Request $request, ?int $id = null): View
    {
        $skill = null;
        if ($id) {
            $skill = Skill::query()->findOrFail($id);
        }
        return view('editor.skills-form', [
            'skill' => $skill,
        ]);
    }

    /**
     * Save skill (create or update).
     *
     * POST /editor/skills
     */
    public function saveSkill(SkillRequest $request): RedirectResponse
    {
        $editorId = (int) $request->user()->id;

        try {
            // Process resource links - filter out empty ones
            $resourceLinks = [];
            if ($request->has('resource_links')) {
                foreach ($request->input('resource_links', []) as $link) {
                    if (!empty($link['url'])) {
                        $resourceLinks[] = [
                            'url' => $link['url'],
                            'label' => $link['label'] ?? '',
                        ];
                    }
                }
            }

            $dto = new SkillDataDTO(
                skillId: $request->input('skill_id'),
                editorId: $editorId,
                title: $request->input('title'),
                slug: $request->input('slug'),
                description: $request->input('description', ''),
                tags: $request->input('tags', []),
                content: $request->input('content', ''),
                resourceLink: $request->input('resource_link', ''),
                resourceLinks: $resourceLinks,
            );

            $this->manageSkillUseCase->execute($dto);

            return redirect()
                ->route('editor.skills.index')
                ->with('success', 'Skill saved successfully.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Delete a skill.
     *
     * POST /editor/skills/{id}/delete
     */
    public function deleteSkill(Request $request, int $id): RedirectResponse
    {
        $editorId = (int) $request->user()->id;

        try {
            $this->manageSkillUseCase->delete($id, $editorId);

            return redirect()
                ->route('editor.skills.index')
                ->with('success', 'Skill deleted successfully.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('editor.skills.index')
                ->with('error', $e->getMessage());
        }
    }

    /** Question management index view. GET /editor/questions */
    public function questionsIndex(Request $request): View
    {
        $editorId = (int) $request->user()->id;

        $questions = Question::query()
            ->where('editor_id', $editorId)
            ->with(['skill', 'options'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $skills = Skill::query()->where('editor_id', $editorId)->get();

        return view('editor.questions-index', [
            'questions' => $questions,
            'skills' => $skills,
        ]);
    }

    /**
     * Show create/edit question form.
     *
     * GET /editor/questions/create
     * GET /editor/questions/{id}/edit
     */
    public function editQuestion(Request $request, ?int $id = null): View
    {
        $editorId = (int) $request->user()->id;
        $question = null;
        if ($id) {
            $question = Question::query()->with('options')->findOrFail($id);
        }
        $skills = Skill::query()->where('editor_id', $editorId)->get();

        return view('editor.questions-form', [
            'question' => $question,
            'skills' => $skills,
            'marksMatrix' => $this->scoringService->getMarksMatrix(),
        ]);
    }

/**
     * Save question (create or update) with inline options.
     *
     * POST /editor/questions
     */
    public function saveQuestion(QuestionRequest $request): RedirectResponse
    {
        $editorId = (int) $request->user()->id;

        try {
            $questionType = $request->input('question_type', 'multiple_choice');
            $difficulty = $request->input('difficulty');
            $marks = (float) $request->input('marks', $this->scoringService->calculateMarks($questionType, $difficulty));

            // Process inline options - filter out empty options
            $options = [];
            $rawOptions = $request->input('options', []);
            foreach ($rawOptions as $opt) {
                $optionText = trim($opt['option_text'] ?? '');
                if (empty($optionText)) {
                    continue;
                }
                $options[] = [
                    'option_text' => $optionText,
                    'is_correct' => !empty($opt['is_correct']),
                    'option_id' => !empty($opt['option_id']) ? (int) $opt['option_id'] : null,
                ];
            }

            $dto = new QuestionDataDTO(
                questionId: $request->input('question_id'),
                editorId: $editorId,
                skillId: (int) $request->input('skill_id'),
                questionText: $request->input('question_text'),
                difficulty: $difficulty,
                questionType: $questionType,
                marks: $marks,
                options: $options,
            );

            $this->manageQuestionUseCase->execute($dto);

            return redirect()
                ->route('editor.questions.index')
                ->with('success', 'Question saved successfully.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Delete a question.
     *
     * POST /editor/questions/{id}/delete
     */
    public function deleteQuestion(Request $request, int $id): RedirectResponse
    {
        $editorId = (int) $request->user()->id;

        try {
            $this->manageQuestionUseCase->delete($id, $editorId);

            return redirect()
                ->route('editor.questions.index')
                ->with('success', 'Question deleted successfully.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('editor.questions.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Save option (create or update).
     *
     * POST /editor/options
     */
    public function saveOption(OptionRequest $request): RedirectResponse
    {
        $editorId = (int) $request->user()->id;

        try {
            $dto = new QuestionOptionDTO(
                optionId: $request->input('option_id'),
                editorId: $editorId,
                questionId: (int) $request->input('question_id'),
                optionText: $request->input('option_text'),
                isCorrect: (bool) $request->input('is_correct'),
            );

            $this->manageOptionUseCase->execute($dto);

            return redirect()
                ->route('editor.questions.index')
                ->with('success', 'Option saved successfully.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Delete an option.
     *
     * POST /editor/options/{id}/delete
     */
    public function deleteOption(Request $request, int $id): RedirectResponse
    {
        $editorId = (int) $request->user()->id;

        try {
            $this->manageOptionUseCase->delete($id, $editorId);

            return redirect()
                ->route('editor.questions.index')
                ->with('success', 'Option deleted successfully.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('editor.questions.index')
                ->with('error', $e->getMessage());
        }
    }

    /** History log view. GET /editor/history */
    public function history(Request $request): View
    {
        $editorId = (int) $request->user()->id;

        $search = $request->query('search');

        $skills = Skill::query()
            ->where('editor_id', $editorId)
            ->withCount('enrollments')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('slug', 'like', '%' . $search . '%')
                        ->orWhere('id', (int) $search ?: '')
                        ->orWhere('tags', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('editor.history-index', [
            'skills' => $skills,
            'search' => $search,
        ]);
    }

    /** Editor settings view. GET /editor/settings */
    public function settings(Request $request): View
    {
        $user = $request->user();

        return view('editor.settings', [
            'user' => $user,
        ]);
    }
}
