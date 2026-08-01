<?php

declare(strict_types=1);

namespace App\Overview\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

final class Season extends Model
{
    protected $table = 'seasons';

    protected $fillable = [
        'name',
        'started_at',
        'ends_at',
        'is_active',
        'highest_score',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'highest_score' => 'float',
    ];

    public function scores(): HasMany
    {
        return $this->hasMany(SeasonScore::class, 'season_id');
    }

    public function snapshots(): HasMany
    {
        return $this->hasMany(SeasonScoreSnapshot::class, 'season_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeHistory(Builder $query): Builder
    {
        return $query->where('is_active', false)->orderBy('ends_at', 'desc');
    }
}

