<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Token;

class JwtBackofficeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $accessToken = $request->bearerToken();

        $token = Token::check($accessToken);

        if($token) {
            $jwt = $token[1];
            if (isset($jwt['frontend']) && strval($jwt['frontend']) == 'backoffice') {
                return $next($request);
            }
        }
        return forbidden('No haz enviado una peticion firmada');
    }
}
