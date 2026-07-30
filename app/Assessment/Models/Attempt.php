<?php

declare(strict_types=1);

namespace App\Assessment\Models;

use App\Auth\Models\User;
use App\Core\Assets\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Attempt extends Model
{
    protected $table = 'attempts';

    protected $fillable = [
        'user_id',
        'skill_id',
        'score',
        'max_score',
        'percentage',
        'passed',
        'attempted_at',
    ];

    protected $casts = [
        'passed' => 'boolean',
        'attempted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function answeredQuestions(): HasMany
    {
        return $this->hasMany(StudentAnsweredQuestion::class, 'attempt_id');
    }
}

