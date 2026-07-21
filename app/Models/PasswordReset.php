<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'password_resets';

    /**
     * Indicates if the model should be timestamped.
     * We manage 'created_at' manually.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the password reset record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include non-expired tokens.
     */
    public function scopeNotExpired($query)
    {
        return $query->whereNull('expires_at')
            ->orWhere('expires_at', '>', now());
    }

    /**
     * Check if the token has expired.
     */
    public function isExpired(): bool
    {
        if ($this->expires_at === null) {
            return false;
        }

        return now()->greaterThan($this->expires_at);
    }
}
