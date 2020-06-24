<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use App\Base\Traits\Authorization;

class SetLocale
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
        $languages = array_keys(config('app.languages'));
        $route = $request->route();
        if (request('change_language')) {
            session()->put('language', request('change_language'));
            $language = request('change_language');
        } elseif (session('language')) {
            $language = session('language');
        } elseif (config('app.locale')) {
            $language = config('app.locale');
        }
    
     
        if (isset($language) && in_array($language, $languages)) {
            app()->setLocale($language);
        }

        return $next($request);
    }
}