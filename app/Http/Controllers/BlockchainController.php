<?php

namespace App\Http\Controllers;

use App\Services\BlockchainService;
use Illuminate\Http\Request;

class BlockchainController extends Controller
{
    protected $BlockchainService;

    public function __construct(BlockchainService $BlockchainService)
    {
        $this->BlockchainService = $BlockchainService;
    }

    public function swap(Request $request)
    {
        return $this->BlockchainService->swap($request->query());
    }

    public function purchases(Request $request)
    {
        return $this->BlockchainService->purchases($request->query());
    }

    public function transactions(Request $request)
    {
        return $this->BlockchainService->transactions($request->query());
    }
}
