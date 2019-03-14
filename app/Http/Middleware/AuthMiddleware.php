<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\UnauthorizedException;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::check()){
            return $next($request);
        }
        throw new UnauthorizedException();
    }
}
