<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class adminApi
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

        if(Auth::guard('api')->check()) {
            if(Auth::guard('api')->user()->role == 'admin') {
                return $next($request);
            }

            return \Response::json([
                'error' => true,
                'code' => 401,
                'message' => 'Unauthorized',
                'details' => [
                  'severity' => 'Fatal!',
                  'reason' => 'Your API Level doesn\'t meet the endpoint rules.'
                ],
                'trace' => '#' . str_random(5)
            ], 401, [], JSON_PRETTY_PRINT);
        }

        return \Response::json([
            'error' => true,
            'code' => 401,
            'message' => 'Unauthorized',
            'details' => [
              'severity' => 'Fatal!',
              'reason' => 'Your API Level doesn\'t meet the endpoint rules.'
            ],
            'trace' => '#' . str_random(5)
        ], 401, [], JSON_PRETTY_PRINT);
    }
}
