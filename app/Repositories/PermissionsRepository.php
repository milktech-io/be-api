<?php

namespace App\Repositories;

use App\Models\{Permissions};
use Spatie\Permission\Models\Permission;

class PermissionsRepository
{
    public function search($q)
    {
        if (isset($q)) {
            $query = Permission::where(function ($q) {
                $q->orWhere('id', 'LIKE', '%'.$q.'%');
                $q->orWhere('name', 'LIKE', '%'.$q.'%');
            })->get();
        } else {
            $query = Permission::all();
        }

        return ok('', $query);
    }
}
