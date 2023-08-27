<?php

namespace App\Http\Middleware;

use Closure;

class FeatureMiddleware
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
        $feature = $request->segments()[0];
    
        try {
            $feature = app('features')->get($feature);
        } catch( \Exception $e) {
            return abort(404);
        }

        if($feature->status) {
            return $next($request);
        }
    
        return abort(404);
    }
}
