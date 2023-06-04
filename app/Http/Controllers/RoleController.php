<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleController\StoreRequest;
use App\Http\Requests\RoleController\UpdateRequest;
use App\Services\{RoleService};
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $RoleService;

    /**
     * Constructor of Board Task Controller
     */
    public function __construct(RoleService $RoleService)
    {
        $this->RoleService = $RoleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->RoleService->query($request->input());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store( NotarioStoreRequest $request )
    public function store(StoreRequest $request)
    {
        return $this->RoleService->store($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Role $role)
    {
        return $this->RoleService->find($role->id);
    }

    /**
     * Update the specified role
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Role $role)
    {
        return $this->RoleService->update($role, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Role $role)
    {
        return $this->RoleService->destroy($role);
    }
}
