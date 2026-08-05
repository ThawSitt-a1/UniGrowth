<?php

declare(strict_types=1);

namespace App\Assessment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Option extends Model
{
    protected $table = 'options';

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
        'editor_id',
        'locked_by_admin',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}

