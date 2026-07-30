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
     * Admin dashboard with platform metrics.
     *
     * GET /admin
     */
    public function dashboard(Request $request): View
    {
        $timeFrame = $request->query('time_frame', 'all');
        $metrics = $this->adminService->getDashboardData($timeFrame);

        return view('admin.dashboard', [
            'metrics' => $metrics,
            'timeFrame' => $timeFrame,
        ]);
    }

    /**
     * User management page.
     *
     * GET /admin/users
     */
    public function users(): View
    {
        $users = $this->adminService->getAllUsers();

        return view('admin.users', [
            'users' => $users,
        ]);
    }

    /**
     * Update a user's account status (ban/suspend/restore).
     *
     * POST /admin/users/{id}/status
     */
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
                ->route('admin.users')
                ->with('success', "User #{$id} status updated to '{$request->input('status')}'.");
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users')
                ->with('error', 'Failed to update user status: ' . $e->getMessage());
        }
    }

    /**
     * Assign a new role to a user.
     *
     * POST /admin/users/{id}/role
     */
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
                ->route('admin.users')
                ->with('success', "User #{$id} role updated to '{$request->input('role')}'.");
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.users')
                ->with('error', 'Failed to assign role: ' . $e->getMessage());
        }
    }

    /**
     * Content moderation page.
     *
     * GET /admin/content
     */
    public function content(): View
    {
        $suspendedContent = $this->adminService->getSuspendedContent();

        return view('admin.content', [
            'suspendedContent' => $suspendedContent,
        ]);
    }

    /**
     * Execute a content moderation action.
     *
     * POST /admin/content/action
     */
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
                ->route('admin.content')
                ->with('success', "Content action '{$dto->action}' executed on {$dto->targetType} #{$dto->targetId}.");
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.content')
                ->with('error', 'Failed to execute content action: ' . $e->getMessage());
        }
    }

    /**
     * System settings page.
     *
     * GET /admin/settings
     */
    public function settings(): View
    {
        $settings = $this->adminService->getSystemSettings();

        return view('admin.settings', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update a system setting.
     *
     * POST /admin/settings/update
     */
    public function updateSettings(UpdateSystemSettingsRequest $request): RedirectResponse
    {
        try {
            $this->adminService->updateSystemSettings(
                $request->input('setting_key'),
                $request->input('setting_value'),
            );

            return redirect()
                ->route('admin.settings')
                ->with('success', "Setting '{$request->input('setting_key')}' updated.");
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.settings')
                ->with('error', 'Failed to update setting: ' . $e->getMessage());
        }
    }

    /**
     * Bug reports page.
     *
     * GET /admin/bug-reports
     */
    public function bugReports(): View
    {
        $reports = $this->adminService->getBugReports();

        return view('admin.bug-reports', [
            'reports' => $reports,
        ]);
    }
}

