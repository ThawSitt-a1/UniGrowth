<?php

declare(strict_types=1);

namespace App\Core\Assets\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Habit extends Model
{
    use HasFactory;

    protected $table = 'habits';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'icon',
        'color',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Auth\Models\User::class);
    }

    public function completions(): HasMany
    {
        return $this->hasMany(HabitCompletion::class, 'habit_id');
    }
}

