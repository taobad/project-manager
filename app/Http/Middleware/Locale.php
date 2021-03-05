<?php

namespace App\Http\Middleware;

use App;
use Carbon\Carbon;
use Closure;
use Session;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = 'en';
        if (cache('installed') != false) {
            $locale = defaultLanguage();
        }
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        App::setLocale($locale);
        Carbon::setLocale($locale);
        setlocale(LC_ALL, config('system.default_locale'));
        return $next($request);
    }
}
