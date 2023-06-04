<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonForceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request)->header('Access-Control-Allow-Origin', '*')
          ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
          ->header('Access-Control-Allow-Headers', ' Origin, Content-Type, Accept, Authorization, X-Request-With')
          ->header('Access-Control-Allow-Credentials', ' true');
    }
}
