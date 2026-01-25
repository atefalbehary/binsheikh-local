<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('api/*')) {
            $locale = $request->header('Accept-Language', 'en');
            $locale = explode(',', $locale)[0];
            if (!in_array($locale, ['en', 'ar'])) {
                $locale = 'en';
            }
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
