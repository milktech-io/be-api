<?php

namespace App\Services;

use App\Repositories\PermissionsRepository;

class PermissionsService
{
    protected $PermissionsRepository;

    public function __construct(PermissionsRepository $PermissionsRepository)
    {
        $this->PermissionsRepository = $PermissionsRepository;
    }

    public function search($q)
    {
        return $this->PermissionsRepository->search($q);
    }

    public function acive($user)
    {
        $user = $this->UserService->find($user);

        return $this->PermissionsRepository->activeUSer($user);
    }
}
