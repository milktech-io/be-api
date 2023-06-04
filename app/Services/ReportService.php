<?php

namespace App\Services;

use App\Repositories\ReportRepository;

class ReportService
{
    protected $ReportRepository;

    public function __construct(ReportRepository $ReportRepository)
    {
        $this->ReportRepository = $ReportRepository;
    }

    public function invite($data)
    {
        return $this->ReportRepository->invite($data);
    }

    public function register($data)
    {
        return $this->ReportRepository->register($data);
    }

    public function rangues($data)
    {
        return $this->ReportRepository->rangues($data);
    }

    //user

    public function inviteUser($data)
    {
        return $this->ReportRepository->inviteUser($data);
    }

    public function registerUser($data)
    {
        return $this->ReportRepository->registerUser($data);
    }

    public function userWallets()
    {
        return $this->ReportRepository->userWallets();
    }
}
