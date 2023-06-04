<?php

namespace App\Services;

use App\Repositories\UserDeleteRepository;

class UserDeleteService
{
    protected $UserDeleteRepository;

    public function __construct(UserDeleteRepository $UserDeleteRepository)
    {
        $this->UserDeleteRepository = $UserDeleteRepository;
    }

    public function request()
    {
        return $this->UserDeleteRepository->request();
    }

    public function deleteAccount()
    {
        return $this->UserDeleteRepository->deleteAccount();
    }

    public function deleteAccountUser($user)
    {
        return $this->UserDeleteRepository->deleteAccount($user);
    }
}
