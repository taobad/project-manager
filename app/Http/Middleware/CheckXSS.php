<?php

namespace App\Http\Middleware;

use Closure;

class CheckXSS
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('system.enable_xss_check')) {
            if (str_contains($request->getRequestUri(), 'livewire')) {
                return $next($request);
            }
            $input = $request->all();
            array_walk_recursive(
                $input,
                function (&$input) {
                    $input = strip_tags($input, '<strong><a>');
                }
            );
            $request->merge($input);
        }

        return $next($request);
    }
}
