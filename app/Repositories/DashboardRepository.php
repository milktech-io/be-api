<?php

namespace App\Repositories;

use App\Models\{User};
use App\Services\MLMService;
use Auth;

class DashboardRepository
{
    public function __construct(MLMService $MLMService)
    {
        $this->MLMService = $MLMService;
    }

    public function myNetwork()
    {
        $user = Auth::user();
        $referreds = $this->MLMService->getReferreds($user, 1);

        return ok('', $referreds);
    }
}
