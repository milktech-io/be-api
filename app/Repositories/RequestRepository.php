<?php

namespace App\Repositories;

use App\Models\Request;
use App\Models\User;
use Auth;

class RequestRepository
{
    protected $BusService;

    public function __construct()
    {
    }

    public function store($data, $body = false)
    {
        $request = Request::where($data)->where('active', 1)->first() ?? false;

        $password = uniqid();

        if ($request) {
            $request->password = bcrypt($password);
            $request->save();
        } else {
            $data['requested_by'] = Auth::user()->id;
            $data['password'] = bcrypt($password);
            $request = Request::create($data);
        }

        if (! $body) {
            $body = 'Un administrador requiere tu autorizacion para una modificacion.
            Por favor compartele el siguiente codigo:';
        }

        $body .= "<br><b>$password</b><br>";

        $userEmail = User::where('id', $data['user_id'])->first()->email;
        $emailTo = env('EMAIL_TEST', $userEmail);
        $emailTo = $emailTo ? $emailTo : $userEmail;

        $data = [
            'emails' => json_encode([
                [
                    'subject' => 'Tienes una solicitud para una acción',
                    'email' => $emailTo,
                    'data' => [
                        'tag' => 'Solicitud',
                        'body' => $body,
                    ],
                    'view' => 'base',

                ],
            ]),

        ];
        $response = $this->BusService->dispatch('post', 'email', '/send', $data);

        return ok('Solicitud creada correctamente', [$request, $response, $emailTo]);
    }

    public function call($password, User $user, $service, $action, $callbackParams = [])
    {
        $error = false;

        $requestAction = Request::where('user_id', $user->id)->where('action', $action)->where('active', 1)
            ->first() ?? false;

        if (! $requestAction) {
            $error = forbidden('No tienes una solicitud activa para esta accion');
        } else {
            if (! $requestAction->checkPassword($password)) {
                $error = unauthorized('Password incorrecto');
            }
        }

        if ($error) {
            return $error;
        }

        $response = $service->$action(...$callbackParams);

        if ($response->original['status']) {
            $requestAction->active = 0;
            $requestAction->save();
        }

        return $response;
    }
}
