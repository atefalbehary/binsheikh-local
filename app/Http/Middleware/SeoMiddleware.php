<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SeoMiddleware
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
        $path = '/' . ltrim($request->path(), '/');

        // Check for redirects
        $redirect = \App\Models\SeoRedirect::where('old_url', $path)->first();
        if ($redirect) {
            return redirect($redirect->new_url, $redirect->status_code);
        }

        $response = $next($request);

        // Check for 404
        if ($response->status() == 404) {
            $log = \App\Models\Seo404Log::firstOrNew(['url' => $request->fullUrl()]);
            $log->hits++;
            $log->last_hit_at = now();
            $log->save();
        }

        return $response;
    }

}
