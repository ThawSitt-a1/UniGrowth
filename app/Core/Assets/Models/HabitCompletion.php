<?php

declare(strict_types=1);

namespace App\Core\Assets\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class HabitCompletion extends Model
{
    use HasFactory;

    protected $table = 'habit_completions';

    // Completions are immutable once created — only created_at is managed.
    public const UPDATED_AT = null;

    protected $fillable = [
        'habit_id',
        'user_id',
        'completed_date',
    ];

    protected $casts = [
        'completed_date' => 'date',
    ];

    public function habit(): BelongsTo
    {
        return $this->belongsTo(Habit::class, 'habit_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Auth\Models\User::class);
    }
}

