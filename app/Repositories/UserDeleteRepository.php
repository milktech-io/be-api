<?php

namespace App\Repositories;

use App\Models\User;
use App\Services\RequestService;
use Auth;
use DB;

class UserDeleteRepository
{
    public function __construct(RequestService $RequestService)
    {
        $this->RequestService = $RequestService;
    }

    private function conflict()
    {
        return conflict('Tu cuenta tiene paquetes activos y no se puede borrar');
    }

    public function request()
    {
        $canDelete = $this->BusService->dispatch('get', 'plan', '/users-delete/canDelete')->status;

        if (! $canDelete) {
            return $this->conflict();
        }

        $body = 'Haz solicitado eliminar tu cuenta: ingresa la siguiente contraseña donde se requiera';

        return $this->RequestService->store([
            'user_id' => Auth::user()->id,
            'action' => 'deleteAccount',
        ], $body);
    }

    public function deleteAccount($user = null)
    {
        $canDelete = false;

        if ($user) { //deleting from admin
            $canDelete = $this->BusService->dispatch('get', 'plan', '/users-delete/canDelete/'.$user->id)->status;

            if ($canDelete) {
                $response = $this->BusService->dispatch('get', 'plan', '/users-delete/delete/'.$user->id);
            }
        } else { //delete my account
            $canDelete = $this->BusService->dispatch('get', 'plan', '/users-delete/canDelete')->status;

            if ($canDelete) {
                $response = $this->BusService->dispatch('get', 'plan', '/users-delete/delete');
                $user = Auth::user();
            }
        }

        $error = false;
        if (! $canDelete) {
            $error = $this->conflict();
        }

        if (! $response->status) {
            $error = setResponse($response);
        }

        if ($error) {
            return $error;
        }

        $profile = $user->profile;

        $newEmail = $user->email .= '_DELETED_'.uniqid();
        $newUsername = $user->username .= '_DELETED_'.uniqid();

        $user->email = $newEmail;
        $user->username = $newUsername;
        unset($user->roles);

        $user->save();

        $profile->email = $newEmail;
        $profile->save();

        User::whereNull('deleted_at')
            ->where('sponsor_id', $user->id)
            ->update(['sponsor_id' => $user->sponsor_id]);

        $update = [
            'deleted_at' => now(),
        ];

        $user->delete();

        $profile->delete();

        DB::table('kycs')->where('user_id', $user->id)->update($update);
        DB::table('rangue_histories')->where('user_id', $user->id)->update($update);
        DB::table('merges')->where('user_id', $user->id)->update($update);
        DB::table('tokens')->where('user_id', $user->id)->update($update);
        DB::table('requests')->where('user_id', $user->id)->update($update);

        return ok('cuenta eliminada correctamente');
    }
}
