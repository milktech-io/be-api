<?php

namespace App\Repositories;

use App\Models\User;
use Auth;
use DB;

class ReportRepository
{
    protected $BusService;

    protected $constants;

    public function __construct()
    {
        $this->constants = (object) [
            'users_deleted_at' => 'users.deleted_at',
            'users_created_at' => 'users.created_at',
            'sponsors_id' => 'sponsors.id',
        ];
    }

    public function invite($data)
    {
        $result = DB::table('users')
        ->join('users as sponsors', 'users.sponsor_id', $this->constants->sponsors_id)
        ->selectRaw('sponsors.username ,users.email,sponsors.id, count(users.id) as referreds')
        ->groupby($this->constants->sponsors_id)
        ->orderBy('referreds', $data['order'] ?? 'desc');

        if (isset($data['minDate'])) {
            $result->where($this->constants->users_created_at, '>=', $data['minDate']);
        }

        if (isset($data['maxDate'])) {
            $result->where($this->constants->users_created_at, '<=', $data['maxDate']);
        }

        if (isset($data['limit'])) {
            $result->limit($data['limit']);
        }

        if (isset($data['role_id'])) {
            $result->join('model_has_roles', 'model_has_roles.model_id', 'sponsors.user_id');
            $result->where('model_has_roles.role_id', $data['role_id']);
        }

        if (isset($data['user_id'])) {
            $result->where($this->constants->sponsors_id, $data['user_id']);
        }

        if (isset($data['rangue_id'])) {
            $result->where('sponsors.rangue_id', $data['rangue_id']);
        }

        $result->whereNull('sponsors.deleted_at');
        $result->whereNull($this->constants->users_deleted_at);

        return ok('', $result->get());
    }

    public function register($data)
    {
        $result = DB::table('users')
        ->selectRaw('
            CASE when users.is_active=1 THEN count(id) ELSE 0 END as referreds_complete,
            CASE when users.is_active=0 THEN count(id) ELSE 0 END as referreds_incomplete
            ');

        if (isset($data['minDate'])) {
            $result->where($this->constants->users_created_at, '>=', $data['minDate']);
        }

        if (isset($data['maxDate'])) {
            $result->where('users.created_at', '<=', $data['maxDate']);
        }

        if (isset($data['user_id'])) {
            $result->where('users.sponsor_id', $data['user_id']);
        }

        $result->whereNull($this->constants->users_deleted_at);
        $result->whereNull($this->constants->users_deleted_at);

        return ok('', $result->first());
    }

    public function rangues()
    {
        $rangues = DB::table('rangues')
            ->selectRaw('rangues.name, rangues.number, rangues.id')
            ->whereNull('rangues.deleted_at')
            ->get()->groupby('id');

        $result = DB::table('users')
            ->join('rangues', 'rangues.id', 'users.rangue_id')
            ->selectRaw('rangues.id as rangue_id, count(users.id) as users')->groupby('rangues.id')
            ->whereNull('rangues.deleted_at')
            ->whereNull($this->constants->users_deleted_at)->get()->groupby('rangue_id');

        foreach ($rangues as $key => $rangue) {
            $rangue[0]->users = isset($result[$key]) ? $result[$key][0]->users : 0;
            $rangues[$key] = $rangue[0];
        }

        return ok('', $rangues->values());
    }

    //user

    public function inviteUser($data)
    {
        $data['user_id'] = Auth::user()->id;

        return $this->invite($data);
    }

    public function registerUser($data)
    {
        $this->inviteUser($data);
    }

    public function userWallets()
    {
        return ok('', [
            [
                'name' => 'Con wallet',
                'users' => User::where('eth_address', '!=', null)->count(),
            ],
            [
                'name' => 'Sin wallet',
                'users' => User::whereNull('eth_address')->count(),
            ],
        ]);
    }
}
