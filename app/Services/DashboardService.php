<?php

namespace App\Services;

use App\Repositories\DashboardRepository;

class DashboardService
{
    protected $DashboardRepository;

    public function __construct(DashboardRepository $DashboardRepository)
    {
        $this->DashboardRepository = $DashboardRepository;
    }

    public function myNetwork()
    {
        return $this->DashboardRepository->myNetwork();
    }
}
