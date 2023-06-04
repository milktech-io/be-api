<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackageController\LoopRequest;
use App\Http\Requests\PackageController\LoopUserRequest;
use App\Http\Requests\PackageController\PurchasedPackageRequest;
use App\Models\{Package};
use App\Services\{PackageService};
use Illuminate\Http\Request;

class PackageController extends Controller
{
    protected $PackageService;

    public function __construct(PackageService $PackageService)
    {
        $this->PackageService = $PackageService;
    }

    public function index(Request $request)
    {
        return $this->PackageService->query($request->query());
    }

    public function myPackages(Request $request)
    {
        return $this->PackageService->myPackagesquery($request->query());
    }

    public function show(Package $package)
    {
        return ok('', $package);
    }

    public function lastMonth()
    {
        return $this->PackageService->lastMonth();
    }

    public function purchasedPackage(PurchasedPackageRequest $request)
    {
        return $this->PackageService->purchasedPackage($request->validated());
    }

    public function loop(LoopRequest $request)
    {
        return $this->PackageService->loop($data);
    }

    public function loopUser(LoopUserRequest $request)
    {
        return $this->PackageService->loopUser($request->validated());
    }

    public function packageSpecial(PurchasedPackageRequest $request)
    {
        return $this->PackageService->packageSpecial($request->validated());
    }
}
