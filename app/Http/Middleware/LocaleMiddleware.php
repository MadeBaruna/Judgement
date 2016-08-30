<?php

namespace Judgement\Http\Middleware;

use Auth;
use Session;
use Closure;
use Judgement\Judgement;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()) {
            if (Auth::user()->locale) {
                app()->setLocale(Auth::user()->locale);
            } else {
                app()->setLocale(Judgement::lang());
            }
        } elseif ($locale = Session::has('locale')) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
