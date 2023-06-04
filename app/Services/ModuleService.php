<?php

namespace App\Services;

use App\Repositories\ModuleRepository;
use Auth;

class ModuleService
{
    protected $ModuleRepository;

    public function __construct(ModuleRepository $ModuleRepository)
    {
        $this->ModuleRepository = $ModuleRepository;
    }

    public function getAllModules()
    {
        return $this->ModuleRepository->getAllModules();
    }

    public function getMenu($data = false)
    {
        return $this->ModuleRepository->getAllModules();
    }
}
