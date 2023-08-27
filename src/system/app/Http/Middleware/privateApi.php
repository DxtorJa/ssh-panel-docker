<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class privateApi
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
        if(null != $request->header('X-SSHPanel-Authority'))
        {
            if(null != $request->header('X-SSHPANEL-Agent') && $request->header('X-SSHPANEL-Agent') == 'SSHPanel Apps')
            {
                return $next($request);
            }

            return redirect('/');
        }

        return redirect('/');
    }
}
