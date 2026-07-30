<?php

namespace App\Profile\Models;

use App\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BugReport extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'steps_to_reproduce',
        'severity',
        'screenshot_path',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'severity' => 'string',
            'status' => 'string',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

