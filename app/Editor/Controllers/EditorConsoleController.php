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
        $skills = Skill::query()->where('editor_id', $editorId)->get();

        return view('editor.dashboard', [
            'content' => $content,
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
            $dto = new SkillDataDTO(
                skillId: $request->input('skill_id'),
                editorId: $editorId,
                title: $request->input('title'),
                slug: $request->input('slug'),
                description: $request->input('description', ''),
            );

            $this->manageSkillUseCase->execute($dto);

            return redirect()
                ->route('editor.dashboard')
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
                ->route('editor.dashboard')
                ->with('success', 'Skill deleted successfully.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('editor.dashboard')
                ->with('error', $e->getMessage());
        }
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
        ]);
    }

    /**
     * Save question (create or update).
     *
     * POST /editor/questions
     */
    public function saveQuestion(QuestionRequest $request): RedirectResponse
    {
        $editorId = (int) $request->user()->id;

        try {
            $dto = new QuestionDataDTO(
                questionId: $request->input('question_id'),
                editorId: $editorId,
                skillId: (int) $request->input('skill_id'),
                questionText: $request->input('question_text'),
                difficulty: $request->input('difficulty'),
            );

            $this->manageQuestionUseCase->execute($dto);

            return redirect()
                ->route('editor.dashboard')
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
                ->route('editor.dashboard')
                ->with('success', 'Question deleted successfully.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('editor.dashboard')
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
                ->route('editor.dashboard')
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
                ->route('editor.dashboard')
                ->with('success', 'Option deleted successfully.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('editor.dashboard')
                ->with('error', $e->getMessage());
        }
    }
}
