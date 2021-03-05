<?php

namespace App\Http\Middleware;

use Closure;

class OverrideConfig
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
        // Config::set([
        // ]);

        return $next($request);
    }
}
