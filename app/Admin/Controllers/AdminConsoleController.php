<?php

declare(strict_types=1);

namespace App\Admin\Controllers;

use App\Admin\DTOs\ContentActionDTO;
use App\Admin\DTOs\RoleAssignmentDTO;
use App\Admin\DTOs\UserStatusDTO;
use App\Admin\Http\Requests\ContentActionRequest;
use App\Admin\Http\Requests\UpdateSystemSettingsRequest;
use App\Admin\Services\AdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class AdminConsoleController
{
    public function __construct(
        private readonly AdminService $adminService,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    private function getSharedData(Request $request): array
    {
        $timeFrame = $request->query('time_frame', 'all');
        $search = $request->query('search');
        $roleFilter = $request->query('role', 'all');

        return [
            'metrics' => $this->adminService->getDashboardData($timeFrame),
            'timeFrame' => $timeFrame,
            'users' => $this->adminService->getAllUsers($search),
            'search' => $search,
            'roleFilter' => $roleFilter,
            'allUsersAndEditors' => $this->adminService->getAllUsersAndEditors($search, $roleFilter),
            'editors' => $this->adminService->getAllEditors(),
            'allContent' => $this->adminService->getAllEditorContent(),
            'suspendedContent' => $this->adminService->getSuspendedContent(),
            'reports' => $this->adminService->getBugReports(),
            'settings' => $this->adminService->getSystemSettings(),
            'seasonStatus' => $this->adminService->getSeasonStatus(),
        ];
    }

    public function dashboard(Request $request): View
    {
        return view('admin.dashboard', $this->getSharedData($request));
    }

    public function users(Request $request): View
    {
        return view('admin.users-editors', $this->getSharedData($request));
    }

    public function updateAccountStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:allowed,banned,suspended'],
            'suspended_until' => ['nullable', 'date', 'after:now'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            $dto = new UserStatusDTO(
                targetUserId: $id,
                status: $request->input('status'),
                suspendedUntil: $request->input('suspended_until'),
                reason: $request->input('reason', ''),
            );

            $this->adminService->updateAccountStatus($dto);

            return redirect()
                ->back()
                ->with('success', "User #{$id} status updated to '{$request->input('status')}'.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update user status: ' . $e->getMessage());
        }
    }

    public function assignRole(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'string', 'in:user,editor'],
        ]);

        try {
            $dto = new RoleAssignmentDTO(
                userId: $id,
                newRole: $request->input('role'),
            );

            $this->adminService->assignUserRole($dto);

            return redirect()
                ->back()
                ->with('success', "User #{$id} role updated to '{$request->input('role')}'.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to assign role: ' . $e->getMessage());
        }
    }

    public function content(): View
    {
        return view('admin.content', $this->getSharedData(request()));
    }

    public function contentAction(ContentActionRequest $request): RedirectResponse
    {
        try {
            $dto = new ContentActionDTO(
                targetId: (int) $request->input('target_id'),
                targetType: $request->input('target_type'),
                action: $request->input('action'),
                reason: $request->input('reason', ''),
            );

            $this->adminService->manageContent($dto);

            return redirect()
                ->back()
                ->with('success', "Content action '{$dto->action}' executed on {$dto->targetType} #{$dto->targetId}.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to execute content action: ' . $e->getMessage());
        }
    }

    public function addContentComment(Request $request, int $skillId): RedirectResponse
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:5000'],
        ]);

        try {
            $this->adminService->addSkillComment($skillId, $request->input('comment'));

            return redirect()
                ->back()
                ->with('success', "Comment added to skill #{$skillId}.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to add comment: ' . $e->getMessage());
        }
    }

    public function settings(): View
    {
        return view('admin.settings', $this->getSharedData(request()));
    }

    public function updateSettings(UpdateSystemSettingsRequest $request): RedirectResponse
    {
        try {
            $this->adminService->updateSystemSettings(
                $request->input('setting_key'),
                $request->input('setting_value'),
            );

            return redirect()
                ->back()
                ->with('success', "Setting '{$request->input('setting_key')}' updated.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update setting: ' . $e->getMessage());
        }
    }

    public function bugReports(): View
    {
        return view('admin.bugs', $this->getSharedData(request()));
    }

    public function updateBugReport(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,reviewed,in_progress,resolved'],
        ]);

        try {
            $this->adminService->updateBugReportStatus($id, $request->input('status'));

            return redirect()
                ->back()
                ->with('success', "Bug report #{$id} status updated to '{$request->input('status')}'.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update bug report: ' . $e->getMessage());
        }
    }

    public function editors(): View
    {
        return view('admin.users-editors', $this->getSharedData(request()));
    }

    public function suspendEditor(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'suspended_until' => ['nullable', 'date', 'after:now'],
        ]);

        try {
            $this->adminService->suspendEditor($id, $request->input('suspended_until'));

            return redirect()
                ->back()
                ->with('success', "Editor #{$id} suspended.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to suspend editor: ' . $e->getMessage());
        }
    }

    public function demoteEditor(int $id): RedirectResponse
    {
        try {
            $this->adminService->demoteEditor($id);

            return redirect()
                ->back()
                ->with('success', "Editor #{$id} demoted to user.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to demote editor: ' . $e->getMessage());
        }
    }

    public function deleteEditor(int $id): RedirectResponse
    {
        try {
            $this->adminService->deleteEditor($id);

            return redirect()
                ->back()
                ->with('success', "Editor #{$id} deleted.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete editor: ' . $e->getMessage());
        }
    }

    public function clearEditorRememberToken(int $id): RedirectResponse
    {
        try {
            $this->adminService->clearEditorRememberToken($id);

            return redirect()
                ->back()
                ->with('success', "Remember me token cleared for editor #{$id}.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to clear remember token: ' . $e->getMessage());
        }
    }

    public function startSeason(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'ends_at' => ['required', 'date', 'after:now'],
        ]);

        try {
            $season = $this->adminService->startNewSeason(
                $request->input('name'),
                $request->input('ends_at'),
            );

            return redirect()
                ->back()
                ->with('success', "Season '{$season['name']}' started. Ends {$season['ends_at']}.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to start season: ' . $e->getMessage());
        }
    }

    public function endSeason(): RedirectResponse
    {
        try {
            $newSeason = $this->adminService->endCurrentSeason();

            return redirect()
                ->back()
                ->with('success', "Current season ended. New season '{$newSeason['name']}' started.");
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to end season: ' . $e->getMessage());
        }
    }
}
