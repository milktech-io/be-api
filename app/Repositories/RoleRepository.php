<?php

namespace App\Repositories;

use App\Traits\PaginateRepository;
use Spatie\Permission\Models\Permission as Permissions;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    use PaginateRepository;

    public function storeRole($data)
    {
        $Role = Role::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return ok('usuario creado correctamente', $Role);
    }

    public function search($s)
    {
        if (isset($s)) {
            $query = Role::with('permissions')->where(function ($q, $s) {
                $q->orWhere('id', 'LIKE', '%'.$s.'%');
                $q->orWhere('name', 'LIKE', '%'.$s.'%');
            })->get();
        } else {
            $query = Role::with('permissions')->get();
        }

        return ok('', $query);
    }

    public function store($data)
    {
        $role = Role::create([
            'name' => $data['name'],
            'edit' => 1,
        ]);

        return ok('Rol creado correctamente', $role);
    }

    public function update($role, $data)
    {
        $role->name = $data['name'];
        $role->save();
        $role->permissions()->detach();

        foreach ($data['permissions'] ?? [] as $permission) {
            $permission = Permissions::findByName($permission);
            $role->givePermissionTo($permission);
        }

        $role->permissions;

        return ok('Role actualizado correctamente', $role);
    }

    public function find($id)
    {
        return ok('', Role::with('permissions')->findOrFail($id));
    }

    public function destroy($role)
    {
        $role->permissions()->detach();
        $role->delete();

        return ok('Rol eliminado correctamente', Role::with('permissions')->get());
    }
}
