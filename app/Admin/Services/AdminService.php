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
use App\Profile\Models\BugReport;

final class AdminService
{
    public function __construct(
        private readonly GetPlatformMetricsUseCase $getPlatformMetricsUseCase,
        private readonly ManageUserAccountUseCase $manageUserAccountUseCase,
        private readonly AssignUserRoleUseCase $assignUserRoleUseCase,
        private readonly ManageContentUseCase $manageContentUseCase,
        private readonly ManageSystemSettingsUseCase $manageSystemSettingsUseCase,
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
     * Get all users for management.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAllUsers(): array
    {
        return User::query()
            ->select(['id', 'username', 'email', 'role', 'account_status', 'suspended_until', 'platform_score', 'email_verified_at', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
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
}

