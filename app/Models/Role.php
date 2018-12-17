<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'description',
    ];

    public function admins()
    {
        return $this
            ->belongsToMany('App\Models\admin')
            ->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    public function processTypes()
    {
      return $this
      ->belongsToMany('App\Models\ProcessType')
      ->withTimestamps();
    }

    public function roleAdmin()
    {
        return $this->hasOne('App\Models\RoleAdmin', 'role_id', 'id');
    }

    public function roleHierarchies()
    {
      return $this
      ->belongsToMany('App\Models\RoleHierarchy')
      ->withTimestamps();
    }
}
