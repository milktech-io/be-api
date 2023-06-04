<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RequestService;
use App\Services\UserDeleteService;
use Auth;
use Illuminate\Http\Request;

class UserDeleteController extends Controller
{
    public function __construct(UserDeleteService $UserDeleteService, RequestService $RequestService)
    {
        $this->RequestService = $RequestService;
        $this->UserDeleteService = $UserDeleteService;
    }

    public function request(Request $request)
    {
        return $this->UserDeleteService->request();
    }

    public function delete(Request $request)
    {
        return $this->RequestService->call(
            $request->password,
            Auth::user(),
            $this->UserDeleteService,
            'deleteAccount'
        );
    }

    public function deleteUser(Request $request, User $user)
    {
        return $this->UserDeleteService->deleteAccountUser($user);
    }
}
