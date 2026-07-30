<?php

declare(strict_types=1);

namespace App\Services\Analytics\Calculators;

use App\Core\Assets\Models\Goal;
use App\Auth\Models\User;
use App\Services\Analytics\MetricCalculatorInterface;
use Illuminate\Database\Query\Builder;

final class ActivationRateCalculator implements MetricCalculatorInterface
{
    public function calculate(?int $userId = null): float
    {
        // Activation definition (MVP): users who completed at least one goal within 48 hours of registration.
        $usersQuery = User::query();
        if ($userId !== null) {
            $usersQuery->where('id', $userId);
        }

        $denominator = (int) (clone $usersQuery)->count();
        if ($denominator === 0) {
            return 0.0;
        }

        $numerator = (int) $usersQuery
            ->whereExists(function (Builder $q) {
                $q->selectRaw('1')
                    ->from('goals')
                    ->whereColumn('goals.user_id', 'users.id')
                    ->where('goals.status', 'completed')
                    ->whereRaw('goals.completed_at <= DATE_ADD(users.created_at, INTERVAL 48 HOUR)');
            })
            ->count();


        return ($numerator / $denominator) * 100.0;
    }
}

/**
 * Small helper to keep this file self-contained.
 * This project uses MySQL.
 */
function DB_DATE_ADD_48HOURS_SQL(): string
{
    // users.created_at + INTERVAL 48 HOUR
    return 'DATE_ADD(users.created_at, INTERVAL 48 HOUR)';
}

