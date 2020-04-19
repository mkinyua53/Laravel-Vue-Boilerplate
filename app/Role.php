<?php

namespace App;

// use App\Events\RoleSaved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Larapacks\Authorization\Traits\RolePermissionsTrait;

class Role extends Model
{
    use RolePermissionsTrait, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'label'
    ];

    protected $appends = ['string'];

    // protected $events = [
    //     'saved' => RoleSaved::class,
    //     'updated' => RoleSaved::class,
    // ];

    // protected $touches = ['user', 'permission'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
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
