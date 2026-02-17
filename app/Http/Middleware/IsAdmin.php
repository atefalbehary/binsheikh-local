<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsAdmin
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
        if (Auth::check()) {
            $user = Auth::user();
            // Allow if legacy admin OR has RBAC role
            if ($user->role == '1' || $user->role_details) {
                return $next($request);
            }
        }
        return redirect()->route('admin.login');
    }
}
