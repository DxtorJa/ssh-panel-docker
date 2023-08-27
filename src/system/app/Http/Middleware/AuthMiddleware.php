<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Admin;

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
        $site = Admin::where('id',1)->first();
        if(!$site)
        {
            return redirect('/install');
        }

        if(Auth::check())
        {
            return $next($request);
        }

        return redirect('/login');

    }
}
