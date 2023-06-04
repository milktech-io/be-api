<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Http\Request;
use Auth;
class JwtMiddleware
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

        if (! $accessToken) {
            return unauthorized('Se requiere token de autenticacion');
        }

        $jwt = Token::check($accessToken);

        if (! $jwt) {
            return expired('El token ha expirado');
        }

        $request->jwt = $jwt[1] ?? null;

        if($jwt[0]){
            $request->user= $jwt[1];
            Auth::login($request->user);
        }

        return $next($request);
    }
}
