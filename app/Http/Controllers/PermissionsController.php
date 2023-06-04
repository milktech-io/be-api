<?php

namespace App\Http\Controllers;

use App\Services\{PermissionsService};
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    protected $PermissionsService;

    /**
     * Constructor of Board Task Controller
     */
    public function __construct(PermissionsService $PermissionsService)
    {
        $this->PermissionsService = $PermissionsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->PermissionsService->search($request->q);
    }
}
