<?php

namespace App\Profile\Models;

use App\Auth\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSocialAccount extends Model
{
    protected $table = 'user_social_accounts';

    protected $fillable = [
        'user_id',
        'platform',
        'url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

