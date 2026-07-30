<?php

declare(strict_types=1);

namespace App\Assessment\Models;

use App\Auth\Models\User;
use App\Core\Assets\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class StudentSkill extends Model
{
    protected $table = 'student_skills';

    protected $fillable = [
        'user_id',
        'skill_id',
        'proficiency_score',
        'attempts_count',
        'last_attempted_at',
    ];

    protected $casts = [
        'last_attempted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}

