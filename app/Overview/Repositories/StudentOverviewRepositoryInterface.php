<?php

declare(strict_types=1);

namespace App\Overview\Repositories;

use Illuminate\Support\Collection;

interface StudentOverviewRepositoryInterface
{
    /**
     * @return Collection<int, \App\Core\Assets\Models\Goal>
     */
    public function fetchActiveGoals(int $userId): Collection;

    /**
     * @return Collection<int, \App\Core\Assets\Models\Goal>
     */
    public function fetchCompletedGoals(int $userId): Collection;

    public function countActiveGoals(int $userId): int;

    public function countCompletedGoals(int $userId): int;

    /**
     * @return Collection<int, \App\Core\Assets\Models\Enrollment>
     */
    public function fetchEnrolledSkills(int $userId): Collection;

    public function countEnrolledSkills(int $userId): int;

public function countTotalQuestionsAnswered(int $userId, ?int $seasonId = null): int;

    public function countTotalAttempts(int $userId, ?int $seasonId = null): int;

    public function sumTotalScore(int $userId, ?int $seasonId = null): float;

    public function averageScorePerAttempt(int $userId, ?int $seasonId = null): float;
}
