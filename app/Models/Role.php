<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public $fillable = ['name', 'guard_name', 'edit'];

    protected $hidden = ['pivot', 'created_at', 'updated_at'];
}
