<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Larapacks\Authorization\Traits\UserRolesTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, UserRolesTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'memberable_id', 'memberable_type'
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
    ];

    protected $appends = ['is_admin', 'avatar'];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function getIsAdminAttribute()
    {
        $admin = false;

        if ($this->hasAnyRoles(['Developer', 'SuperAdmin', 'Admin', 'UserManager'])) {
            $admin = true;
        }
        return $admin;
    }

    public function isAdmin()
    {
        return $this->getIsAdminAttribute();
    }

    public function getAvatarAttribute($value)
    {
        $email = $this->attributes['email'];
        $default = 'identicon';
        $size = 480;

        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size;

        return $grav_url;
    }
}
