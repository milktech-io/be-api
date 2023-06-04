<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleController\{
    RangueRequest
};
use App\Services\{ModuleService};

class ModuleController extends Controller
{
    protected $ModuleService;

    public function __construct(ModuleService $ModuleService)
    {
        $this->ModuleService = $ModuleService;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->ModuleService->getAllModules();
    }

    public function user()
    {
        return $this->ModuleService->getMenu();
    }

    public function rangue(RangueRequest $request)
    {
        return $this->ModuleService->getMenu($request->validated());
    }
}
