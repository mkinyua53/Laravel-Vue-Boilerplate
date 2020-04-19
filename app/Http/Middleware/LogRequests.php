<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Carbon\Carbon;

class LogRequests
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
        $response = $next($request);

        $ip = $request->ip();
        $method = $request->method();
        $url = $request->fullUrl();
        $userAgent = $request->userAgent();
        $message = '';
        $time = Carbon::now()->toDateTimeString();
        $path = $request->path();

        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();

            $userId = $user->id;

            \DB::table('access_audits')->insert([
                'ip' => $ip,
                'method' => $method,
                'url' => $url,
                'user_agent' => $userAgent,
                'created_at' => $time,
                'updated_at' => $time,
                'user_id'    => $userId,
                'path'       => $path,
            ]);

            $message = 'API Request - ' . $user->email . ' at IP - ' . $ip . ' via ' . $method . ' to ' . $url . ' using ' . $userAgent . ' from ' . $path;
        } elseif (Auth::guard('web')->check()) {
            $webUser = Auth::guard('web')->user();

            $userId = $webUser->id;

            \DB::table('access_audits')->insert([
                'ip' => $ip,
                'method' => $method,
                'url' => $url,
                'user_agent' => $userAgent,
                'created_at' => $time,
                'updated_at' => $time,
                'user_id'    => $userId,
                'path'       => $path,
            ]);

            $message = 'WEB Request - ' . $webUser->email . ' at IP - ' . $ip . ' via ' . $method . ' to ' . $url . ' using ' . $userAgent . ' from ' . $path;
        } else {
            $message = 'WEB Request - at IP - ' . $ip . ' via ' . $method . ' to ' . $url . ' using ' . $userAgent . ' from ' . $path;
        }

        \Log::useFiles(storage_path('logs/access.log'));
        \Log::info('');
        \Log::info($message);

        return $response;
    }
}
