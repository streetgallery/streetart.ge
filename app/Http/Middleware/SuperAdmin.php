<?php

namespace App\Http\Middleware;

use  Auth;

use Closure;

class SuperAdmin
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
        if (Auth::user()->group_role == 'superAdmin') {
            return $next($request);
        }
        abort(403);
    }
}
