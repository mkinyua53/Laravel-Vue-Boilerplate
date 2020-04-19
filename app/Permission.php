<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Larapacks\Authorization\Traits\PermissionRolesTrait;

class Permission extends Model
{
    use PermissionRolesTrait, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'label',
        'closure'
    ];

    protected $hidden = ['closure'];


    protected $appends = ['string'];

    // protected $touches = ['role', 'user'];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    // Get a searchable string
    static function stringed($model)
    {
        return $model->name . ' ' . $model->label;
    }

    public function getStringAttribute()
    {
        return $this->attributes['name'] . ' ' . $this->attributes['label'];
    }
}
