<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionController\SwapRequest;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $TransactionService;

    public function __construct(TransactionService $TransactionService)
    {
        $this->TransactionService = $TransactionService;
    }

    public function index(Request $request)
    {
        return $this->TransactionService->query($request->query());
    }

    public function indexAll(Request $request)
    {
        return $this->TransactionService->queryAll($request->query());
    }

    public function swap(SwapRequest $request)
    {
        return $this->TransactionService->swap($request->validated());
    }
}
