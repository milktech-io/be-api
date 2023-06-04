<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanController\StoreRequest;
use App\Http\Requests\PlanController\UpdateImageRequest;
use App\Http\Requests\PlanController\UpdateRequest;
use App\Models\Plan;
use App\Services\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    protected $PlanService;

    public function __construct(PlanService $PlanService)
    {
        $this->PlanService = $PlanService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->PlanService->query($request->query());
    }

    public function show(Plan $plan)
    {
        return ok('', $plan);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->PlanService->store($request->validated());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Plan $plan)
    {
        return $this->PlanService->update($plan, $request->validated());
    }

    public function updateImage(UpdateImageRequest $request, Plan $plan)
    {
        return $this->PlanService->updateImage($plan, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return ok('Plan eliminado correctamente');
    }
}
