<?php

namespace App\Repositories;

use App\Models\{Package};
use App\Services\{BusService};
use App\Traits\PaginateRepository;
use Auth;
use Carbon\Carbon;

class PackageRepository
{
    use PaginateRepository;

    protected $BusService;

    public function __construct()
    {
    }

    public function purchasedPackage($data)
    {
        $user = Auth::user();
        $rangue = $user->rangue['number'];
        if ($rangue === null) {
            $user = $this->BusService->dispatch('post', 'administration', '/rangue-upgrade', [
                'id' => $user->id,
            ])->data;
        }
        $fecha = Carbon::now();
        $package = Package::create([
            'user_id' => $data['user_id'],
            'plan_id' => $data['plan_id'],
            'date' => $fecha,
            'price' => $data['price'],
            'currency' => $data['currency'],
        ]);

        return ok('perfect', $package);
    }

    public function lastMonth()
    {
        return ok('', Package::active()->where('date', '>=', date('Y-m-d', strtotime('-1 month')))->get());
    }

    public function all()
    {
        return ok('', Package::active()->get());
    }

    public function loop($data)
    {
        $loop = Package::whereBetween('date', [$data['fecha_inicio'], $data['fecha_fin']])->get();

        return ok('loop', $loop);
    }

    public function loopUser($data)
    {
        $referred = json_decode($data['referred']);
        $loop = Package::whereBetween('date', [$data['fecha_inicio'], $data['fecha_fin']])
        ->whereIn('user_id', $referred->data)
        ->get();

        return ok('loo-user', $loop);
    }

    public function packageSpecial($data)
    {
        $ipAddr = \Config::get('ip');
        $macAddr = \Config::get('mac');

        $user = Auth::user();
        $user = $this->BusService->dispatch('put', 'administration', "/users/special/$user->id", [
            'is_special' => 1,
        ])->data;

        $fecha = Carbon::now();
        $package = Package::create([
            'user_id' => $data['user_id'],
            'plan_id' => $data['plan_id'],
            'date' => $fecha,
            'price' => $data['price'],
            'currency' => $data['currency'],
            'ip_address' => $ipAddr,
            'mac_address' => $macAddr,
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
        ]);

        $data = [
            'package' => $package,
            'user' => $user,
        ];

        return ok('perfect', $data);
    }
}
