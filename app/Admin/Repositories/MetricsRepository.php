<?php

declare(strict_types=1);

namespace App\Admin\Repositories;

use App\Admin\DTOs\PlatformMetricsDTO;
use App\Auth\Models\User;
use App\Core\Assets\Models\Skill;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final class MetricsRepository implements MetricsRepositoryInterface
{
    public function fetchAdminMetrics(string $timeFrame = 'all'): PlatformMetricsDTO
    {
        // Determine the cutoff date based on time frame
        $cutoff = match ($timeFrame) {
            '7d' => Carbon::now()->subDays(7),
            '30d' => Carbon::now()->subDays(30),
            default => null, // 'all' means no filter
        };

        // Total registered users
        $totalUsersQuery = User::query();
        if ($cutoff) {
            $totalUsersQuery->where('created_at', '>=', $cutoff);
        }
        $totalRegisteredUsers = $totalUsersQuery->count();

        // Active users: users who logged in within the time frame
        // Use the sessions table or updated_at as proxy for activity
        $activeUsersQuery = User::query()
            ->where(function ($q) use ($cutoff) {
                if ($cutoff) {
                    $q->where('updated_at', '>=', $cutoff);
                } else {
                    $q->whereNotNull('updated_at');
                }
            })
            ->where('account_status', 'allowed');
        if ($cutoff) {
            $activeUsersQuery->where('updated_at', '>=', $cutoff);
        }
        $activeUsers = $activeUsersQuery->count();

        // Total banned/suspended users
        $bannedQuery = User::query()
            ->whereIn('account_status', ['banned', 'suspended']);
        if ($cutoff) {
            $bannedQuery->where('updated_at', '>=', $cutoff);
        }
        $totalBannedUsers = $bannedQuery->count();

        // Total active skills
        $skillsQuery = Skill::query()->where('is_active', true);
        if ($cutoff) {
            $skillsQuery->where('created_at', '>=', $cutoff);
        }
        $totalSkills = $skillsQuery->count();

        return new PlatformMetricsDTO(
            totalRegisteredUsers: $totalRegisteredUsers,
            activeUsers: $activeUsers,
            totalBannedUsers: $totalBannedUsers,
            totalSkills: $totalSkills,
            recordedAt: Carbon::now()->toISOString(),
        );
    }
}

