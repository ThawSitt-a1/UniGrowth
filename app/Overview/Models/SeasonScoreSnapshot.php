<?php

declare(strict_types=1);

namespace App\Overview\Models;

use App\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class SeasonScoreSnapshot extends Model
{
    protected $table = 'season_score_snapshots';

    protected $fillable = [
        'season_id',
        'user_id',
        'username',
        'final_score',
        'final_rank',
        'skill_count',
        'snapshot_date',
    ];

    protected $casts = [
        'final_score' => 'float',
        'snapshot_date' => 'datetime',
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

