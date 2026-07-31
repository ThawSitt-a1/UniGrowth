<?php

declare(strict_types=1);

namespace App\Admin\Services;

use App\Admin\DTOs\ContentActionDTO;
use App\Admin\DTOs\MetricsFilterDTO;
use App\Admin\DTOs\PlatformMetricsDTO;
use App\Admin\DTOs\RoleAssignmentDTO;
use App\Admin\DTOs\SystemSettingsDTO;
use App\Admin\DTOs\UserStatusDTO;
use App\Admin\UseCases\AssignUserRoleUseCase;
use App\Admin\UseCases\GetPlatformMetricsUseCase;
use App\Admin\UseCases\ManageContentUseCase;
use App\Admin\UseCases\ManageSystemSettingsUseCase;
use App\Admin\UseCases\ManageUserAccountUseCase;
use App\Auth\Models\User;
use App\Overview\Services\SeasonService;
use App\Profile\Models\BugReport;

final class AdminService
{
    public function __construct(
        private readonly GetPlatformMetricsUseCase $getPlatformMetricsUseCase,
        private readonly ManageUserAccountUseCase $manageUserAccountUseCase,
        private readonly AssignUserRoleUseCase $assignUserRoleUseCase,
        private readonly ManageContentUseCase $manageContentUseCase,
        private readonly ManageSystemSettingsUseCase $manageSystemSettingsUseCase,
        private readonly SeasonService $seasonService,
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard / Metrics
    |--------------------------------------------------------------------------
    */

    /**
     * Get admin dashboard data.
     *
     * @return array<string, mixed>
     */
    public function getDashboardData(string $timeFrame = 'all'): array
    {
        $filter = new MetricsFilterDTO($timeFrame);
        $metrics = $this->getPlatformMetricsUseCase->execute($filter);

        return $metrics->toArray();
    }

/*
    |--------------------------------------------------------------------------
    | User Management
    |--------------------------------------------------------------------------
    */

    /**
     * Get all users for management (only role=user, editors hidden).
     *
     * @param string|null $search Optional search query (by id, username, or email)
     * @return array<int, array<string, mixed>>
     */
    public function getAllUsers(?string $search = null): array
    {
        $query = User::query()
            ->select(['id', 'username', 'email', 'role', 'account_status', 'suspended_until', 'platform_score', 'email_verified_at', 'created_at'])
            ->where('role', 'user')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', (int) $search)
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->get()->toArray();
    }

    /**
     * Get all users AND editors in a unified list for the merged table.
     * Each entry includes a 'role_label' for display.
     *
     * @param string|null $search Optional search query (by id, username, or email)
     * @param string|null $roleFilter Optional role filter ('all', 'user', 'editor')
     * @return array<int, array<string, mixed>>
     */
    public function getAllUsersAndEditors(?string $search = null, ?string $roleFilter = 'all'): array
    {
        $query = User::query()
            ->select(['id', 'username', 'email', 'role', 'account_status', 'suspended_until', 'platform_score', 'email_verified_at', 'created_at'])
            ->orderBy('created_at', 'desc');

        if ($roleFilter && $roleFilter !== 'all') {
            $query->where('role', $roleFilter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', (int) $search)
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->get()->toArray();

        // Enrich with editor skills count if role is editor
        foreach ($users as &$user) {
            if ($user['role'] === 'editor') {
                $editorSkills = \App\Core\Assets\Models\Skill::query()
                    ->where('editor_id', $user['id'])
                    ->count();
                $user['skills_count'] = $editorSkills;
            } else {
                $user['skills_count'] = 0;
            }
        }

        return $users;
    }

    /**
     * Update a user's account status (ban/suspend/restore).
     */
    public function updateAccountStatus(UserStatusDTO $dto): void
    {
        $this->manageUserAccountUseCase->execute($dto);
    }

    /**
     * Assign a new role to a user.
     */
    public function assignUserRole(RoleAssignmentDTO $dto): void
    {
        $this->assignUserRoleUseCase->execute($dto);
    }

    /*
    |--------------------------------------------------------------------------
    | Content Moderation
    |--------------------------------------------------------------------------
    */

    /**
     * Execute a content moderation action.
     */
    public function manageContent(ContentActionDTO $dto): void
    {
        $this->manageContentUseCase->execute($dto);
    }

    /**
     * Get all suspended content.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getSuspendedContent(): array
    {
        return $this->manageContentUseCase->getSuspendedContent();
    }

    /**
     * Get all editor-created content (skills) with editor info.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAllEditorContent(): array
    {
        return $this->manageContentUseCase->getAllEditorContent();
    }

    /**
     * Add an admin comment to a skill.
     */
    public function addSkillComment(int $skillId, string $comment): bool
    {
        return $this->manageContentUseCase->addSkillComment($skillId, $comment);
    }

    /*
    |--------------------------------------------------------------------------
    | System Settings
    |--------------------------------------------------------------------------
    */

    /**
     * Get all system settings.
     *
     * @return array<string, string|null>
     */
    public function getSystemSettings(): array
    {
        return $this->manageSystemSettingsUseCase->getAllSettings();
    }

    /**
     * Update a system setting.
     */
    public function updateSystemSettings(string $key, string $value): void
    {
        $dto = new SystemSettingsDTO($key, $value);
        $this->manageSystemSettingsUseCase->execute($dto);
    }

    /*
    |--------------------------------------------------------------------------
    | Bug Reports
    |--------------------------------------------------------------------------
    */

    /**
     * Get all bug reports.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getBugReports(): array
    {
        return BugReport::query()
            ->with('user:id,username,email')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * Update a bug report's status.
     */
    public function updateBugReportStatus(int $reportId, string $status): void
    {
        $report = BugReport::query()->findOrFail($reportId);
        $report->update(['status' => $status]);
    }

    /*
    |--------------------------------------------------------------------------
    | Editor Management
    |--------------------------------------------------------------------------
    */

    /**
     * Get all editors with their skills count and IDs.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAllEditors(): array
    {
        return User::query()
            ->select(['id', 'username', 'email', 'account_status', 'suspended_until', 'created_at'])
            ->where('role', 'editor')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($editor) {
                $editorSkills = \App\Core\Assets\Models\Skill::query()
                    ->where('editor_id', $editor->id)
                    ->select(['id', 'title'])
                    ->get();

                return [
                    'id' => $editor->id,
                    'username' => $editor->username,
                    'email' => $editor->email,
                    'account_status' => $editor->account_status,
                    'suspended_until' => $editor->suspended_until,
                    'created_at' => $editor->created_at?->toISOString(),
                    'skills_count' => $editorSkills->count(),
                    'skill_ids' => $editorSkills->pluck('id')->implode(', '),
                    'skill_titles' => $editorSkills->pluck('title')->implode(', '),
                ];
            })
            ->toArray();
    }

    /**
     * Suspend an editor account.
     */
    public function suspendEditor(int $editorId, ?string $suspendedUntil = null): void
    {
        $user = User::query()->findOrFail($editorId);
        $updateData = ['account_status' => 'suspended'];
        if ($suspendedUntil) {
            $updateData['suspended_until'] = $suspendedUntil;
        }
        $user->update($updateData);
    }

    /**
     * Demote an editor to regular user.
     */
    public function demoteEditor(int $editorId): void
    {
        $user = User::query()->findOrFail($editorId);
        $user->update(['role' => 'user', 'account_status' => 'allowed', 'suspended_until' => null]);
    }

    /**
     * Delete an editor account.
     */
    public function deleteEditor(int $editorId): void
    {
        $user = User::query()->findOrFail($editorId);
        $user->delete();
    }

    /**
     * Clear the remember me token for an editor.
     */
    public function clearEditorRememberToken(int $editorId): void
    {
        $user = User::query()->findOrFail($editorId);
        $user->update(['remember_token' => null, 'remember_token_expires_at' => null]);
    }

    /*
    |--------------------------------------------------------------------------
    | Season Management
    |--------------------------------------------------------------------------
    */

    /**
     * Start a new season.
     */
    public function startNewSeason(string $name, string $endsAt): array
    {
        $season = $this->seasonService->initializeNewSeason($name, $endsAt);

        return [
            'season_id' => $season->id,
            'name' => $season->name,
            'started_at' => $season->started_at?->toISOString(),
            'ends_at' => $season->ends_at?->toISOString(),
            'is_active' => $season->is_active,
        ];
    }

    /**
     * End the current season.
     */
    public function endCurrentSeason(): array
    {
        $newSeason = $this->seasonService->endCurrentSeason();

        return [
            'season_id' => $newSeason->id,
            'name' => $newSeason->name,
            'started_at' => $newSeason->started_at?->toISOString(),
            'ends_at' => $newSeason->ends_at?->toISOString(),
            'is_active' => $newSeason->is_active,
        ];
    }

    /**
     * Get current season status.
     */
    public function getSeasonStatus(): array
    {
        $season = $this->seasonService->getCurrentSeason();

        return [
            'has_active_season' => $season !== null,
            'season_id' => $season?->id,
            'name' => $season?->name,
            'started_at' => $season?->started_at?->toISOString(),
            'ends_at' => $season?->ends_at?->toISOString(),
        ];
    }
}

