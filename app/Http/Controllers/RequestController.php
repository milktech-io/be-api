<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestController\StoreRequest;
use App\Services\RequestService;

class RequestController extends Controller
{
    public function __construct(RequestService $RequestService)
    {
        $this->RequestService = $RequestService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->RequestService->store($request->validated());
    }
}
