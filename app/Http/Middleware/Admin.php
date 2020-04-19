<?php

namespace App\Http\Middleware;

use App\User;
use Auth;
use Closure;

class Admin
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
        $user = Auth::user();

        if (!$user) {
            return (new \Illuminate\Http\Response)->setStatusCode(403, 'UnAuthorized');
        }

        if (!$user->hasAnyRoles(['Developer', 'Admin', 'SuperAdmin', 'UserManager'])) {
            return (new \Illuminate\Http\Response)->setStatusCode(403, 'UnAuthorized');
        }
        return $next($request);
    }
}
