<?php

declare(strict_types=1);

namespace App\Assessment\Models;

use App\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class StudentAnsweredQuestion extends Model
{
    protected $table = 'student_answered_questions';

    protected $fillable = [
        'user_id',
        'question_id',
        'attempt_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class);
    }
}

