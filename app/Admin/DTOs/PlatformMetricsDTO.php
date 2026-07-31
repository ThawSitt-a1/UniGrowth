<?php

declare(strict_types=1);

namespace App\Admin\DTOs;

final class PlatformMetricsDTO
{
    public function __construct(
        public readonly int $totalRegisteredUsers,
        public readonly int $activeUsers,
        public readonly int $totalBannedUsers,
        public readonly int $totalSkills,
        public readonly string $recordedAt,
        // New dashboard metrics
        public readonly int $dailyNewUsers = 0,
        public readonly int $weeklyNewUsers = 0,
        public readonly int $monthlyNewUsers = 0,
        public readonly int $dau = 0,
        public readonly int $mau = 0,
        public readonly float $stickinessRatio = 0.0,
        public readonly string $popularSkill = 'N/A',
        public readonly int $popularSkillEnrollments = 0,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'total_registered_users' => $this->totalRegisteredUsers,
            'active_users' => $this->activeUsers,
            'total_banned_users' => $this->totalBannedUsers,
            'total_skills' => $this->totalSkills,
            'recorded_at' => $this->recordedAt,
            'daily_new_users' => $this->dailyNewUsers,
            'weekly_new_users' => $this->weeklyNewUsers,
            'monthly_new_users' => $this->monthlyNewUsers,
            'dau' => $this->dau,
            'mau' => $this->mau,
            'stickiness_ratio' => $this->stickinessRatio,
            'popular_skill' => $this->popularSkill,
            'popular_skill_enrollments' => $this->popularSkillEnrollments,
        ];
    }
}

