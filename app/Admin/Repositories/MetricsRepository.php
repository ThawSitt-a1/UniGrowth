<?php

declare(strict_types=1);

namespace App\Admin\Repositories;

use App\Admin\DTOs\PlatformMetricsDTO;
use App\Auth\Models\User;
use App\Core\Assets\Models\Enrollment;
use App\Core\Assets\Models\Skill;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final class MetricsRepository implements MetricsRepositoryInterface
{
    public function fetchAdminMetrics(string $timeFrame = 'all'): PlatformMetricsDTO
    {
        $now = Carbon::now();

        // Determine the cutoff date based on time frame
        $cutoff = match ($timeFrame) {
            '7d' => $now->copy()->subDays(7),
            '30d' => $now->copy()->subDays(30),
            default => null,
        };

        // Total registered users
        $totalUsersQuery = User::query();
        if ($cutoff) {
            $totalUsersQuery->where('created_at', '>=', $cutoff);
        }
        $totalRegisteredUsers = $totalUsersQuery->count();

        // Active users
        $activeUsersQuery = User::query()
            ->where('account_status', 'allowed');
        if ($cutoff) {
            $activeUsersQuery->where('updated_at', '>=', $cutoff);
        }
        $activeUsers = $activeUsersQuery->count();

        // Total banned users
        $bannedQuery = User::query()
            ->where('account_status', 'banned');
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

        // ===== New Enhanced Metrics =====

        // Daily new users (last 24 hours)
        $dailyNewUsers = User::query()
            ->where('created_at', '>=', $now->copy()->subDay())
            ->count();

        // Weekly new users (last 7 days)
        $weeklyNewUsers = User::query()
            ->where('created_at', '>=', $now->copy()->subDays(7))
            ->count();

        // Monthly new users (last 30 days)
        $monthlyNewUsers = User::query()
            ->where('created_at', '>=', $now->copy()->subDays(30))
            ->count();

        // DAU (active in last 24h)
        $dau = User::query()
            ->where('account_status', 'allowed')
            ->where('updated_at', '>=', $now->copy()->subDay())
            ->count();

        // MAU (active in last 30 days)
        $mau = User::query()
            ->where('account_status', 'allowed')
            ->where('updated_at', '>=', $now->copy()->subDays(30))
            ->count();

        // Stickiness ratio (DAU/MAU)
        $stickinessRatio = $mau > 0 ? round($dau / $mau * 100, 1) : 0.0;

        // Popular skill (most enrolled)
        $popularSkillData = Enrollment::query()
            ->select('skill_id', DB::raw('COUNT(*) as total'))
            ->groupBy('skill_id')
            ->orderByDesc('total')
            ->limit(1)
            ->first();

        $popularSkill = 'N/A';
        $popularSkillEnrollments = 0;
        if ($popularSkillData) {
            $skill = Skill::find($popularSkillData->skill_id);
            $popularSkill = $skill?->title ?? "Skill #{$popularSkillData->skill_id}";
            $popularSkillEnrollments = (int) $popularSkillData->total;
        }

        return new PlatformMetricsDTO(
            totalRegisteredUsers: $totalRegisteredUsers,
            activeUsers: $activeUsers,
            totalBannedUsers: $totalBannedUsers,
            totalSkills: $totalSkills,
            recordedAt: $now->toISOString(),
            dailyNewUsers: $dailyNewUsers,
            weeklyNewUsers: $weeklyNewUsers,
            monthlyNewUsers: $monthlyNewUsers,
            dau: $dau,
            mau: $mau,
            stickinessRatio: $stickinessRatio,
            popularSkill: $popularSkill,
            popularSkillEnrollments: $popularSkillEnrollments,
        );
    }
}

