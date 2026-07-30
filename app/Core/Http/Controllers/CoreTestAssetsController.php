<?php

declare(strict_types=1);

namespace App\Core\Http\Controllers;

use App\Core\Assets\DTO\AssetActionDTO;
use App\Core\Assets\UseCases\GetUserActivityUseCase;
use App\Core\Assets\UseCases\ManageUserAssetsUseCase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Deliberately minimal/ugly testing frontend for Core Assets.
 *
 * Exercises Core service business logic directly:
 * - ManageUserAssetsUseCase (goal CRUD, skill enrollment)
 * - GetUserActivityUseCase  (viewing activity profile)
 *
 * Not for production — testing only.
 */
final class CoreTestAssetsController
{
    public function __construct(
        private readonly ManageUserAssetsUseCase $manageUserAssetsUseCase,
        private readonly GetUserActivityUseCase $getUserActivityUseCase,
    ) {
    }

    public function index(Request $request): View
    {
        $userId = (int) $request->user()->getAuthIdentifier();
        $profile = $this->getUserActivityUseCase->execute($userId);

        return view('core.test-assets', [
            'profile' => $profile,
        ]);
    }

    public function createGoal(Request $request): RedirectResponse
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);

        $dto = new AssetActionDTO(
            type: 'goal',
            action: 'create',
            payload: ['text' => $request->string('text')->toString()],
        );

        try {
            $this->manageUserAssetsUseCase->execute($dto);
        } catch (\InvalidArgumentException | \RuntimeException $e) {
            return redirect()->route('core.test-assets.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('core.test-assets.index')
            ->with('success', 'Goal created.');
    }

    public function completeGoal(Request $request): RedirectResponse
    {
        $request->validate(['goal_id' => 'required|integer|min:1']);

        $dto = new AssetActionDTO(
            type: 'goal',
            action: 'complete',
            payload: ['goal_id' => (int) $request->input('goal_id')],
        );

        try {
            $this->manageUserAssetsUseCase->execute($dto);
        } catch (\InvalidArgumentException | \RuntimeException $e) {
            return redirect()->route('core.test-assets.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('core.test-assets.index')
            ->with('success', 'Goal completed.');
    }

    public function deleteGoal(Request $request): RedirectResponse
    {
        $request->validate(['goal_id' => 'required|integer|min:1']);

        $dto = new AssetActionDTO(
            type: 'goal',
            action: 'delete',
            payload: ['goal_id' => (int) $request->input('goal_id')],
        );

        try {
            $this->manageUserAssetsUseCase->execute($dto);
        } catch (\InvalidArgumentException | \RuntimeException $e) {
            return redirect()->route('core.test-assets.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('core.test-assets.index')
            ->with('success', 'Goal deleted.');
    }

    public function enrollSkill(Request $request): RedirectResponse
    {
        $request->validate(['skill_id' => 'required|integer|min:1']);

        $dto = new AssetActionDTO(
            type: 'skill',
            action: 'enroll',
            payload: ['skill_id' => (int) $request->input('skill_id')],
        );

        try {
            $this->manageUserAssetsUseCase->execute($dto);
        } catch (\InvalidArgumentException | \RuntimeException $e) {
            return redirect()->route('core.test-assets.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('core.test-assets.index')
            ->with('success', 'Enrolled in skill.');
    }

    public function unenrollSkill(Request $request): RedirectResponse
    {
        $request->validate(['skill_id' => 'required|integer|min:1']);

        $dto = new AssetActionDTO(
            type: 'skill',
            action: 'unenroll',
            payload: ['skill_id' => (int) $request->input('skill_id')],
        );

        try {
            $this->manageUserAssetsUseCase->execute($dto);
        } catch (\InvalidArgumentException | \RuntimeException $e) {
            return redirect()->route('core.test-assets.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('core.test-assets.index')
            ->with('success', 'Unenrolled from skill.');
    }
}

