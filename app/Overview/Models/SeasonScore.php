<?php

declare(strict_types=1);

namespace App\Overview\Models;

use App\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class SeasonScore extends Model
{
    protected $table = 'season_scores';

    protected $fillable = [
        'user_id',
        'season_id',
        'total_score',
        'skill_count',
        'total_questions_answered',
        'last_active_at',
    ];

    protected $casts = [
        'total_score' => 'float',
        'last_active_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }
}

