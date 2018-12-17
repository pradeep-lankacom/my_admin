<?php

namespace App\Models;

use App\Traits\HasPermission;
use App\Traits\HasRole;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    use Notifiable;
    use HasRole;
    use HasPermission;
    use SoftDeletes;
// The authentication guard for admin
    protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function roles()
    {
        return $this
            ->belongsToMany('App\Models\Role')
            ->withTimestamps();
    }

    public function permissions()
    {
        return $this
            ->belongsToMany('App\Models\Permission')
            //->withPivot('role_id')
            ->withTimestamps();
    }


    public function roleAdmin()
    {
        return $this->hasOne('App\Models\RoleAdmin', 'admin_id', 'id');
    }
}