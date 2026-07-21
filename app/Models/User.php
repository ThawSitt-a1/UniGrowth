<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    // Note: The 'CanResetPassword' trait is already included inside Authenticatable by default!

    public const ROLE_ADMIN = 'admins';
    public const ROLE_SUPER_ADMIN = 'superadmin';
    public const ROLE_USER = 'user';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'account_status',
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
        ];
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
}
