<?php

namespace App\Http\Middleware;

use Closure;
use App\Admin;

class installMiddleware
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
        $site = Admin::where('id', 1)->first();
        if(!$site)
        {
            return $next($request);
        }

        return abort(404);

    }
}
