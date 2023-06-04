<?php

namespace App\Services;

use App\Repositories\RequestRepository;

class RequestService
{
    protected $RequestRepository;

    public function __construct(RequestRepository $RequestRepository)
    {
        $this->RequestRepository = $RequestRepository;
    }

    public function store($data, $body = false)
    {
        return $this->RequestRepository->store($data, $body);
    }

    public function call($password, $user, $service, $action, $callbackParams = [])
    {
        return $this->RequestRepository->call($password, $user, $service, $action, $callbackParams);
    }
}
