<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use Spatie\Permission\Models\Role;

class RoleService
{
    protected $RoleRepository;

    public function __construct(RoleRepository $RoleRepository)
    {
        $this->RoleRepository = $RoleRepository;
    }

    public function query($query)
    {
        return $this->RoleRepository->query(Role::class, $query);
    }

    public function store($data)
    {
        return $this->RoleRepository->store($data);
    }

    public function update($role, $data)
    {
        return $this->RoleRepository->update($role, $data);
    }

    public function find($id)
    {
        return $this->RoleRepository->find($id);
    }

    public function destroy($role)
    {
        return $this->RoleRepository->destroy($role);
    }
}
