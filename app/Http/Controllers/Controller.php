<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function callAction($method, $parameters)
    {
        DB::beginTransaction();
        try {
            $response = $this->{$method}(...array_values($parameters));
            DB::commit();

            return $response;
        } catch (\Error $e) {
            DB::rollBack();

            return server_error('Hubo un error, no se pudo completar la transacción', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'type' => get_class($e),
            ]);
        }
    }
}
