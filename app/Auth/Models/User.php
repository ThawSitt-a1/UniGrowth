<?php

namespace App\Auth\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Database\Factories\UserFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use MustVerifyEmailTrait;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }
    // Note: The 'CanResetPassword' trait is already included inside Authenticatable by default!

    public const ROLE_ADMIN = 'admin';
    public const ROLE_EDITOR = 'editor';
    public const ROLE_USER = 'user';

protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'account_status',
        'suspended_until',
        'platform_score',
        'academic_year',
        'major',
        'university_name',
        'description',
        'preferences',
        'agreed_to_terms',
        'email_verified_at',
        'remember_token',
        'remember_token_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'preferences' => 'array',
            'remember_token_expires_at' => 'datetime',
            'agreed_to_terms' => 'boolean',
            'suspended_until' => 'datetime',
        ];
    }

    /**
     * Check if the remember token has expired.
     */
    public function isRememberTokenExpired(): bool
    {
        if ($this->remember_token_expires_at === null) {
            return true; // No expiry set means token is invalid
        }

        return now()->greaterThan($this->remember_token_expires_at);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
    // Simply call the notify method; Laravel's default ResetPassword
    // notification will use your 'password.reset' route automatically.
      $this->notify(new ResetPasswordNotification($token));
    }

    /*
    |--------------------------------------------------------------------------
    | Core Services Relationships
    |--------------------------------------------------------------------------
    */

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function enrolledSkills()
    {
        return $this->hasMany(\App\Core\Assets\Models\Enrollment::class, 'user_id');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function goals()
    {
        return $this->hasMany(\App\Core\Assets\Models\Goal::class, 'user_id');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function habits()
    {
        return $this->hasMany(\App\Core\Assets\Models\Habit::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Profile & Account Manager Relationships
    |--------------------------------------------------------------------------
    */

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function socialAccounts()
    {
        return $this->hasMany(\App\Profile\Models\UserSocialAccount::class, 'user_id');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany */
    public function bugReports()
    {
        return $this->hasMany(\App\Profile\Models\BugReport::class, 'user_id');
    }
}
