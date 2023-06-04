<?php

namespace App\Services;

use App\Models\Plan;
use App\Repositories\PlanRepository;

class PlanService
{
    protected $PlanRepository;

    public function __construct(PlanRepository $PlanRepository)
    {
        $this->PlanRepository = $PlanRepository;
    }

    public function query($query)
    {
        return $this->PlanRepository->query(Plan::class, $query);
    }

    public function search($data)
    {
        return $this->PlanRepository->search($data);
    }

    public function store($data)
    {
        return $this->PlanRepository->store($data);
    }

    public function update(Plan $plan, $data)
    {
        return $this->PlanRepository->update($plan, $data);
    }

    public function updateImage(Plan $plan, $data)
    {
        return $this->PlanRepository->updateImage($plan, $data);
    }
}
