<?php

namespace App;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kodeine\Acl\Models\Eloquent\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Kodeine\Acl\Traits\HasRole;
use Laravel\Airlock\HasApiTokens;

class User extends Authenticatable implements JWTSubject, CanResetPassword, MustVerifyEmail
{
    use Notifiable, HasRole, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:d.m.Y H:i:s',
        'updated_at' => 'datetime:d.m.Y H:i:s'
    ];

    public function role()
    {
        return $this->belongsToMany(Role::class)->latest();
    }

    /** получение JWT-идентификатора */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /** ??? */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Override the mail body for reset password notification mail.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }
}