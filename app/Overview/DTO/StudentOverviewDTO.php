<?php

declare(strict_types=1);

namespace App\Overview\DTO;

final class StudentOverviewDTO
{
    /**
     * @param array<int, array{id: int, text: string, created_at: string}> $activeGoals
     * @param array<int, array{id: int, text: string, completed_at: string}> $completedGoals
     * @param array<int, array{id: int, skill_id: int, skill_title: string, enrolled_at: string}> $enrolledSkills
     */
    public function __construct(
        public readonly int $studentId,
        public readonly string $username,
        public readonly SeasonInfoDTO $season,
        public readonly array $activeGoals,
        public readonly array $completedGoals,
        public readonly array $enrolledSkills,
        public readonly array $quizStatistics,
        public readonly int $seasonRank,
        public readonly float $totalSeasonScore,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'student_id' => $this->studentId,
            'username' => $this->username,
            'season' => $this->season->toArray(),
            'active_goals' => $this->activeGoals,
            'completed_goals' => $this->completedGoals,
            'enrolled_skills' => $this->enrolledSkills,
            'quiz_statistics' => $this->quizStatistics,
            'season_rank' => $this->seasonRank,
            'total_season_score' => $this->totalSeasonScore,
        ];
    }
}

