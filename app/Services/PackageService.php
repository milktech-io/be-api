<?php

namespace App\Services;

use App\Models\Package;
use App\Repositories\PackageRepository;
use Auth;

class PackageService
{
    protected $PackageRepository;

    public function __construct(PackageRepository $PackageRepository)
    {
        $this->PackageRepository = $PackageRepository;
    }

    public function purchasedPackage($data)
    {
        return $this->PackageRepository->purchasedPackage($data);
    }

    public function lastMonth()
    {
        return $this->PackageRepository->lastMonth();
    }

    public function query($query)
    {
        return $this->PackageRepository->query(Package::class, $query);
    }

    public function all()
    {
        return $this->PackageRepository->all();
    }

    public function myPackagesQuery($query)
    {
        return $this->PackageRepository->query(Package::class, $query, function ($query) {
            $query->where('user_id', Auth::user()->id);

            return $query;
        });
    }

    public function loop($data)
    {
        return $this->PackageRepository->loop($data);
    }

    public function loopUser($data)
    {
        return $this->PackageRepository->loopUser($data);
    }

    public function packageSpecial($data)
    {
        return $this->PackageRepository->packageSpecial($data);
    }
}
