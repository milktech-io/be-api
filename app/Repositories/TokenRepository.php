<?php

namespace App\Repositories;

use App\Models\{Token};
use Carbon\Carbon;

class TokenRepository
{
    public function getActive()
    {
        return ok('', Token::with('user')->where('revoked', 0)->where('expires_at', '>', Carbon::today())->get());
    }

    public function revoke($token)
    {
        $token->revoke();

        return ok('Sesion cerrada correctamente');
    }
}
