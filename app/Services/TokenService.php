<?php

namespace App\Services;

use App\Repositories\TokenRepository;

class TokenService
{
    protected $TokenRepository;

    public function __construct(TokenRepository $TokenRepository)
    {
        $this->TokenRepository = $TokenRepository;
    }

    public function getActive()
    {
        return $this->TokenRepository->getActive();
    }

    public function revoke($token)
    {
        return $this->TokenRepository->revoke($token);
    }
}
