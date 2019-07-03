<?php

namespace App\Http\Middleware;

use Closure;
use LaravelLocalization;

class LocalizeApiRequests
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
        if(!empty(\Session::get('locale'))) {
            LaravelLocalization::setLocale(\Session::get('locale'));
        } else {
            if(!empty($request->header('X-App-Locale'))) {
                LaravelLocalization::setLocale($request->header('X-App-Locale'));
            } else {
                LaravelLocalization::setLocale(config('app.locale'));
            }
        }
        return $next($request);
    }
}