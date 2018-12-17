<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleAdmin extends Model
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];
  protected $table = "role_admin";

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'id', 'role_id', 'admin_id',
  ];

}
