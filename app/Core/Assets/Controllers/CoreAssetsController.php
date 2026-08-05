<?php

declare(strict_types=1);

namespace App\Core\Assets\Controllers;

use App\Core\Assets\DTO\AssetActionDTO;
use App\Core\Assets\Helpers\ContentBlockParser;
use App\Core\Assets\Http\Requests\AssetActionRequest;
use App\Core\Assets\UseCases\GetUserActivityUseCase;
use App\Core\Assets\UseCases\ListAvailableSkillsUseCase;
use App\Core\Assets\UseCases\ManageUserAssetsUseCase;
use App\Core\Recommendation\UseCases\GenerateRecommendationsUseCase;
use App\Assessment\Models\Question;
use App\Core\Assets\Models\Enrollment;
use App\Core\Assets\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class CoreAssetsController
{
    public function __construct(
        private readonly ManageUserAssetsUseCase $manageUserAssetsUseCase,
        private readonly GetUserActivityUseCase $getUserActivityUseCase,
        private readonly ListAvailableSkillsUseCase $listAvailableSkillsUseCase,
        private readonly GenerateRecommendationsUseCase $recommendationUseCase,
    ) {
    }

    public function index(Request $request): View
    {
        $userId = (int) $request->user()->getAuthIdentifier();
        $profile = $this->getUserActivityUseCase->execute($userId);

        return view('goals', [
            'profile' => $profile,
        ]);
    }

    public function skills(Request $request): View
    {
        $tag = $request->query('tag');
        $sortBy = $request->query('sort', 'newest');
        $userId = (int) $request->user()->getAuthIdentifier();

        $availableSkills = $this->listAvailableSkillsUseCase->execute($tag, $sortBy);
        $recommendations = array_map(
            static fn ($dto) => $dto->toArray(),
            $this->recommendationUseCase->execute($userId, 4)
        );

        return view('skills', [
            'availableSkills' => $availableSkills,
            'recommendations' => $recommendations,
            'sortBy' => $sortBy,
            'selectedTag' => $tag,
        ]);
    }

    public function skillDetail(Request $request, string $identifier): View
    {
        $userId = (int) $request->user()->getAuthIdentifier();

        // Support both slug (string) and ID (numeric)
        $skillQuery = Skill::query()->withCount('enrollments');

        if (is_numeric($identifier)) {
            $skillQuery->where('id', (int) $identifier);
        } else {
            $skillQuery->where('slug', $identifier);
        }

        $skill = $skillQuery->firstOrFail();

        $isSuspended = !$skill->is_active;
        $suspensionReason = $skill->admin_comment ?: 'This skill has been suspended by our moderators and is currently unavailable.';

        $isEnrolled = false;
        $questions = collect();
        $contentBlocks = [];
        $headings = [];

        if (! $isSuspended) {
            $isEnrolled = Enrollment::query()
                ->where('user_id', $userId)
                ->where('skill_id', $skill->id)
                ->exists();

            $questions = Question::query()
                ->where('skill_id', $skill->id)
                ->with('options')
                ->get();

            // Parse content blocks for enhanced rendering
            $contentBlocks = !empty($skill->content)
                ? ContentBlockParser::parse($skill->content)
                : [];

            $headings = !empty($skill->content)
                ? ContentBlockParser::extractHeadings($skill->content)
                : [];
        }

        return view('skill-detail', [
            'skill' => $skill,
            'isEnrolled' => $isEnrolled,
            'questions' => $questions,
            'contentBlocks' => $contentBlocks,
            'headings' => $headings,
            'isSuspended' => $isSuspended,
            'suspensionReason' => $suspensionReason,
        ]);
    }

public function handleAssetAction(AssetActionRequest $request): RedirectResponse
    {
        $dto = new AssetActionDTO(
            type: (string) $request->input('type'),
            action: (string) $request->input('action'),
            payload: (array) $request->input('payload', []),
        );

        // Determine redirect target:
        // 1. If a custom `redirect` URL is provided in the request (e.g. from skill detail pages), use it.
        // 2. Otherwise, fall back to the core-assets index with the appropriate fragment anchor.
        $customRedirect = $request->input('redirect');
        $fragment = $dto->type === 'habit' ? '#pane-habits' : '#pane-goals';
        $fallbackRoute = $customRedirect
            ? redirect()->to($customRedirect)
            : redirect()->route('core-assets.index')->withFragment($fragment);

        try {
            $this->manageUserAssetsUseCase->execute($dto);
        } catch (\InvalidArgumentException $e) {
            return $fallbackRoute->with('error', $e->getMessage());
        } catch (\RuntimeException $e) {
            return $fallbackRoute->with('error', $e->getMessage());
        }

        return $fallbackRoute->with('success', 'Action completed successfully.');
    }
}
