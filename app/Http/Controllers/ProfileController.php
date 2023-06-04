<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileController\ChangePhotoRequest;
use App\Http\Requests\ProfileController\CreateProfileRequest;
use App\Http\Requests\ProfileController\UpdateRequest;
use App\Models\Profile;
use App\Models\User;
use App\Services\AuthService;
use App\Services\ProfileService;
use App\Services\RequestService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $controllerName = __CLASS__;

    protected $ProfileService;

    protected $AuthService;

    public function __construct(
        AuthService $AuthService,
        ProfileService $profileService,
        RequestService $RequestService
    ) {
        $this->profileService = $profileService;
        $this->AuthService = $AuthService;
        $this->RequestService = $RequestService;
    }

    public function checkUrlInvite()
    {
        return $this->profileService->checkUrlInvite();
    }

    public function createProfile(CreateProfileRequest $request)
    {
        return $this->profileService->createProfile($request->validated());
    }

    public function updateMyProfile(UpdateRequest $request)
    {
        return $this->profileService->updateMyProfile($request->validated());
    }

    public function update(UpdateRequest $request, Profile $profile)
    {
        return $this->profileService->updateProfile($profile, $request->validated());
    }

    public function deleteProfile($id)
    {
        return $this->profileService->deleteProfile($id);
    }

    public function deleteWallet()
    {
        return $this->profileService->deleteWallet();
    }

    public function deleteWalletUser(Request $request, User $user)
    {
        return $this->RequestService->call(
            $request->password,
            $user,
            $this->profileService,
            'deleteWallet',
            [$user]
        );
    }

    public function changePhoto(ChangePhotoRequest $request)
    {
        return $this->profileService->changePhoto($request->validated()['photo']);
    }
}
