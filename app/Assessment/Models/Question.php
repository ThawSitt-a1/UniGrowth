<?php

declare(strict_types=1);

namespace App\Assessment\Models;

use App\Core\Assets\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Question extends Model
{
    protected $table = 'questions';

    protected $fillable = [
        'skill_id',
        'question_text',
        'difficulty',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class, 'question_id');
    }

    public function correctOptions(): HasMany
    {
        return $this->hasMany(Option::class, 'question_id')->where('is_correct', true);
    }
}

