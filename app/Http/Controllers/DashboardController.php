<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardController\DownloadRequest;
use App\Models\User;
use App\Services\DashboardService;
use App\Services\MLMService;

class DashboardController extends Controller
{
    protected $DashboardService;

    public function __construct(DashboardService $DashboardService, MLMService $MLMService)
    {
        $this->DashboardService = $DashboardService;
        $this->MLMService = $MLMService;
    }

    public function myNetwork()
    {
        return $this->DashboardService->myNetwork();
    }

    public function directReferredsCounter()
    {
        return $this->MLMService->directReferredsCounter();
    }

    public function volumen()
    {
        return $this->MLMService->volumen();
    }

    public function netWork(User $user = null)
    {
        return $this->MLMService->network($user);
    }

    public function netWorkDownload(DownloadRequest $request)
    {
        return $this->MLMService->networkDownload($request->validated());
    }
}
