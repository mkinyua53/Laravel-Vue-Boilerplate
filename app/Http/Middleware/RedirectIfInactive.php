<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Response;
use App\Events\UserInactive;
use App\User;
use Carbon\Carbon;

class RedirectIfInactive
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
        if (Auth::guard('api')->check() || Auth::guard('web')->check()) {

            if (Auth::guard('api')->check()) {
                $user = Auth::guard('api')->user();
            }
            if (Auth::guard('web')->check()) {
                $user = Auth::guard('web')->user();
            }
            if ($user && !$user->active) {
                // check if it has been 48hours
                $uu = User::find($user->id);
                $created = Carbon::parse($user->created_at);
                $now = Carbon::now();
                $diff = $now->diffInHours($created);
                if ($diff < 48) {
                    return $next($request);
                }
                // event(new UserInactive($user));
                return (new Response)->setStatusCode(310, 'User Inactive');
            }
        }
        return $next($request);
    }
}
