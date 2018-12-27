<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Category extends Authenticatable
{

    use SoftDeletes;
// The authentication guard for admin
    protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'title','description','image',
    ];


    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'id', 'parent_id'); // I believe you can use also hasOne().
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }
    public static function tree() {

        return static::where('parent_id', '=', 0)->get();

    }



}