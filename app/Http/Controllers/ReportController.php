<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportController\InviteRequest;
use App\Http\Requests\ReportController\InviteUserRequest;
use App\Http\Requests\ReportController\RanguesRequest;
use App\Http\Requests\ReportController\RegisterRequest;
use App\Http\Requests\ReportController\RegisterUserRequest;
use App\Services\ReportService;

class ReportController extends Controller
{
    protected $ReportService;

    public function __construct(ReportService $ReportService)
    {
        $this->ReportService = $ReportService;
    }

    public function invite(InviteRequest $request)
    {
        return $this->ReportService->invite($request->validated());
    }

    public function register(RegisterRequest $request)
    {
        return $this->ReportService->register($request->validated());
    }

    public function rangues(RanguesRequest $request)
    {
        return $this->ReportService->rangues($request->validated());
    }

    public function inviteUser(InviteUserRequest $request)
    {
        return $this->ReportService->inviteUser($request->validated());
    }

    public function registerUser(RegisterUserRequest $request)
    {
        return $this->ReportService->registerUser($request->validated());
    }

    public function userWallets()
    {
        return $this->ReportService->userWallets();
    }
}
