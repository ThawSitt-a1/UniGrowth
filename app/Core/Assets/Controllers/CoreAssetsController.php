<?php

declare(strict_types=1);

namespace App\Core\Assets\Controllers;

use App\Core\Assets\DTO\AssetActionDTO;
use App\Core\Assets\Http\Requests\AssetActionRequest;
use App\Core\Assets\UseCases\GetUserActivityUseCase;
use App\Core\Assets\UseCases\ListAvailableSkillsUseCase;
use App\Core\Assets\UseCases\ManageUserAssetsUseCase;
use App\Core\Recommendation\UseCases\GenerateRecommendationsUseCase;
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

    public function handleAssetAction(AssetActionRequest $request): RedirectResponse
    {
        $dto = new AssetActionDTO(
            type: (string) $request->input('type'),
            action: (string) $request->input('action'),
            payload: (array) $request->input('payload',[]),
        );

        try {
            $this->manageUserAssetsUseCase->execute($dto);
        } catch (\InvalidArgumentException $e) {
            return redirect()->route('core-assets.index')
                ->with('error', $e->getMessage());
        } catch (\RuntimeException $e) {
            return redirect()->route('core-assets.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('core-assets.index')
            ->with('success', 'Action completed successfully.');
    }
}
